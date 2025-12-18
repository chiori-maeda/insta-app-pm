<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class LikeController extends Controller
{
    private $like;

    public function __construct(Like $like) {
        $this->like = $like;
    }

    public function store($post_id)
{
    Like::firstOrCreate([
        'user_id' => Auth::id(),
        'post_id' => $post_id,
    ]);

    if (request()->ajax()) {
        $count = Like::where('post_id', $post_id)->count();
        return response()->json(['liked' => true, 'count' => $count]);
    }

    return redirect()->back();
}

public function destroy($post_id)
{
    Like::where('user_id', Auth::id())
        ->where('post_id', $post_id)
        ->delete();

    if (request()->ajax()) {
        $count = Like::where('post_id', $post_id)->count();
        return response()->json(['liked' => false, 'count' => $count]);
    }

    return redirect()->back();
}   
}
