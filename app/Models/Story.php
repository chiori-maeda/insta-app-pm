<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Story extends Model
{
    // protected $fillable = [
    //     'user_id',
    //     'image_path',
    //     'text',
    //     'expires_at'
    // ];

    // protected $dates = ['expires_at'];
    // protected $casts = [
    //     'expires_at' => 'datetime',
    // ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // public function scopeActive($query)
    // {
    //     return $query->where('expires_at', '>', now());
    // }

    // public function views()
    // {
    //     return $this->hasMany(StoryView::class);
    // }

    // public function getIsReadAttribute()
    // {
    //     return $this->views->contains('user_id', Auth::id());
    // }

    protected $fillable = [
        'user_id',
        'content',
        'expires_at',
    ];

    public function user() {
       return $this->belongsTo(User::class)->withTrashed();
    }

    public function views()
    {
        return $this->hasMany(StoryView::class);
    }
}
