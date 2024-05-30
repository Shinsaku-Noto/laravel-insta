@extends('layouts.app')

@section('title', 'create_post')

@section('content')

<form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <span class="">Category</span><span class="text-secondary"> (up to 3)</span>
    <div class="mt-1">
        @foreach($categories as $category)
        <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->id }}">
        <label class="form-check-label me-3">{{ $category->name }}</label>
        @endforeach
        @if ($errors->any())
            <div>
                <ul class="p-0">
                    @foreach ($errors->all() as $error)
                        <li class="list-unstyled text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="mt-4">
        <p class="mb-1">Description</p>
        <textarea class="form-control" name="description" rows="3" placeholder="What's on your mind?"></textarea>
    </div>

    <div class="mt-4">
        <p class="mb-1">Image</p>
        <input type="file" class="form-control" name="image" required>
        <p class="mb-0 text-secondary">The acceptable formats are jpeg, jpg, png and gif only</p>
        <p class="mb-0 text-secondary">Max file size is 1048kb</p>
    </div>

    <button type="submit" class="btn btn-primary mt-3 px-5">Post</button>
</form>


@endsection
