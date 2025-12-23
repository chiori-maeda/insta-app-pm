<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class ProfileTabs extends Component
{
    public User $user;
    public string $tab = 'posts';

    public function mount($userId)
    {
        $this->user = User::with('posts', 'followers', 'following')->find($userId);
    }

    public function switchTab($tab)
    {
        $this->tab = $tab;
    }

    public function render()
    {
        return view('livewire.profile-tabs');
    }
}


