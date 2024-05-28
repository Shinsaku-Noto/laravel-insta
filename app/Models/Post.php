<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
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
