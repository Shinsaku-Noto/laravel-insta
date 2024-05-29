@extends('layouts.app')

@section('title', 'admin')

@section('content')

    <table class="table table-hover align-middle">
        <tr class="table-success table-opacity-25">
            <th class=""></th>
            <th class="">NAME</th>
            <th class="">EMAIL</th>
            <th class="">CREATED AT</th>
            <th class="">STATUS</th>
            <th class=""></th>
        </tr>
        @forelse($users as $user)
            <tr>
                <td class="">
                    <a href="{{ route('profile.show', $user ) }}" class="">
                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" alt="#" class="rounded-circle avatar-md">
                        @else
                            <i class="fa-solid fa-circle-user text-dark icon-md"></i>
                        @endif
                    </a>
                </td>
                <td class="">
                    <a href="{{ route('profile.show', $user) }}" class="text-decoration-none text-black mb-0">{{ $user->name }}</a>
                </td>
                <td class="">
                    <p class="mb-0">{{ $user->email }}</p>
                </td>
                <td class="">
                    <p class="mb-0">{{ $user->created_at }}</p>
                </td>
                <td class="">
                    @if($user->deleted_at)
                        <p class="mb-0"><i class="fa-regular fa-circle"></i> Inactive</p>
                    @else
                        <p class="mb-0"><i class="fa-solid fa-circle text-success"></i> Active</p>
                    @endif
                </td>
                <td class="">
                    <button type="button" class="btn dropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis"></i></button>
                    <ul class="dropdown-menu">
                        <li>
                            @if($user->deleted_at)
                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#activate-{{ $user->id }}">
                                    <i class="fa-solid fa-user-check"></i> Activate {{ $user->name }}
                                </button>
                            @else
                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-{{ $user->id }}">
                                    <i class="fa-solid fa-user-slash"></i> Deactivate {{ $user->name }}
                                </button>
                            @endif
                        </li>
                    </ul>
                </td>
            </tr>

<!-- Activate Modal -->
<div class="modal fade" id="activate-{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-success">
        <div class="modal-header border-success">
          <h1 class="modal-title fs-5 text-success" id="exampleModalLabel"><i class="fa-solid fa-user-check"></i> Activate User</h1>
        </div>
        <div class="modal-body">
          Are you sure you want to activate <span class="mb-0 fw-bold">{{ $user->name }}</span>?
        </div>
        <div class="modal-footer border-0">
            <button type="button" class="btn btn-outline-success btn-sm" data-bs-dismiss="modal">Close</button>
            <form action="{{ route('admin.users.restore', $user->id) }}" method="post" class="m-0">
                @csrf
                @method('GET')
                <button type="submit" class="btn btn-success btn-sm">
                    Activate
                </button>
            </form>
          </div>
      </div>
    </div>
  </div>

<!-- Deactivate Modal -->
<div class="modal fade" id="deactivate-{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-danger">
        <div class="modal-header border-danger">
          <h1 class="modal-title fs-5 text-danger" id="exampleModalLabel"><i class="fa-solid fa-user-slash"></i> Deactivate User</h1>
        </div>
        <div class="modal-body">
          Are you sure you want to deactivate <span class="mb-0 fw-bold">{{ $user->name }}</span>?
        </div>
        <div class="modal-footer border-0">
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Close</button>
            <form action="{{ route('admin.users.softdelete', $user->id) }}" method="post" class="m-0">
                @csrf
                @method('GET')
                <button type="submit" class="btn btn-danger btn-sm">
                    Deactivate
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
        <p class="">{{ $users->links() }}</p>
    </div>

@endsection
