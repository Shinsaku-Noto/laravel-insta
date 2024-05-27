@extends('layouts.app')

@section('title', 'admin')

@section('content')

<div class="row">
    <div class="col-8">
        <form action="#" method="post">
            @csrf
            <div class="row">
                <div class="col-7">
                    <input type="text" name="category" class="form-control" placeholder="Add a category">
                </div>
                <div class="col-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-plus"></i> Add</button>
                </div>
            </div>
        </form>

        <table class="table table-hover align-middle text-center my-3">
            <tr class="table-warning table-opacity-25">
                <th>#</th>
                <th>NAME</th>
                <th>COUNT</th>
                <th>LAST UPDATED</th>
                <th></th>
            </tr>
            @forelse ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->categoryPost()->count() }}</td>
                <td>{{ $category->updated_at }}</td>
                <td>
                    <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-{{ $category->id }}">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-{{ $category->id }}">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </td>
            </tr>

<!-- Edit Modal -->
<div class="modal fade" id="edit-{{ $category->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border border-warning rounded-3">
        <div class="modal-header">
          <p class="mb-0 fs-5"><i class="fa-regular fa-pen-to-square"></i> Edit Category</p>
        </div>
        <div class="modal-body border-top border-warning">
            <form action="{{ route('category.update', $category->id) }}" method="post">
                @csrf
                @method('PATCH')
                <input type="text" name="name" class="form-control" value="{{ $category->name }}">
                <div class="mt-2 text-end">
                    <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>

<!-- Delete Modal -->
<div class="modal fade" id="delete-{{ $category->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
            @empty
            @endforelse
        </table>
    </div>
</div>

@endsection
