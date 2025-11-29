<!DOCTYPE html>
<html lang="en">


<!-- auth-forgot-password.html  21 Nov 2019 04:05:02 GMT -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Bixosoft - Admin Dashboard</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('assets/img/favicon.ico') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>
    @if (session('error'))
        <span class="error-message">{{ session('error') }}</span>
    @endif
    <div class="loader"></div>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" id='form' action="{{ route('admin.login.submit') }}" class="">
                                    @csrf

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email">
                                        <p id="email-error" class="text-danger small"></p>


                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="control-label">Password</label>
                                        <div class="input-group">
                                            <input id="password" type="password" class="form-control" name="password">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="togglePassword"
                                                    style="cursor: pointer;">
                                                    <i class="fa fa-eye" id="eyeIcon"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <p id="password-error" class="text-danger small"></p>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input"
                                                tabindex="3" id="remember-me">
                                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <div class="footer-left">
            <a href="templateshub.net">Templateshub</a></a>
        </div>
        <div class="footer-right">
        </div>
    </footer>
    </div>
    </div>
    <script src="{{ asset('assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
    <script src="assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/auth-register.js') }}"></script>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyB55Np3_WsZwUQ9NS7DP-HnneleZLYZDNw&amp;sensor=true"></script>
    <script src="{{ asset('assets/bundles/gmaps.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/contact.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/index.js') }}"></script>
    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('assets/bundles/summernote/summernote-bs4.js') }}"></script>
    <!-- Page Specific JS File -->
    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>


<!-- profile.html  21 Nov 2019 03:49:32 GMT -->

</html>
<script>
    $(document).ready(function() {

        $("#email").keyup(function() {
            var email = $("#email").val();
            email = email.replace(/[^a-zA-Z0-9@._%+\-]/g, "");
            $("#email").val(email);

            var check_email = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;

            if (email === "") {
                $("#email-error").text("");
            } else if (!check_email.test(email)) {
                $("#email-error").text("Email should include valid characters and '@gmail.com'.");
            } else {
                $("#email-error").text("");
            }
        });

        $("#password").keyup(function() {
            var password = $("#password").val();
            $("#password").val(password);

            var check_password = /^(?=.*[A-Za-z])(?=.*\d).{6,}$/;

            if (password === "") {
                $("#password-error").text("");
            } else if (!check_password.test(password)) {
                $("#password-error").text(
                    "Password must be at least 6 characters with letters and numbers.");
            } else {
                $("#password-error").text("");
            }
        });

        //Toggle Password Visibility
        $("#togglePassword").click(function() {
            var input = $("#password");
            var icon = $("#eyeIcon");

            if (input.attr("type") === "password") {
                input.attr("type", "text");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                input.attr("type", "password");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            }
        });
        
        $('#form').on("submit", function(e) {
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
                    url: "{{ route('admin.login.submit') }}",
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
                                window.location.href = "{{ route('admin.dashboard') }}";;
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
                                toast: true,
                                position: 'top-end',
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
