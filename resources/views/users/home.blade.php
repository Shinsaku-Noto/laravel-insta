@extends('layouts.app')

@section('title', 'home')

@section('content')

<div class="row">
    <div class="col-8">
        @forelse($posts as $post)
            @if($post->user->isFollowed() || $post->user->id == Auth::id())
                <div class="m-2 border rounded-3 overflow-hidden">
                    {{-- header --}}
                    <div class="p-3 d-flex justify-content-between bg-white">
                        <div class="ps-2 d-flex">
                            <a href="{{ route('profile.show', $post->user) }}" class="pt-1">
                                @if ($post->user->avatar)
                                    <img src="{{ $post->user->avatar }}" alt="#" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                                @endif
                            </a>
                            <a href="{{ route('profile.show', $post->user) }}" class="text-decoration-none text-black ms-2 mb-0 py-2">{{ $post->user->name }}</a>
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
                                        <button type="button" class="btn text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{$post->id}}"><i class="fa-regular fa-trash-can"></i> Delete</button>
                                    </li>
                                @else
                                    <li>
                                        @if($post->user->isFollowed())
                                            <form action="{{ route('follow.destroy', $post->user->id) }}" method="post" class="mb-0">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="dropdown-item text-danger">Unfollow</button>
                                            </form>
                                        @else
                                            <form action="{{ route('follow.store') }}" method="post" class="mb-0">
                                                @csrf
                                                <input type="hidden" value="{{ $post->user->id }}" name="following_id">
                                                <button type="submit" class="dropdown-item">follow</button>
                                            </form>
                                        @endif
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    {{-- body --}}
                    <form action="{{ route('post.show', $post) }}" method="post">
                        @csrf
                        @method('GET')
                        <button type="submit" class="btn w-100 p-0">
                            <img class="object-fit-cover w-100" src="{{ $post->image }}" alt="">
                        </button>
                    </form>

                    <div class="mt-2 d-flex justify-content-between">
                        {{-- LIKE --}}
                        <div class="m-3 mt-1 mb-0 d-flex align-items-center">
                            @if($post->isliked())
                                <form action="{{ route('like.destroy', Auth::id()) }}" method="post" class="mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn p-0 text-danger"><i class="fa-solid fa-heart fa-2x"></i></button>
                                </form>
                            @else
                                <form action="{{ route('like.store') }}" method="post" class="mb-0">
                                    @csrf
                                    <input type="hidden" value="{{ $post->id }}" name="post_id">
                                    <button type="submit" class="btn p-0"><i class="fa-regular fa-heart fa-2x"></i></button>
                                </form>
                            @endif

                        {{-- LIKE MODAL BUTTON --}}
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#liked-{{$post->id}}">
                                    {{ $post->like->count() }}
                                </button>
                        </div>
                        {{-- CATEGORY --}}
                        <div class="m-3 mb-0 d-flex">
                            @foreach ($post->categoryPost as $pivot)
                                <div class="m-1 ms-1 mb-4 badge bg-secondary bg-opacity-25 text-white">{{ $pivot->category->name }}</div>
                            @endforeach

                        </div>

                    </div>

                    <div class="my-1 mx-3">
                        <p class="mb-0"><span class="fw-bold me-2">{{ $post->user->name }}</span>{{ $post->description }}</p>
                    </div>

                    <p class="mb-0 mx-3 text-secondary">
                        {{ $post->created_at->format('F d, Y') }}
                    </p>

                    {{-- comments --}}
                    @if($post->Comment)
                        <hr class="mx-4">

                        @foreach ($post->Comment->take(3) as $comment)
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

                        @if($post->Comment->count() > 3)
                            <a href="{{  route('post.show', $post) }}" class="mx-3 text-decoration-none">View All {{ $post->Comment->count() }} comments</a>
                        @endif
                    @endif


                    <div class="m-3">
                        <form action="{{ route('comment.store') }}" method="post">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="post_id" value="{{ $post->id }}" hidden>
                                <textarea class="form-control" name="comment" cols="30" rows="1" placeholder="Add a comment..."></textarea>
                                <button type="submit" class="btn btn-outline-secondary">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif


{{-- delete Modal --}}
<div class="modal fade" id="delete-post-{{$post->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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





{{-- liked modal --}}
<div class="modal fade" id="liked-{{$post->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content text-center">
        <div class="modal-body">
            <p class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-heart text-danger"></i> Likes</p>
        </div>
        <div class="modal-body border-top border-success d-flex justify-content-center">
            <ul class="list-unstyled">
                @forelse ($post->like as $like)
                    <li class="py-2">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('profile.show', $like->user ) }}" class="">
                                @if ($like->user->avatar)
                                    <img src="{{ $like->user->avatar }}" alt="#" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                                @endif
                            </a>
                            <a href="{{ route('profile.show', $like->user ) }}" class="text-decoration-none text-black ms-2 mb-0">{{ $like->user->name }}</a>
                        </div>
                    </li>
                @empty

                @endforelse
            </ul>
        </div>
      </div>
    </div>
  </div>



        @empty
            <div class="m-2 text-center">
                <p class="display-3 pb-1">Share Photos</p>
                <p class="text-secondary">When you share photos, they'll appear on your profile.</p>
                <a href="#" class="text-decoration-none">Share your first photo.</a>
            </div>

        @endforelse
    </div>
    <div class="col-4">
        <div class="border rounded-3 shadow p-3 m-2">
            <div class="row">
                <div class="col-2">
                    <a href="{{ route('profile.show', Auth::user() ) }}" class="">
                        @if (Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="#" class="rounded-circle avatar-md">
                        @else
                            <i class="fa-solid fa-circle-user text-dark icon-md"></i>
                        @endif
                    </a>
                </div>
                <div class="col-10">
                    <a href="{{ route('profile.show', Auth::user() ) }}" class="text-decoration-none text-black ms-2 mb-0 pt-3 pb-1">{{ Auth::user()->name }}</a>
                    <p class="mb-0 ms-2 text-secondary">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
        <div class="m-2 mt-5">
            <ul class="ps-0">
                @if($users)
                    <li class="d-flex justify-content-between">
                        <p class="text-secondary">Suggestions For You</p>
                        <a href="{{ route('see.all') }}" class="text-dark fw-bold text-decoration-none">See All</a>
                    </li>
                @endif
                @foreach ($users as $user)
                    <li class="d-flex justify-content-between align-items-center mt-3">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('profile.show', $user ) }}" class="">
                                @if ($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="#" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-dark icon-sm"></i>
                                @endif
                            </a>
                            <a href="{{ route('profile.show', $user ) }}" class="text-decoration-none text-black ms-2 mb-0">{{ $user->name }}</a>
                        </div>
                        <form action="{{ route('follow.store') }}" method="post" class="mb-0">
                            @csrf
                            <input type="hidden" value="{{ $user->id }}" name="following_id">
                            <button type="submit" class="btn text-primary btn-sm">Follow</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection
