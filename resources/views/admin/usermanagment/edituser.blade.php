@extends('layout.app')
@section('content')
    <div class="main-content d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <section class="section w-100">
            <div class="section-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <form action="{{ route('admin.users.update', $user->id) }}" id="formbox" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="card-header">
                                    <h4>Edit User</h4>
                                </div>

                                <div class="card-body">
                                    <div class="col-md-12 mb-4">
                                        <label>First Name</label>
                                        <input class="form-control" id="first_name" type="text" name="first_name"
                                            placeholder="First Name" value="{{ old('first_name', $user->first_name) }}">
                                        <span class="text-danger" id="first_name_error"></span>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label>Last Name</label>
                                        <input class="form-control" id="last_name" type="text" name="last_name"
                                            placeholder="Last Name" value="{{ old('last_name', $user->last_name) }}">
                                        <span class="text-danger" id="last_name_error"></span>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label>Mobile No</label>
                                        <input class="form-control" type="text" id="mobile_no" name="mobile_no"
                                            placeholder="Mobile No" value="{{ old('mobile_no', $user->mobile_no) }}">
                                        <span class="text-danger" id="mobile_no_error"></span>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label>E-mail</label>
                                        <input class="form-control" name="email" id="email" type="text"
                                            placeholder="E-mail" value="{{ old('email', $user->email) }}">
                                        <span class="text-danger" id="email_error"></span>
                                    </div>

                                    <div class="col-md-12 mb-4">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <input class="form-control" type="password" id="password" name="password"
                                                placeholder="Password">
                                            <div class="input-group-append">
                                                <span class="input-group-text toggle-password" data-target="#password"
                                                    style="cursor:pointer;">
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="password_error"></span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="roles_input">Select Roles</label>
                                        <input type="text" id="roles_input" class="form-control"
                                            placeholder="Search roles...">

                                        <div id="roles_dropdown" class="bg-white border border-gray-300 mt-1 rounded"
                                            style="display:none; max-height: 200px; overflow-y: auto; position: absolute; width: 100%; z-index: 1000;">
                                            @foreach ($roles as $role)
                                                <div class="dropdown-item p-2 cursor-pointer border-b hover:bg-gray-100"
                                                    data-id="{{ $role->id }}" data-name="{{ $role->name }}">
                                                    {{ $role->name }}
                                                </div>
                                            @endforeach
                                        </div>

                                        <div id="selected_roles" class="mt-2 flex flex-wrap gap-2">
                                            @foreach ($user->roles as $role)
                                                <span class="badge badge-primary mr-2 mb-2 removable-tag"
                                                    data-id="{{ $role->id }}"
                                                    style="display:inline-flex; align-items:center;">
                                                    {{ $role->name }}
                                                    <span class="ml-2 text-white cursor-pointer remove-tag"
                                                        style="font-weight:bold;">&times;</span>
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $(".toggle-password").on("click", function() {
                var target = $(this).data("target");
                var input = $(target);
                var icon = $(this).find("i");

                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                    icon.removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    input.attr("type", "password");
                    icon.removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });
            $("#first_name").on("keyup", function() {
                var original = $(this).val();

                var check_name = /^[A-Za-z ]+$/;

                if (original.trim() === "") {
                    $("#first_name_error").text("");
                } else if (!check_name.test(original)) {
                    $("#first_name_error").text("First Name should have only letters (A-Z or a-z).");
                } else {
                    $("#first_name_error").text("");
                }

                // Clean the input for display
                var cleaned = original.replace(/[^A-Za-z ]/g, "");
                $(this).val(cleaned);
            });
            $("#last_name").on("keyup", function() {
                var original = $(this).val();

                var check_name = /^[A-Za-z ]+$/;

                if (original.trim() === "") {
                    $("#last_name_error").text("");
                } else if (!check_name.test(original)) {
                    $("#last_name_error").text("last Name should have only letters (A-Z or a-z).");
                } else {
                    $("#last_name_error").text("");
                }

                // Clean the input for display
                var cleaned = original.replace(/[^A-Za-z ]/g, "");
                $(this).val(cleaned);
            });
            $("#email").keyup(function() {
                var email = $("#email").val();
                email = email.replace(/[^a-zA-Z0-9@._%+\-]/g, "");
                $("#email").val(email);

                var check_email = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;

                if (email === "") {
                    $("#email_error").text("");
                } else if (!check_email.test(email)) {
                    $("#email_error").text("Email should include valid characters and '@gmail.com'.");
                } else {
                    $("#email_error").text("");
                }
            });
            $("#mobile_no").on("keyup", function() {
                var original = $(this).val();

                var check_mobile_no = /^92[0-9]{10}$/;

                if (original.trim() === "") {
                    $("#mobile_no_error").text("");
                } else if (!check_mobile_no.test(original)) {
                    $("#mobile_no_error").text(
                        "Mobile no must start with '92' and contain 12 digits total.");
                } else {
                    $("#mobile_no_error").text("");
                }

                // Optional: Clean to digits only
                var cleaned = original.replace(/[^0-9]/g, "");
                $(this).val(cleaned);
            });

            $("#password").keyup(function() {
                var password = $("#password").val();
                $("#password").val(password);

                var check_password = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/;

                if (password === "") {
                    $("#password_error").text("");
                } else if (!check_password.test(password)) {
                    $("#password_error").text(
                        "Password must be at least 6 characters with letters and numbers.");
                } else {
                    $("#password_error").text("");
                }
            });


            const $input = $('#roles_input');
            const $dropdown = $('#roles_dropdown');
            const $selected = $('#selected_roles');

            const selectedIds = new Set();
            $selected.on('click', '.remove-tag', function() {
                const $tag = $(this).closest('.removable-tag');
                const id = $tag.data('id');

                selectedIds.delete(id);
                $tag.remove();
            });



            // Show dropdown on input focus
            $input.on('focus', function() {
                $dropdown.show();
            });

            // Hide dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.form-group').length) {
                    $dropdown.hide();
                }
            });

            // Filter permissions on typing
            $input.on('input', function() {
                const filter = $(this).val().toLowerCase();
                $dropdown.children().each(function() {
                    const name = $(this).data('name').toLowerCase();
                    $(this).toggle(name.includes(filter));
                });
            });

            // Click on role (single selection only)
            $dropdown.on('click', '.dropdown-item', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');

                // Clear previously selected roles
                $selected.empty();

                // Add hidden input
                const hiddenInput = $('<input>').attr({
                    type: 'hidden',
                    name: 'roles[]',
                    value: name
                });

                // Add tag with close button
                const tag = $(`
                    <span class="badge badge-primary mr-2 mb-2 removable-tag" data-id="${id}" style="display:inline-flex; align-items:center;">
                    ${name}
                    <span class="ml-2 text-white cursor-pointer remove-tag" style="font-weight:bold;">&times;</span>
                    </span>
                            `);


                // Add to selected and append hidden input
                tag.append(hiddenInput);
                $selected.append(tag);

                $input.val('');
                $dropdown.hide();
            });



            $("#formbox").on("submit", function(e) {
                e.preventDefault();
                const roleValues = $("input[name='roles[]']").map(function() {
                    return $(this).val();
                }).get();

                console.log("Roles submitted:", roleValues);

                $(".text-danger").text(""); // clear previous errors

                let valid = true;
                let email = $('#email').val().trim();
                let password = $('#password').val().trim();
                let first_name = $('#first_name').val().trim();
                let last_name = $('#last_name').val().trim();
                let mobile = $('#mobile_no').val().trim();

                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                let mobileRegex = /^\d{10,15}$/;
                // Pakistani number format
                if (first_name === "") {
                    $('#first_name_error').text("First name is required.");
                    valid = false;
                }

                if (last_name === "") {
                    $('#last_name_error').text("Last name is required.");
                    valid = false;
                }
                if (mobile === "") {
                    $('#mobile_no_error').text("Mobile number is required.");
                    valid = false;
                } else if (!mobileRegex.test(mobile)) {
                    $('#mobile_no_error').text("Enter a valid mobile number.");
                    valid = false;
                }
                if (email === "") {
                    $('#email_error').text("Email is required.");
                    valid = false;
                } else if (!emailRegex.test(email)) {
                    $('#email_error').text("Enter a valid email.");
                    valid = false;
                }
                if (password !== "") {
                    if (password.length < 6) {
                        $('#password_error').text("Password must be at least 6 characters.");
                        valid = false;
                    }
                }

                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: res.message,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });

                        $('#formbox')[0].reset();

                        setTimeout(function() {
                            window.location.href = "{{ route('admin.users.index') }}";
                        }, 3000);
                    },
                    error: function(err) {
                        if (err.status === 422) {
                            let errors = err.responseJSON.errors;
                            $('.text-danger').text('');
                            $.each(errors, function(field, messages) {
                                $(`#${field}_error`).text(messages[0]);
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong on the server.',
                                icon: 'error',
                                confirmButtonText: 'Close'
                            });
                            console.error(err.responseText);
                        }
                    }
                });
            });

        });
    </script>
@endsection
