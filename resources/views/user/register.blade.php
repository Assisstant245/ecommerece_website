@extends('layout.user_app')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/product_list') }}">Products</a></li>
                <li class="breadcrumb-item active">Register</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Login Start -->
    <div class="login">
        <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
            <div class="row w-100">
                <div class="col-lg-6 mx-auto">
                    <form class="register-form" id="registerForm" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <label>First Name</label>
                                <input class="form-control" id="first_name" type="text" name="first_name"
                                    placeholder="First Name">
                                <span class="text-danger" id="first_name_error"></span>

                            </div>
                            <div class="col-md-6">
                                <label>Last Name</label>
                                <input class="form-control" id="last_name" type="text" placeholder="Last Name"
                                    name="last_name">
                                <span class="text-danger" id="last_name_error"></span>

                            </div>
                            <div class="col-md-6">
                                <label>E-mail</label>
                                <input class="form-control" name="email" id="email" type="text"
                                    placeholder="E-mail">
                                <span class="text-danger" id="email_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Mobile No</label>
                                <input class="form-control" type="text" id="mobile_no" name="mobile_no"
                                    placeholder="Mobile No">
                                <span class="text-danger" id="mobile_no_error"></span>
                            </div>
                            <div class="col-md-6">
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

                            <div class="col-md-6">
                                <label>Retype Password</label>
                                <div class="input-group">
                                    <input class="form-control" type="password" id="retype_password"
                                        name="password_confirmation" placeholder="Retype Password">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" data-target="#retype_password"
                                            style="cursor:pointer;">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <span class="text-danger" id="retype_password_error"></span>
                            </div>
                            <div class="col-md-12 text-center mt-3">
                                <button type="submit" class="btn btn-primary px-4">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Login End -->

    <!-- Footer Start -->
    <div class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Get in Touch</h2>
                        <div class="contact-info">
                            <p><i class="fa fa-map-marker"></i>123 E Store, Los Angeles, USA</p>
                            <p><i class="fa fa-envelope"></i>email@example.com</p>
                            <p><i class="fa fa-phone"></i>+123-456-7890</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Follow Us</h2>
                        <div class="contact-info">
                            <div class="social">
                                <a href=""><i class="fab fa-twitter"></i></a>
                                <a href=""><i class="fab fa-facebook-f"></i></a>
                                <a href=""><i class="fab fa-linkedin-in"></i></a>
                                <a href=""><i class="fab fa-instagram"></i></a>
                                <a href=""><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Company Info</h2>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms & Condition</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h2>Purchase Info</h2>
                        <ul>
                            <li><a href="#">Pyament Policy</a></li>
                            <li><a href="#">Shipping Policy</a></li>
                            <li><a href="#">Return Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row payment align-items-center">
                <div class="col-md-6">
                    <div class="payment-method">
                        <h2>We Accept:</h2>
                        <img src="img/payment-method.png" alt="Payment Method" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="payment-security">
                        <h2>Secured By:</h2>
                        <img src="{{ asset('user_assets/img/godaddy.svg') }}" alt="Payment Security" />
                        <img src="{{ asset('user_assets/img/norton.svg') }}" alt="Payment Security" />
                        <img src="{{ asset('user_assets/img/ssl.svg') }}" alt="Payment Security" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Toggle password visibility
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

            $("#password").keyup(function() {
                var password = $("#password").val();
                $("#password").val(password);

                var check_password = /^(?=.*[A-Za-z])(?=.*\d).{6,}$/;

                if (password === "") {
                    $("#password_error").text("");
                } else if (!check_password.test(password)) {
                    $("#password_error").text(
                        "Password must be at least 6 characters with letters and numbers.");
                } else {
                    $("#password_error").text("");
                }
            });
            $("#retype_password").on("keyup", function() {
                var password = $("#password").val();
                var confirmPassword = $(this).val();

                if (confirmPassword.trim() === "") {
                    $("#retype_password_error").text("Please retype your password.");
                } else if (password !== confirmPassword) {
                    $("#retype_password_error").text("Passwords do not match.");
                } else {
                    $("#retype_password_error").text("");
                }
            });

            $("#mobile_no").on("keyup", function() {
                var original = $(this).val();

                var check_mobile_no = /^92[0-9]{10}$/;

                if (original.trim() === "") {
                    $("#mobile_no_error").text("Mobile no is required.");
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

            $('#registerForm').submit(function(e) {
                e.preventDefault();
                $(".text-danger").text(""); // clear previous errors

                let valid = true;

                // Get values
                let first_name = $('#first_name').val().trim();
                let last_name = $('#last_name').val().trim();
                let email = $('#email').val().trim();
                let password = $('#password').val().trim();
                let confirmPassword = $('#password_confirmation').val();
                let mobile = $('#mobile_no').val().trim();

                // Regex
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                let mobileRegex = /^\d{10,15}$/; // Pakistani number format

                // Validation
                if (first_name === "") {
                    $('#first_name_error').text("First name is required.");
                    valid = false;
                }

                if (last_name === "") {
                    $('#last_name_error').text("Last name is required.");
                    valid = false;
                }

                if (email === "") {
                    $('#email_error').text("Email is required.");
                    valid = false;
                } else if (!emailRegex.test(email)) {
                    $('#email_error').text("Enter a valid email.");
                    valid = false;
                }

                if (mobile === "") {
                    $('#mobile_no_error').text("Mobile number is required.");
                    valid = false;
                } else if (!mobileRegex.test(mobile)) {
                    $('#mobile_no_error').text("Enter a valid mobile number.");
                    valid = false;
                }

                if (password === "") {
                    $('#password_error').text("Password is required.");
                    valid = false;
                } else if (password.length < 6) {
                    $('#password_error').text("Password must be at least 6 characters.");
                    valid = false;
                }

                if (confirmPassword === "") {
                    $('#password_confirmation_error').text("Confirm your password.");
                    valid = false;
                } else if (password !== confirmPassword) {
                    $('#password_confirmation_error').text("Passwords do not match.");
                    valid = false;
                }

                // if (!valid) return;

                // Proceed to submit if valid
                let data = new FormData(this);

                $.ajax({
                    url: "{{ route('user.registersubmit') }}",
                    method: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Registration successful!',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        $('#registerForm')[0].reset();
                        setTimeout(() => {
                            window.location.href = "/login";
                        }, 3000);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            $('.text-danger').text('');
                            $.each(errors, function(field, messages) {
                                $(`#${field}_error`).text(messages[0]);
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An unexpected error occurred.',
                                icon: 'error',
                                confirmButtonText: 'Close'
                            });
                            console.error(xhr.responseText);
                        }
                    }
                });
            });


        })
    </script>
@endsection
