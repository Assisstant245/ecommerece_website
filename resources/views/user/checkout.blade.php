@extends('layout.user_app')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/product_list') }}">Products</a></li>
                <li class="breadcrumb-item active">Checkout</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Checkout Start -->
    <div class="checkout">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-inner">
                        <div class="billing-address">
                            <h2>Billing Address</h2>
                            <form id="orderForm">
                                <div class="row">

                                    <div class="col-md-6">
                                        <label>First Name</label>
                                        <input class="form-control" name="first_name" id="first_name" type="text"
                                            value="{{ old('first_name', Auth::user()->first_name ?? '') }}"
                                            placeholder="First Name">
                                        <span class="text-danger" id="first_name_error"></span>


                                    </div>
                                    <div class="col-md-6">
                                        <label>Last Name</label>
                                        <input class="form-control" type="text" name="last_name" id="last_name"
                                            value="{{ old('last_name', Auth::user()->last_name ?? '') }}"
                                            placeholder="Last Name">
                                        <span class="text-danger" id="last_name_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>E-mail</label>
                                        <input class="form-control" type="text" name="email" id="email"
                                            value="{{ old('email', Auth::user()->email ?? '') }}" placeholder="E-mail">
                                        <span class="text-danger" id="email_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Mobile No</label>
                                        <input class="form-control" type="text" name="mobile_no" id="mobile_no"
                                            value="{{ old('mobile_no', Auth::user()->mobile_no ?? '') }}"
                                            placeholder="Mobile No">
                                        <span class="text-danger" id="mobile_no_error"></span>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Address</label>
                                        <input class="form-control" type="text" name="address" id="address"
                                            placeholder="Address">

                                        <span class="text-danger" id="address_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Country</label>
                                        <select class="custom-select" id="country" id="country" name="country">
                                            <option selected>sub continent</option>
                                            <option name='afg'>pakistan</option>
                                            <option name='alb'>india</option>
                                            <option name='alg'>bangladesh</option>
                                        </select>
                                        <span class="text-danger" id="country_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>City</label>
                                        <input class="form-control" id="city" name="city" type="text"
                                            placeholder="City">
                                        <span class="text-danger" id="city_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>State</label>
                                        <input class="form-control" id="state" name="state" type="text"
                                            placeholder="State">
                                        <span class="text-danger" id="state_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>ZIP Code</label>
                                        <input class="form-control" id="zipcode" name="zipcode" type="text"
                                            placeholder="ZIP Code">
                                        <span class="text-danger" id="zipcode_error"></span>
                                    </div>


                                </div>
                        </div>


                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="checkout-inner">

                        <div class="checkout-summary">
                            <h1>Cart Total</h1>

                            @php $subtotal = 0; @endphp

                            @foreach ($cartItems as $item)
                                @php
                                    $subtotal += $item->total_price;
                                @endphp
                                {{-- @php
                                    $images = json_decode($item->cart_product_image, true);
                                    $images_json = json_encode($images); 
                                @endphp
                                @dump($images_json) --}}

                                <p>{{ $item->cart_product_name }} x {{ $item->cart_quantity }}</p>
                                <p>${{ $item->total_price }}</p>
                                <input type="hidden" name="cart_product_name[]" value="{{ $item->cart_product_name }}">
                                <input type="hidden" name="cart_quantity[]" value="{{ $item->cart_quantity }}">
                                <input type="hidden" name="cart_product_sale_price[]" value="{{ $item->cart_product_sale_price }}">
                                <input type="hidden" name="cart_product_sku[]" value="{{ $item->cart_product_sku }}">
                                <input type="hidden" name="total_price[]" value="{{ $item->total_price }}">
                                <input type="hidden" name="product_image[]" value="{{ $item->cart_product_image }}">
                            @endforeach

                            <p class="sub-total">Sub Total <span>${{ $subtotal }}</span></p>
                            <h2>Grand Total <span>${{ $subtotal }}</span></h2> {{-- you can add shipping here if needed --}}
                        </div>



                        <div class="checkout-payment">
                            <div class="checkout-btn">
                                <button type="submit">Place Order</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
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
                    $("#last_name_error").text("First Name should have only letters (A-Z or a-z).");
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
            $("#address").on("keyup", function() {
                let address = $(this).val().trim();
                if (address === "") {
                    $("#address_error").text("Address is required.");
                } else {
                    $("#address_error").text("");
                }
            });

            // City
            $("#city").on("keyup", function() {
                var original = $(this).val();

                var cityPattern = /^[A-Za-z ]+$/;

                if (original.trim() === "") {
                    $("#city_error").text("");
                } else if (!cityPattern.test(original)) {
                    $("#city_error").text("City should contain only letters.");
                } else {
                    $("#city_error").text("");
                }

                // Clean input for display
                var cleaned = original.replace(/[^A-Za-z ]/g, "");
                $(this).val(cleaned);
            });

            // State
            $("#state").on("keyup", function() {
                var original = $(this).val();

                var statePattern = /^[A-Za-z ]+$/;

                if (original.trim() === "") {
                    $("#state_error").text("");
                } else if (!statePattern.test(original)) {
                    $("#state_error").text("State should contain only letters.");
                } else {
                    $("#state_error").text("");
                }

                // Clean input for display
                var cleaned = original.replace(/[^A-Za-z ]/g, "");
                $(this).val(cleaned);
            });
            // zip code
            $("#zipcode").on("keyup", function() {
                var original = $(this).val();

                var zipPattern = /^[0-9]{5,10}$/;

                if (original.trim() === "") {
                    $("#zipcode_error").text("");
                } else if (!zipPattern.test(original)) {
                    $("#zipcode_error").text("ZIP Code must be in numbers.");
                } else {
                    $("#zipcode_error").text("");
                }

                // Clean input for display: remove anything that's not a digit
                var cleaned = original.replace(/[^0-9]/g, "");
                $(this).val(cleaned);
            });



            // Country
            $("#country").on("change", function() {
                let value = $(this).val();
                if (value === "") {
                    $("#country_error").text("Please select a country.");
                } else {
                    $("#country_error").text("");
                }
            });

        })


        $('#orderForm').on('submit', function(e) {
            e.preventDefault();

            let hasError = false;

            // First Name
            let first_name = $("#first_name").val().trim();
            if (first_name === "") {
                $("#first_name_error").text("First Name is required.");
                hasError = true;
            }

            // Last Name
            let last_name = $("#last_name").val().trim();
            if (last_name === "") {
                $("#last_name_error").text("Last Name is required.");
                hasError = true;
            }

            // Email
            let email = $("#email").val().trim();
            let check_email = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
            if (email === "") {
                $("#email_error").text("Email is required.");
                hasError = true;
            } else if (!check_email.test(email)) {
                $("#email_error").text("Invalid email format.");
                hasError = true;
            }

            // Mobile No
            let mobile = $("#mobile_no").val().trim();
            let check_mobile = /^92[0-9]{10}$/;
            if (mobile === "") {
                $("#mobile_no_error").text("Mobile no is required.");
                hasError = true;
            } else if (!check_mobile.test(mobile)) {
                $("#mobile_no_error").text("Mobile no must start with '92' and be 12 digits.");
                hasError = true;
            }

            // Address
            let address = $("#address").val().trim();
            if (address === "") {
                $("#address_error").text("Address is required.");
                hasError = true;
            }

            // City
            let city = $("#city").val().trim();
            if (city === "") {
                $("#city_error").text("City is required.");
                hasError = true;
            }

            // State
            let state = $("#state").val().trim();
            if (state === "") {
                $("#state_error").text("State is required.");
                hasError = true;
            }

            // ZIP Code
            let zip = $("#zipcode").val().trim();
            let zipPattern = /^[0-9]{5,10}$/;
            if (zip === "") {
                $("#zipcode_error").text("ZIP Code is required.");
                hasError = true;
            } else if (!zipPattern.test(zip)) {
                $("#zipcode_error").text("ZIP Code must be innumbers.");
                hasError = true;
            }

            // Country
            let country = $("#country").val().trim();
            if (country === "") {
                $("#country_error").text("Please select a country.");
                hasError = true;
            }

            // Final decision
            if (!hasError) {
                // No errors: submit via AJAX
                let mydata = new FormData(this);

                $.ajax({
                    url: "{{ route('place.order') }}",
                    method: "POST",
                    data: mydata,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Order Placed!',
                            text: 'Your order has been placed successfully.',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "";
                            }
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 409) {
                            // Show in SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Duplicate Email',
                                text: xhr.responseJSON
                                    .message, // shows: "This email has already been used..."
                            });

                            // OR show in span below email field
                            $("#email_error").text(xhr.responseJSON.message);
                        } else {
                            console.log(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while placing the order.'
                            });
                        }
                    }

                });
            }
        });
    </script>
@endsection
<!-- Checkout End -->
