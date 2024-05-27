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
                <p class="me-4">{{ $user->post->count() }} post</p>
                <a href="{{ route('profile.follower', $user) }}" class="text-decoration-none text-black me-4">{{ $user->follower()->count() }} follower</a>
                <a href="{{ route('profile.following', $user) }}" class="text-decoration-none text-black me-4">{{ $user->following()->count() }} following</a>
            </div>
            <p>{{ $user->introduction }}</p>
        </div>
    </div>

    <div class="row mt-5">
        @forelse($user->post as $post)
        <div class="col-4">
            <form action="{{ route('post.edit', $post) }}" method="post">
                @csrf
                @method('GET')
                <button type="submit" class="btn p-0 w-100 ratio ratio-1x1">
                    <img class="object-fit-cover w-100" src="{{ $post->image }}" alt="">
                </button>
            </form>

        </div>
        @empty
        @endforelse
    </div>
</div>


@endsection
