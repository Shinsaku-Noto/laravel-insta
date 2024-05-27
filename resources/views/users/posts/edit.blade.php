@extends('layouts.app')

@section('title', 'create_post')

@section('content')
<form action="{{ route('post.update', $post) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <span class="">Category</span><span class="text-secondary"> (up to 3)</span>
    <div class="mt-1">

        @foreach($categories as $category)
                @if(in_array($category->id, $pivots))
                    <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->id }}" checked>

                @else
                    <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->id }}">

                @endif
        <label class="form-check-label me-3">{{ $category->name }}</label>
        @endforeach
    </div>

    <div class="mt-4">
        <p class="mb-1">Description</p>
        <textarea class="form-control" name="description" rows="3" value="">{{ $post->description }}</textarea>
    </div>

    <div class="mt-4 w-50">
        <p class="mb-1">Image</p>
        <img src="{{ $post->image }}" class="object-fit-cover w-100" alt="">
        <input type="file" class="form-control mt-3" name="image">
        <p class="mb-0 text-secondary">The acceptable formats are jpeg, jpg, png and gif only</p>
        <p class="mb-0 text-secondary">Max file size is 1048kb</p>
    </div>

    <button type="submit" class="btn btn-warning mt-3 px-5">Save</button>
</form>


@endsection
