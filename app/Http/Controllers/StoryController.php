<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Story;
use App\Models\StoryView;

class StoryController extends Controller
{
    private $story;

    public function __construct(Story $story)
    {
        $this->story = $story;
    }

    public function create()
    {
        return view('users.stories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'story_image' => 'required|mimes:jpg,jpeg,png,mp4,mov|max:20000'
        ]);

        $this->story->user_id = Auth::user()->id;
        $this->story->story_image = 'data:image/' . $request->story_image->extension() . ';base64,' . base64_encode(file_get_contents($request->story_image));
        $this->story->expires_at = now()->addMinutes(30);
        $this->story->save();

        return redirect()->route('index');
    }

    public function show($id)
    {
        $story = Story::with(['user', 'views'])->findOrFail($id);

        $viewer = Auth::user();
        $owner = $story->user;

        // ❌ Block expired stories
        if ($story->expires_at <= now()) {
            abort(404);
        }

        // ❌ Block if not owner AND not following
        if (
            $viewer->id !== $owner->id &&
            !$viewer->following()->where('following_id', $owner->id)->exists()
        ) {
            abort(403);
        }

        // ✅ Mark as viewed (IMPORTANT)
        if ($viewer->id !== $owner->id) {
            StoryView::firstOrCreate([
                'story_id' => $story->id,
                'user_id' => $viewer->id,
            ]);
        }

        // ✅ Next story (same user)
        $nextStory = Story::where('user_id', $owner->id)
            ->where('id', '>', $story->id)
            ->where('expires_at', '>', now())
            ->orderBy('id')
            ->first();

        // ✅ If none, go to next followed user
        if (!$nextStory) {
            $followedIds = $viewer->following()->pluck('following_id')->toArray();
            $followedIds[] = $viewer->id;

            $nextStory = Story::whereIn('user_id', $followedIds)
                ->where('expires_at', '>', now())
                ->where('id', '!=', $story->id)
                ->orderBy('created_at')
                ->first();
        }

        return view('users.stories.index', compact('story', 'nextStory'));
    }



    public function destroy($id)
    {
        $story = $this->story->findOrFail($id);
        $story->delete();

        return redirect()->route('index');
    }

    public function markAsViewed(Story $story)
    {
        $viewer = Auth::user();
        $owner = $story->user;

        // ❌ Expired story
        if ($story->expires_at <= now()) {
            return response()->json(['error' => 'Expired'], 404);
        }

        // ❌ Viewer is not allowed (one-way follow)
        if (
            $viewer->id !== $owner->id &&
            !$viewer->following()->where('following_id', $owner->id)->exists()
        ) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // ✅ Save view (no duplicates)
        StoryView::firstOrCreate([
            'story_id' => $story->id,
            'user_id' => $viewer->id,
        ]);

        return response()->json(['success' => true]);
    }

}
