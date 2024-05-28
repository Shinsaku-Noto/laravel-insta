<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    public function post() {
        return $this->hasMany(Post::class)->withTrashed();
    }

    public function Comment(){
        return $this->hasMany(Comment::class);
    }

    public function Like(){
        return $this->hasMany(Like::class);
    }

    // getting all of your followers
    public function follower(){
        return $this->hasMany(Follow::class, 'following_id');
    }

    // getting all of your following
    public function following(){
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function isFollowed(){
        return $this->Follower()->where('follower_id', Auth::id())->exists();
    }


    // public function isFollowing(){
    //     return $this->Following()->where('following_id', Auth::id())->exists();
    // }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
