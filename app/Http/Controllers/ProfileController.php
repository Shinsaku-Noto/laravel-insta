<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class ProfileController extends Controller
{
    //

    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($id)
    {
        $user = $this->user->findOrFail($id);
        // $posts = $this->post->where('user_id', $user->id)->get();

        return view('users.profile.show')
                ->with('user', $user);

    }

    public function follower($id)
    {
        $user = $this->user->findOrFail($id);
        // $followers = $this->isFollowing();

        return view('users.profile.follower')
                ->with('user', $user);
    }

    public function following($id)
    {
        $user = $this->user->findOrFail($id);
        // $user->followings = $this->isFollowed();

        return view('users.profile.following')
                ->with('user', $user);
    }

    // public function isFollowing()
    // {
    //     $users = $this->user->all();

    //     $FollowingUser = [];

    //     foreach($users as $user){
    //         if($user->isFollowing()){
    //             $FollowingUser[] = $user;
    //         }
    //     }

    //     return $FollowingUser;
    // }

    // public function isFollowed()
    // {
    //     $users = $this->user->all();

    //     $FollowedUser = [];

    //     foreach($users as $user){
    //         if($user->isFollowed()){
    //             $FollowedUser[] = $user;
    //         }
    //     }

    //     return $FollowedUser;
    // }



    public function edit($id)
    {
        $user = User::find($id);

        return view('users.profile.edit')
                ->with('user', $user);
    }

    public function update(Request $request,$id)
    {

        $user = $this->user->findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->password = $user->password;
        if($request->introduction){
            $user->introduction = $request->introduction;
        }
        if($request->avatar){
            $user->avatar = 'data:image/'.$request->avatar->extension().';base64,'.base64_encode(file_get_contents($request->avatar));
        }
        $user->save();

        return redirect()->route('profile.show', $id);
    }
}
