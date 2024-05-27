@extends('layouts.app')

@section('title', 'admin')

@section('content')

<table class="table table-hover align-middle">
    <tr class="table-primary table-opacity-25">
        <th></th>
        <th></th>
        <th>CATEGORY</th>
        <th>OWNER</th>
        <th>CREATED AT</th>
        <th>STATUS</th>
        <th></th>
    </tr>
    @forelse ($posts as $post)
        <tr>
            <td class="text-center">{{ $post->id }}</td>
            <td>
                <a href="{{ route('post.show', $post) }}">
                    <img class="d-block mx-auto image-lg" src="{{ $post->image }}" alt="">
                </a>
            </td>
            <td>
                @foreach ($post->categoryPost as $category)
                    <span class="badge bg-secondary bg-opacity-50">{{ $category->category->name }}</span>
                @endforeach
            </td>
            <td>
                <p class="mb-0">{{ $post->user->name }}</p>
            </td>
            <td>
                <p class="mb-0">{{ $post->created_at }}</p>
            </td>
            <td>
                <p class="mb-0"><i class="fa-solid fa-circle text-primary"></i> Visible</p>
            </td>
            <td>
                <button type="button" class="btn dropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis"></i></button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" class="dropdown-item text-danger"><i class="fa-solid fa-eye-slash"></i> Hide Post {{ $post->id }}</a>
                        </li>
                    </ul>
            </td>
        </tr>
    @empty

    @endforelse
</table>

@endsection
