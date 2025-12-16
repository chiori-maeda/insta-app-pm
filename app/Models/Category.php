<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    #To get the categories(display the categories)
    public function categoryPost() {
        return $this->hasMany(CategoryPost::class);
    }
}
