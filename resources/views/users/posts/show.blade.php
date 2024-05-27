@extends('layouts.app')

@section('title', 'show_post')

@section('content')

<div class="container">
    <div class="border w-100 overflow-hidden shadow">
        <div class="row">
            <div class="col-8 p-0">
                <img src="{{ $post->image }}" class="object-fit-cover w-100" alt="">
            </div>
            <div class="col-4 ps-0 bg-white">
                <div class="p-3 d-flex justify-content-between border-bottom ">
                    <div class="ps-2 d-flex">
                        <a href="#" class="pt-1">
                            @if ($post->user->avatar)
                                <img src="{{ $post->user->avatar }}" alt="#" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                            @endif
                        </a>
                        <p class="ms-2 mb-0 py-2">{{ $post->user->name }}</p>
                    </div>
                    <div class="dropdown">
                        <button href="#" class="nav-link p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <ul class="dropdown-menu">
                            @if ($post->user->id == Auth::id())
                                <li>
                                    <form action="{{ route('post.edit', $post) }}" method="post">
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class="btn">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <button type="button" class="btn text-danger" data-bs-toggle="modal" data-bs-target="#delete"><i class="fa-regular fa-trash-can"></i> Delete</button>
                                </li>
                            @else
                                <li><a class="dropdown-item text-danger" href="#">Unfollow</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="px-4 pt-1">
                    <div class="mt-2 d-flex justify-content-between">
                        <div class="mb-0 d-flex">
                            <form action="#" method="post">
                                @csrf
                                <button type="submit" class="btn p-0"><i class="fa-regular fa-heart fa-2x"></i></button>
                            </form>
                            <p class="m-1 ms-3">0</p>
                        </div>
                        <div class="mx-3 d-flex">
                            @foreach ($post->categoryPost as $pivot)
                                <div class="m-1 ms-1 mb-4 badge bg-secondary bg-opacity-25 text-white">{{ $pivot->category->name }}</div>
                            @endforeach

                        </div>

                    </div>

                    <div class="my-1">
                        <p class="mb-0"><span class="fw-bold me-2">{{ $post->user->name }}</span>{{ $post->description }}</p>
                    </div>

                    <p class="mb-0 text-secondary">
                        {{ $post->created_at->format('F d, Y') }}
                    </p>

                    <div class="my-3">
                        <form action="{{ route('comment.store') }}" method="post">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="post_id" value="{{ $post->id }}" hidden>
                                <textarea class="form-control" name="comment" cols="30" rows="1" placeholder="Add a comment..."></textarea>
                                <button type="submit" class="btn btn-outline-secondary">Post</button>
                            </div>
                        </form>
                    </div>

                    {{-- comments --}}
                    @if($post->Comment)
                        @foreach ($post->Comment as $comment)
                            <div class="bg-light mb-2">
                                <div class="my-1 mx-3 pt-1">
                                    <p class="mb-0 fs-6"><span class="fw-bold me-2">{{ $comment->user->name }}</span>{{ $comment->comments }}</p>
                                </div>
                                <div class="mx-3 my-0 text-secondary d-flex">
                                    <p class="mb-0">{{ $comment->created_at->format('F d, Y') }}</p>
                                    @if($comment->user->id == Auth::id())
                                        <form action="{{ route('comment.destroy', $comment) }}" method="post" class="mb-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn text-decoration-none text-danger ms-2 p-0">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</div>


@endsection

{{-- delete Modal --}}
<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border border-danger">
        <div class="modal-header border-bottom border-danger">
          <h1 class="modal-title fs-5 text-danger" id="exampleModalLabel"><i class="fa-solid fa-circle-exclamation"></i> Delete Post</h1>
        </div>
        <div class="modal-body p-3 pb-0">
            <p>Are you sure you want to delete this post?</p>
            <img src="{{ $post->image }}" class="object-fit-cover" style="width: 9rem; height:9rem;" alt="">
            <p class="mt-1">{{ $post->description }}</p>
            <div class="d-flex justify-content-end">
                <div class="me-1">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                </div>
                <form action="{{ route('post.destroy', $post) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>

        </div>
      </div>
    </div>
  </div>
