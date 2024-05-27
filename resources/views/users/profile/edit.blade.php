@extends('layouts.app')

@section('title', 'show_post')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-8 bg-white shadow p-5">
            <form action="{{ route('profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <p class="fs-3 text-secondary">Update Profile</p>
                <div class="row">
                    <div class="col-4">
                        @if ($user->avatar)
                            <img src="#" alt="#" class="rounded-circle">
                        @else
                        <div class="">
                            <i class="fa-solid fa-circle-user text-secondary fa-10x"></i>
                        </div>

                        @endif
                    </div>
                    <div class="col-8 mt-5">
                        <input type="file" name="avatar" class="mt-2">
                        <p class="mb-0 mt-1 text-secondary">The acceptable formats are jpeg, jpg, png and gif only</p>
                        <p class="mb-0 text-secondary">Max file size is 1048kb</p>
                    </div>
                </div>
                <p class="mb-1 mt-3">Name</p>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                <p class="mb-1 mt-3">E-mail address</p>
                <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                <p class="mb-1 mt-3">Introduction</p>
                <textarea name="introduction" id="" cols="10" rows="5" class="form-control" placeholder="Describe yourself">{{ $user->introduction }}</textarea>
                <button type="submit" class="btn btn-warning w-100 mt-4">Save</button>

            </form>

        </div>
    </div>


</div>


@endsection
