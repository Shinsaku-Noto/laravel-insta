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
                @if($post->categoryPost->isEmpty())
                    <span class="badge bg-black">Uncategorized</span>
                @else
                    @foreach ($post->categoryPost as $category)
                        <span class="badge bg-secondary bg-opacity-50">{{ $category->category->name }}</span>
                    @endforeach
                @endif
            </td>
            <td>
                <p class="mb-0">{{ $post->user->name }}</p>
            </td>
            <td>
                <p class="mb-0">{{ $post->created_at }}</p>
            </td>
            <td>
                @if($post->deleted_at)
                    <p class="mb-0"><i class="fa-solid fa-circle-minus text-secondary"></i> Hidden</p>
                @else
                    <p class="mb-0"><i class="fa-solid fa-circle text-primary"></i> Visible</p>
                @endif
            </td>
            <td>
                <button type="button" class="btn dropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis"></i></button>
                    <ul class="dropdown-menu">
                        <li>
                            @if($post->deleted_at)
                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#unhide-{{ $post->id }}">
                                    <i class="fa-solid fa-eye"></i> Unhide Post {{ $post->id }}
                                </button>
                            @else
                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-{{ $post->id }}">
                                    <i class="fa-solid fa-eye-slash"></i> Hide Post {{ $post->id }}
                                </button>
                            @endif
                        </li>
                    </ul>
            </td>
        </tr>

<!-- Unhide Modal -->
<div class="modal fade" id="unhide-{{ $post->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-primary">
        <div class="modal-header border-primary">
          <h1 class="modal-title fs-5 text-primary" id="exampleModalLabel"><i class="fa-solid fa-user-check"></i> Unhide Post</h1>
        </div>
        <div class="modal-body">
          Are you sure you want to unhide this post?
          <div class="mt-3">
            <img src="{{ $post->image }}" alt="" class="image-lg">
            <p class="mt-1">{{ $post->description }}</p>
          </div>
        </div>
        <div class="modal-footer border-0">
            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Close</button>
            <form action="{{ route('admin.posts.restore', $post->id) }}" method="post" class="m-0">
                @csrf
                @method('GET')
                <button type="submit" class="btn btn-primary btn-sm">
                    Unhide
                </button>
            </form>
          </div>
      </div>
    </div>
  </div>

<!-- Hide Modal -->
<div class="modal fade" id="hide-{{ $post->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-danger">
        <div class="modal-header border-danger">
          <h1 class="modal-title fs-5 text-danger" id="exampleModalLabel"><i class="fa-solid fa-user-slash"></i> Hide Post</h1>
        </div>
        <div class="modal-body">
            Are you sure you want to hide this post?
            <div class="mt-3">
              <img src="{{ $post->image }}" alt="" class="image-lg">
              <p class="mt-1">{{ $post->description }}</p>
            </div>
          </div>
        <div class="modal-footer border-0">
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Close</button>
            <form action="{{ route('admin.posts.softdelete', $post->id) }}" method="post" class="m-0">
                @csrf
                @method('GET')
                <button type="submit" class="btn btn-danger btn-sm">
                    Hide
                </button>
            </form>
          </div>
      </div>
    </div>
  </div>
    @empty

    @endforelse
</table>
<div class="d-flex justify-content-center">
    <p class="">{{ $posts->links() }}</p>
</div>

@endsection
