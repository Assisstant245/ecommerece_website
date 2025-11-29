@extends('layout.user_app')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/product_list') }}">Products</a></li>
                <li class="breadcrumb-item active">Login</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Login Start -->
    <div class="login d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <form class="login-form p-4 shadow rounded bg-white" id="loginForm" method="POST">
                        <div id="login-message" class="mb-3"></div>

                        <div class="form-group">
                            <label for="email">E-mail / Username</label>
                            <input id="email" class="form-control" type="email" name="email"
                                placeholder="E-mail / Username">
                            <span class="text-danger" id="email_error"></span>

                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input id="password" class="form-control" type="password" name="password"
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



                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="newaccount">
                            <label class="form-check-label" for="newaccount">Keep me signed in</label>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mt-3">
                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary mr-4">Submit</button>

                            <!-- Register Link Styled as Button -->
                            <a href="{{ url('/register') }}" class="btn btn-primary">Register</a>
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
        $(document).ready(function() {
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

            $('#loginForm').on("submit", function(e) {
                e.preventDefault();
                $(".text-danger").text("");

                let email = $("#email").val().trim();
                let password = $("#password").val().trim();

                let valid = true;

                // Regex patterns
                let emailRegex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i;

                let passwordRegex = /^(?=.*[A-Za-z])(?=.*\d).{6,}$/;

                // Email validation
                if (email === "") {
                    $("#email_error").text("Email is required.");
                    valid = false;
                } else if (!emailRegex.test(email)) {
                    $("#email_error").text("Enter a valid email address.");
                    valid = false;
                }

                // Password validation
                if (password === "") {
                    $("#password_error").text("Password is required.");
                    valid = false;
                } else if (!passwordRegex.test(password)) {
                    $("#password_error").text(
                        "Password must contain letters and numbers and be at least 6 characters.");
                    valid = false;
                }

                if (!valid) return;

                // Prepare data
                let formData = new FormData(this);

                // Ajax Request
                $.ajax({
                    url: "{{ route('user.loginsubmit') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Login successful!',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true
                            });
                            setTimeout(() => {
                                window.location.href = "/product_list";
                            }, 2000);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Access Denied',
                                text: response.message || 'Login failed.',
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 403) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Access Denied',
                                text: xhr.responseJSON.message ||
                                    'Access denied for this user role.',
                            });
                        } else if (xhr.status === 401) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid Credentials',
                                text: xhr.responseJSON.message ||
                                    'Invalid email or password.',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong while processing your request.'
                            });
                        }
                    }


                });
            });


        });
    </script>
@endsection
