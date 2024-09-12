@extends('layouts.user')

@section('title', 'User Update')

@section('content')

<div class="container mt-4">
    <h2 class="text-center">Update User Information</h2>

    {{-- Form --}}
    <form id="userForm" action="{{ route('users.update', $userInfo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') 

        <div class="row">
            {{-- Name --}}
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $userInfo->name }}">
                <label id="name-error" class="error text-danger" for="name"></label>
            </div>

            {{-- Contact No --}}
            <div class="col-md-6 mb-3">
                <label for="contact_no" class="form-label">Contact No</label>
                <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ $userInfo->contact_no }}">
                <label id="contact_no-error" class="error text-danger" for="contact_no"></label>
            </div>

            {{-- Profile Picture --}}
            <div class="col-md-6 mb-3">
                <label for="profile_pic" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profile_pic" name="profile_pic">
                <label id="profile_pic-error" class="error text-danger" for="profile_pic"></label>
                {{-- Show current profile picture --}}
                @if ($userInfo->profile_pic)
                    <img src="{{ asset('images/' . $userInfo->profile_pic) }}" alt="Profile Picture" width="100" class="mt-2">
                @endif
            </div>

            {{-- Category --}}
            <div class="col-md-6 mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category">
                    <option value="developer" {{ $userCategory->category == 'developer' ? 'selected' : '' }}>Developer</option>
                    <option value="designer" {{ $userCategory->category == 'designer' ? 'selected' : '' }}>Designer</option>
                </select>
                <label id="category-error" class="error text-danger" for="category"></label>
            </div>

            {{-- Hobby --}}
            <div class="col-md-12 mb-3">
                <label class="form-label">Hobby</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="hobby_programming" name="hobbies[]" value="programming"
                        {{ in_array('programming', explode(',', $userHobby->hobby)) ? 'checked' : '' }}>
                    <label class="form-check-label" for="hobby_programming">Programming</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="hobby_games" name="hobbies[]" value="games"
                        {{ in_array('games', explode(',', $userHobby->hobby)) ? 'checked' : '' }}>
                    <label class="form-check-label" for="hobby_games">Games</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="hobby_reading" name="hobbies[]" value="reading"
                        {{ in_array('reading', explode(',', $userHobby->hobby)) ? 'checked' : '' }}>
                    <label class="form-check-label" for="hobby_reading">Reading</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="hobby_photography" name="hobbies[]" value="photography"
                        {{ in_array('photography', explode(',', $userHobby->hobby)) ? 'checked' : '' }}>
                    <label class="form-check-label" for="hobby_photography">Photography</label>
                </div>
                <label id="hobbies-error" class="error text-danger" for="hobbies"></label>
            </div>

            {{-- Submit Button --}}
            <div class="col-md-12 text-center">
                <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='{{ url('/') }}'">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
</div>


    <script>
        $(document).ready(function () {
            $('#userForm').validate({
                rules: {
                    name: {
                        minlength: 3
                    },
                    contact_no: {
                        digits: true,
                        minlength: 10,
                        maxlength: 15
                    },
                    profile_pic: {
                        extension: "jpg|jpeg|png|gif"
                    }
                },
                messages: {
                    name: {
                        minlength: "Name must be at least 3 characters long"
                    },
                    contact_no: {
                        digits: "Please enter a valid phone number.",
                        minlength: "Contact number should be at least 10 digits.",
                        maxlength: "Contact number should not exceed 15 digits."
                    },
                    profile_pic: {
                        extension: "Only image files with jpg, jpeg, png, gif are allowed."
                    }
                },
                errorElement: 'label',
                errorPlacement: function (error, element) {
                    var id = element.attr('id');
                    $('#' + id + '-error').html(error);
                }
            });
        });
    </script>
@endsection
