@extends('layouts.user')

@section('title', 'Add New User')

@section('content')

    <div class="container mt-4">
        <h2 class="text-center">Add New User Information</h2>

        {{-- Form --}}
        <form id="userForm" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Name --}}
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <label id="name-error" class="error text-danger" for="name"></label>
                </div>

                {{-- Contact No --}}
                <div class="col-md-6 mb-3">
                    <label for="contact_no" class="form-label">Contact No</label>
                    <input type="text" class="form-control" id="contact_no" name="contact_no" required>
                    <label id="contact_no-error" class="error text-danger" for="contact_no"></label>
                </div>

                {{-- Profile Picture --}}
                <div class="col-md-6 mb-3">
                    <label for="profile_pic" class="form-label">Profile Picture</label>

                    <input type="file" class="form-control d-none" id="profile_pic" name="profile_pic" required>

                    <button type="button" class="btn btn-primary" id="uploadBtn">Upload Picture</button>

                    <span id="fileName" class="ms-2"></span>

                    <label id="profile_pic-error" class="error text-danger" for="profile_pic"></label>
                </div>


                {{-- Category (Dropdown) --}}
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="" disabled selected>Select Category</option>
                        <option value="developer">Developer</option>
                        <option value="designer">Designer</option>
                    </select>
                    <label id="category-error" class="error text-danger" for="category"></label>
                </div>

                {{-- Hobby --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Hobby</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="hobby_programming" name="hobbies[]"
                            value="programming">
                        <label class="form-check-label" for="hobby_programming">Programming</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="hobby_games" name="hobbies[]" value="games">
                        <label class="form-check-label" for="hobby_games">Games</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="hobby_reading" name="hobbies[]" value="reading">
                        <label class="form-check-label" for="hobby_reading">Reading</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="hobby_photography" name="hobbies[]"
                            value="photography">
                        <label class="form-check-label" for="hobby_photography">Photography</label>
                    </div>
                    <label id="hobbies-error" class="error text-danger" for="hobbies"></label>
                </div>

                <div class="col-md-12 text-center">
                    <button type="button" class="btn btn-secondary me-2"
                        onclick="window.location.href='{{ url('/') }}'">Cancel</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize form validation
            $('#userForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    contact_no: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 15
                    },
                    profile_pic: {
                        required: true,
                        extension: "jpg|jpeg|png"
                    },
                    category: {
                        required: true
                    },
                    'hobbies[]': {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Name is required",
                        minlength: "Name must be at least 3 characters long"
                    },
                    contact_no: {
                        required: "Contact number is required",
                        digits: "Only digits are allowed",
                        minlength: "Contact number must be at least 10 digits",
                        maxlength: "Contact number cannot exceed 15 digits"
                    },
                    profile_pic: {
                        required: "Profile picture is required",
                        extension: "Only jpg, jpeg, and png formats are allowed"
                    },
                    category: "Category is required",
                    'hobbies[]': "At least one hobby must be selected"
                },
                errorPlacement: function(error, element) {
                    if (element.attr("id") == "profile_pic") {
                        error.appendTo($('#fileName').parent()); 
                    } else {
                        error.appendTo(element.parent()); 
                    }
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                    $('button[type="submit"]').prop('disabled', true);
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                    if ($(this).valid()) {
                        $('button[type="submit"]').prop('disabled', false);
                    }
                },
                submitHandler: function(form) {
                    event.preventDefault();
                    var formData = new FormData($(form)[0]);

                    $.ajax({
                        url: $(form).attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'User information added successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '/';
                                }
                            });
                        },
                        error: function(response) {
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred while adding the user information.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                },
                invalidHandler: function(event, validator) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Please correct the errors in the form before submitting.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

            $('#uploadBtn').on('click', function() {
                $('#profile_pic').click(); 
            });

            $('#profile_pic').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $('#fileName').text(fileName);
            });
        });
    </script>

@endsection
