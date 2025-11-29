@extends('layout.user_app')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/product_list') }}">Products</a></li>
                <li class="breadcrumb-item active">My Account</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- My Account Start -->
    <div class="my-account">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="dashboard-nav" data-toggle="pill" href="#dashboard-tab"
                            role="tab"><i class="fa fa-tachometer-alt"></i>Dashboard</a>
                        <a class="nav-link" id="orders-nav" data-toggle="pill" href="#orders-tab" role="tab"><i
                                class="fa fa-shopping-bag"></i>Orders</a>
                        {{-- <a class="nav-link" id="payment-nav" data-toggle="pill" href="#payment-tab" role="tab"><i
                                class="fa fa-credit-card"></i>Payment Method</a>
                        <a class="nav-link" id="address-nav" data-toggle="pill" href="#address-tab" role="tab"><i
                                class="fa fa-map-marker-alt"></i>address</a> --}}
                        <a class="nav-link" id="account-nav" data-toggle="pill" href="#account-tab" role="tab"><i
                                class="fa fa-user"></i>Account Details</a>
                        <a href="{{ url('/logout') }}" class="nav-item nav-link">Logout</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="dashboard-tab" role="tabpanel"
                            aria-labelledby="dashboard-nav">
                            <h4>Dashboard</h4>
                            <p>
                                Welcome to your eStore — a powerful, modern eCommerce platform designed to help you manage,
                                sell, and grow effortlessly. Whether you're offering fashion apparel, electronics,
                                accessories, or handmade goods, our system gives you complete control over your products,
                                orders, and customers — all in one place.

                                With a user-friendly interface and real-time insights, you can track your sales, update
                                inventory, and manage customer interactions with ease. Your eStore is built to deliver a
                                seamless shopping experience for buyers and a smooth management experience for you.

                                Start selling smarter, faster, and better — all from your eStore dashboard.


                            </p>
                        </div>
                        <div class="tab-pane fade" id="orders-tab" role="tabpanel" aria-labelledby="orders-nav">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Date</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($orders as $index => $order)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>

                                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                                <td>${{ number_format($order->total_price, 2) }}</td>
                                                <td>{{ ucfirst($order->order_status) }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary view-order-btn"
                                                        data-products='@json(json_decode($order->product_items))'
                                                        data-total="{{ $order->total_price }}">View</button>

                                                </td>
                                                
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No orders found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Order Details Modal -->
                        <div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog"
                            aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Product Image</th>

                                                    <th>Product Name</th>
                                                    <th>Quantity</th>
                                                    <th>Sub Total</th>

                                                </tr>
                                            </thead>
                                            <tbody id="orderProductsBody"></tbody>
                                        </table>
                                        <p><strong>Total Price:</strong> $<span id="orderTotalPrice"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- <div class="tab-pane fade" id="payment-tab" role="tabpanel" aria-labelledby="payment-nav">
                            <h4>Payment Method</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In condimentum quam ac mi viverra
                                dictum. In efficitur ipsum diam, at dignissim lorem tempor in. Vivamus tempor hendrerit
                                finibus. Nulla tristique viverra nisl, sit amet bibendum ante suscipit non. Praesent in
                                faucibus tellus, sed gravida lacus. Vivamus eu diam eros. Aliquam et sapien eget arcu
                                rhoncus scelerisque.
                            </p>
                        </div>
                        <div class="tab-pane fade" id="address-tab" role="tabpanel" aria-labelledby="address-nav">
                            <h4>Address</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Payment Address</h5>
                                    <p>123 Payment Street, Los Angeles, CA</p>
                                    <p>Mobile: 012-345-6789</p>
                                    <button class="btn">Edit Address</button>
                                </div>
                                <div class="col-md-6">
                                    <h5>Shipping Address</h5>
                                    <p>123 Shipping Street, Los Angeles, CA</p>
                                    <p>Mobile: 012-345-6789</p>
                                    <button class="btn">Edit Address</button>
                                </div>
                            </div>
                        </div> --}}
                        <div class="tab-pane fade" id="account-tab" role="tabpanel" aria-labelledby="account-nav">
                            <h4>Account Details</h4>
                            <form class="row" id="updateAccount">
                                <div class="col-md-6">
                                    <input class="form-control" type="text"
                                        value="{{ old('first_name', Auth::user()->first_name ?? '') }}" id="first_name"
                                        name="first_name" placeholder="First Name">
                                    <span class="text-danger" id="first_name_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" type="text"
                                        value="{{ old('last_name', Auth::user()->last_name ?? '') }}" id="last_name"
                                        name="last_name" placeholder="Last Name">
                                    <span class="text-danger" id="last_name_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" id="mobile_no" name="mobile_no"
                                        value="{{ old('mobile_no', Auth::user()->mobile_no ?? '') }}"
                                        placeholder="Mobile">
                                    <span class="text-danger" id="mobile_no_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" type="text" id="email" name="email"
                                        value="{{ old('email', Auth::user()->email ?? '') }}" placeholder="Email">
                                    <span class="text-danger" id="email_error"></span>
                                </div>

                                <div class="col-md-12">
                                    <button type=submit class="btn">Update Account</button>
                                    <br><br>
                                </div>
                            </form>
                            <h4>Password change</h4>
                            <form class="row" id="passwordform">
                                <!-- Current Password -->
                                <div class="col-md-12 mb-3">
                                    <div class="input-group">
                                        <input class="form-control" id="password" name="password" type="password"
                                            placeholder="Current Password">
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" data-target="#password"
                                                style="cursor:pointer;">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="password_error"></span>
                                </div>

                                <!-- New Password -->
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <input class="form-control" id="new_password" name="new_password"
                                            type="password" placeholder="New Password">
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" data-target="#new_password"
                                                style="cursor:pointer;">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="new_password_error"></span>
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <input class="form-control" type="password" id="new_password_confirmation"
                                            name="new_password_confirmation" placeholder="Confirm Password">
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password"
                                                data-target="#new_password_confirmation" style="cursor:pointer;">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="confirm_password_error"></span>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- My Account End -->

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
            $("#new_password").keyup(function() {
                var newpassword = $("#new_password").val();
                $("#new_password").val(newpassword);

                var check_password = /^(?=.*[A-Za-z])(?=.*\d).{6,}$/;

                if (newpassword === "") {
                    $("#new_password_error").text("");
                } else if (!check_password.test(newpassword)) {
                    $("#new_password_error").text(
                        "Password must be at least 6 characters with letters and numbers.");
                } else {
                    $("#new_password_error").text("");
                }
            });
            $("#new_password_confirmation").on("keyup", function() {
                var newpassword = $("#new_password").val();
                var confirmPassword = $(this).val();

                if (confirmPassword.trim() === "") {
                    $("#new_password_confirmation_error").text("Please retype your password.");
                } else if (newpassword !== confirmPassword) {
                    $("#new_password_confirmation_error").text("Passwords do not match.");
                } else {
                    $("#new_password_confirmation_error").text("");
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
            
            $("#updateAccount").submit(function(e) {
                e.preventDefault();
                const userId = {{ Auth::id() }};

                $(".text-danger").text(""); // clear previous errors

                let valid = true;

                // Get values
                let first_name = $('#first_name').val().trim();
                let last_name = $('#last_name').val().trim();
                let email = $('#email').val().trim();

                let mobile = $('#mobile_no').val().trim();

                // Regex
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                let mobileRegex = /^(03\d{9}|92\d{10}|\+92\d{10})$/;

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
                if (!valid) {
                    return;
                }



                let data = new FormData(this);
                $.ajax({
                    url: `/update_account_details/${userId}`,
                    method: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',

                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Account updated successfully!',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    },
                    error: function(err) {
                        alert('something went wrong')
                    }



                })


            });
            $("#passwordform").submit(function(e) {
                e.preventDefault();
                const userId = {{ Auth::id() }};

                $(".text-danger").text(""); // clear previous errors

                let valid = true;

                let currentPassword = $('#password').val().trim();
                let newPassword = $('#new_password').val().trim();
                let confirmPassword = $('#new_password_confirmation').val().trim();

                // Frontend validation
                if (currentPassword === "") {
                    $('#password_error').text("Current password is required.");
                    valid = false;
                }

                if (newPassword === "") {
                    $('#new_password_error').text("New password is required.");
                    valid = false;
                } else if (newPassword.length < 6) {
                    $('#new_password_error').text("New password must be at least 6 characters.");
                    valid = false;
                }

                if (confirmPassword === "") {
                    $('#new_password_confirmation_error').text("Please confirm your new password.");
                    valid = false;
                } else if (newPassword !== confirmPassword) {
                    $('#new_password_confirmation_error').text(
                        "New password and confirmation do not match.");
                    valid = false;
                }



                let data = new FormData(this);
                $.ajax({
                    url: `/update_password_details/${userId}`,
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
                            title: 'Account updated successfully!',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.password) {
                                $('#password_error').text(errors.password[0]);
                            }
                            if (errors.new_password) {
                                $('#new_password_error').text(errors.new_password[0]);
                            }
                            if (errors.new_password_confirmation) {
                                $('#new_password_confirmation_error').text(errors
                                    .new_password_confirmation[0]);
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Update Failed',
                                text: xhr.responseJSON?.message ||
                                    "Something went wrong.",
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'Close'
                            });
                        }
                    }



                });
            });



            $('.view-order-btn').on('click', function() {
                let products = $(this).data('products');

                // Safely parse the string to an actual array
                if (typeof products === 'string') {
                    try {
                        products = JSON.parse(products);
                    } catch (e) {
                        console.error("Failed to parse products JSON", e);
                        return;
                    }
                }

                if (!Array.isArray(products)) {
                    console.error("products is not an array after parsing:", products);
                    return;
                }

                const total = $(this).data('total');

                let html = '';
                products.forEach(item => {
                    html += `<tr>
                        <td><img src="/products/${item.product_images}" width="50" height="50"></td>
                    <td>${item.product_name}</td>
                    <td>${item.product_quantity}</td>
                    <td>${item.product_total_price}</td>
                </tr>`;
                });

                $('#orderProductsBody').html(html);
                $('#orderTotalPrice').text(parseFloat(total).toFixed(2));

                $('#orderDetailsModal').modal('show');
            });

        });
    </script>
@endsection
