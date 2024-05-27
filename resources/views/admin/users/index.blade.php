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
                    <p class="mb-0"><i class="fa-solid fa-circle text-success"></i> Active</p>
                </td>
                <td class="">
                    <button type="button" class="btn dropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis"></i></button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" class="dropdown-item text-danger"><i class="fa-solid fa-user-slash"></i> Deactivate {{ $user->name }}</a>
                        </li>
                    </ul>
                </td>
            </tr>
        @empty
        @endforelse
    </table>

@endsection
