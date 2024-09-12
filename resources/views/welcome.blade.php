@extends('layouts.user')

@section('title', 'Home')

@section('content')

    <div class="d-flex justify-content-between align-items-center my-4">
        <h1 class="text-center">User Information</h1>
        <a href="{{ route('users.create') }}" class="btn btn-success">ADD NEW</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-hover table-striped table-bordered align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Contact No</th>
                <th>Hobby</th>
                <th>Category</th>
                <th>Profile Pic</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr id="user-{{ $user->id }}">
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->contact_no }}</td>
                    <td>
                        @if ($user->hobbies->isNotEmpty())
                            {{ implode(', ', $user->hobbies->pluck('hobby')->toArray()) }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if ($user->categories->isNotEmpty())
                            {{ $user->categories->first()->category }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if ($user->profile_pic)
                            <img src="{{ asset('images/' . $user->profile_pic) }}" alt="Profile Picture" class="img-thumbnail"
                                width="50" height="50">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm editBtn"
                            onclick="window.location.href='{{ route('users.edit', $user->id) }}'">Edit</button>
                        <button type="button" class="btn btn-danger"
                            onclick="confirmDelete({{ $user->id }})">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No user details available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

   
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

@endsection
