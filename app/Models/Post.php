<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Post extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
    }

    public function Comment(){
        return $this->hasMany(Comment::class)->latest();
    }

    public function Like(){
        return $this->hasMany(Like::class);
    }

    public function isliked(){
        return $this->Like()->where('user_id', Auth::id())->exists();
    }
}
