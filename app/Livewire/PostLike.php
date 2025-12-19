<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostLike extends Component
{
    public Post $post;
    public bool $liked = false;
    public int $likesCount = 0;

    public function mount(Post $post)
    {
        $this->liked = $post->isLiked();
        $this->likesCount = $post->likes()->count();
    }

    public function toggleLike()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->liked) {
            $this->post->likes()
                ->where('user_id', Auth::id())
                ->delete();

            $this->liked = false;
            $this->likesCount--;
        } else {
            $this->post->likes()->create([
                'user_id' => Auth::id(),
            ]);

            $this->liked = true;
            $this->likesCount++;
        }
    }

    public function render()
    {
        return view('livewire.post-like');
    }
}
