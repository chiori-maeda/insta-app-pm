<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Story;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $post;
    private $user;
    private $story;
    public function __construct(Post $post, User $user, Story $story)
    {
        $this->post = $post;
        $this->user = $user;
        $this->story = $story;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $all_posts = $this->post->latest()->get();
        // return view('users.home')->with('all_posts', $all_posts);
        $home_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();
        // $hasStory= Auth::user()->stories->where('expires_at','>',now())->exists();

        // $user = User::whereHas('stories', function ($query) {
        // $query->where('expires_at', '>', now());
        // })->get();
        // dd($this->user->stories());
        // $users = $this->user->get();
        // $user = $this->create();

        // $stories = Story::where('created_at', '>=', now()->subHours(24))
        //     ->with('user')
        //     ->latest()
        //     ->get()
        //     ->groupBy('user_id');

        // // 🟣 自分のストーリーだけ取得（過去24時間以内）
        // $myStories = auth()->user()
        //     ->stories()
        //     ->where('created_at', '>=', now()->subHours(24))
        //     ->latest()
        //     ->get();

        $followed_user_ids = Auth::user()->following()->pluck('following_id')->toArray();
        $followed_user_ids[] = Auth::id();

        $stories = Story::where('expires_at', '>', now())
            ->whereIn('user_id', $followed_user_ids)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();


        $home_stories = $stories->groupBy('user_id');
        return view('users.home')
            ->with('home_posts', $home_posts)
            ->with('suggested_users', $suggested_users)
            ->with('home_stories', $home_stories);
        // ->with('hasStory',$hasStory);

    }

    // public function create() {
    //     // dd(Auth::user()->id);
    //    return view('users.story.create');
    // }


    #Get the posts of the users that the Auth user is following
    public function getHomePosts()
    {
        $all_posts = $this->post->latest()->get();
        $home_posts = [];

        foreach ($all_posts as $post) {
            if ($post->user->isFollowed() || $post->user->id === Auth::user()->id) {
                $home_posts[] = $post;
            }
        }

        return $home_posts;
    }

    #Get the users that Auth user is not following
    public function getSuggestedUsers()
    {
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach ($all_users as $user) {
            if (!$user->isFollowed()) {
                $suggested_users[] = $user;
            }
        }

        return $suggested_users;
    }

    public function search(Request $request)
    {
        $users = $this->user->where('name', 'like', '%' . $request->search . '%')->get();
        return view('users.search')->with('users', $users)->with('search', $request->search);
    }
}
