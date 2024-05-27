<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Auth;

class HomeController extends Controller
{

    private $post, $user;
    public function __construct(Post $post, User $user)
    {
        $this->middleware('auth');

        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = $this->followedPosts();
        $users = $this->isNotFollowing();

        return view('users.home')
                ->with('posts', $posts)
                ->with('users', $users);
    }

    public function isNotFollowing()
    {
        $users = $this->user->all();

        $notFollowedUser = [];

        foreach($users as $user){
            if(!$user->isFollowed() && $user->id != Auth::id()){
                $notFollowedUser[] = $user;
            }
        }

        return $notFollowedUser;
    }

    public function followedPosts()
    {
        $posts = $this->post->latest()->get();

        $followedPosts = [];

        foreach($posts as $post){
            if($post->user->isFollowed() || $post->user->id == Auth::id()){
                $followedPosts[] = $post;
            }
        }

        return $followedPosts;
    }

    public function search(Request $request)
    {
        $search = $request->search;

        $users = $this->user->where('name', 'like', '%'.$search.'%')->get();

        return view('users.search')
                ->with('users', $users)
                ->with('search', $search);
    }

    public function seeAll()
    {
        $users = $this->user->all();

        return view('users.seeAll')
                ->with('users', $users);
    }



}
