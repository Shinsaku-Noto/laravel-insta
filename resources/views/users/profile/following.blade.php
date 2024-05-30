@extends('layouts.app')

@section('title', 'show_post')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-4">
            @if ($user->avatar)
                <div class="d-flex justify-content-center w-50 m-auto shadow bg-white rounded-circle">
                    <img src="{{ $user->avatar }}" alt="#" class="rounded-circle avatar-lg p-1 ">
                </div>
            @else
            <div class="d-flex justify-content-center">
                <i class="fa-solid fa-circle-user text-secondary fa-10x"></i>
            </div>

            @endif
        </div>
        <div class="col-8">
            <div class="d-flex">
                <p class="display-6">{{ $user->name }}</p>
                @if ($user->id == Auth::id())
                    <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-outline-secondary btn-sm h-50 mt-2 ms-4">Edit Profile</a>
                @else
                    @if($user->isFollowed())
                        <form action="{{ route('follow.destroy', $user->id) }}" method="post" class="mb-0">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-outline-secondary btn-sm h-50 mt-2 ms-4">Unfollow</button>
                        </form>
                    @else
                        <form action="{{ route('follow.store') }}" method="post" class="mb-0">
                            @csrf
                            <input type="hidden" value="{{ $user->id }}" name="following_id">
                            <button type="submit" class="btn btn-primary btn-sm h-50 mt-2 ms-4">follow</button>
                        </form>
                    @endif
                @endif
            </div>
            <div class="d-flex">
                <a href="{{ route('profile.show', $user) }}" class="text-decoration-none text-black me-4">{{ $user->post->count() }} post</a>
                <a href="{{ route('profile.follower', $user) }}" class="text-decoration-none text-black me-4">{{ $user->follower()->count() }} follower</a>
                <a href="{{ route('profile.following', $user) }}" class="text-decoration-none text-black me-4">{{ $user->following()->count() }} following</a>
            </div>
            <p>{{ $user->introduction }}</p>
        </div>
    </div>

    <div class="row justify-content-center my-5">
        <div class="col-4">
            <ul class="ps-0">
                @if($user->following)
                    <li class="d-flex justify-content-center">
                        <p class="text-secondary display-6">Following</p>
                    </li>
                @else
                    <li class="d-flex justify-content-center">
                        <p class="text-secondary fs-4">No following Yet!!</p>
                    </li>
                @endif

                @forelse ($user->following as $following)
                    <li class="d-flex justify-content-between align-items-center mt-3">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('profile.show', $following->following ) }}" class="">
                                @if ($following->following->avatar)
                                    <img src="{{ $following->following->avatar }}" alt="#" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                                @endif
                            </a>
                            <a href="{{ route('profile.show', $following->following ) }}" class="text-decoration-none text-black ms-2 mb-0">{{ $following->following->name }}</a>
                        </div>
                        @if($following->following->id != Auth::id())
                            @if($following->following->isFollowed())
                                <form action="{{ route('follow.destroy', $following->following) }}" method="post" class="mb-0">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn text-secondary btn-sm h-50 ms-4">Unfollow</button>
                                </form>
                            @else
                                <form action="{{ route('follow.store') }}" method="post" class="mb-0">
                                    @csrf
                                    <input type="hidden" value="{{ $following->following->id }}" name="following_id">
                                    <button type="submit" class="btn text-primary btn-sm">Follow</button>
                                </form>
                            @endif
                        @endif
                    </li>
                @empty
                @endforelse
            </ul>
        </div>
    </div>
</div>


@endsection
