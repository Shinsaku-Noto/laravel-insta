@extends('layouts.app')

@section('title', 'search')

@section('content')

    <div class="container">
        <div class="w-50 m-auto">
            <p class="text-secondary">Suggested</p>
        </div>

        <ul class="list-unstyled w-50 m-auto">
            @forelse ($users as $user)
                @if(!$user->isFollowed() && $user->id != Auth::id())
                    <li class="my-3">
                        <div class="row">
                            <div class="col-2 d-flex justify-content-end align-items-center pe-0">
                                <a href="{{ route('profile.show', $user ) }}" class="">
                                    @if ($user->avatar)
                                        <img src="{{ $user->avatar }}" alt="#" class="rounded-circle avatar-md">
                                    @else
                                        <i class="fa-solid fa-circle-user text-dark icon-md"></i>
                                    @endif
                                </a>
                            </div>
                            <div class="col-7">
                                <a href="{{ route('profile.show', $user ) }}" class="text-decoration-none text-black ms-2 mb-0 pt-3 pb-1">{{ $user->name }}</a>
                                <p class="mb-0 ms-2 text-secondary">{{ $user->email }}</p>
                                <p class="mb-0 ms-2 text-secondary">{{ $user->follower->count() }} followers</p>
                            </div>
                            <div class="col-3 d-flex align-items-center">
                                <form action="{{ route('follow.store') }}" method="post" class="mb-0">
                                    @csrf
                                    <input type="hidden" value="{{ $user->id }}" name="following_id">
                                    <button type="submit" class="btn text-primary btn-sm">Follow</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endif
            @empty

                <p class="text-secondary fs-4 text-center">No Users Found.</p>

            @endforelse
        </ul>

    </div>




@endsection
