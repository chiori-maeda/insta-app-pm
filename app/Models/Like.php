<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $timestamps = false;
    // App\Models\Like.php
    protected $fillable = ['user_id', 'post_id'];

}
