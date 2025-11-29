@extends('layout.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>View POS Products</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Product Image</th>
                                                <th>Product Name</th>

                                                <th>product sale price</th>
                                                <th>quantity</th>
                                                <th>action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $index => $product)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        @php
                                                            $images = json_decode($product->product_image, true);
                                                        @endphp

                                                        @if (is_array($images) && count($images))
                                                            <img src="{{ asset('products/' . $images[0]) }}" width="50"
                                                                height="50" class="rounded-circle me-1" />
                                                        @else
                                                            <span class="text-danger">No images</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $product->product_name }}</td>
                                                    <td>{{ $product->product_price }}</td>
                                                    <td>
                                                        <input type="number" id="qty_input_{{ $product->id }}"
                                                            class="form-control form-control-sm text-center" value="1"
                                                            min="1" style="max-width: 80px;" />
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <button
                                                                class="btn btn-success w-100 text-center m-2 add-to-cart"
                                                                style="max-width: 100px;" data-id="{{ $product->id }}">
                                                                Add
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>View cart Products</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>Product Image</th>
                                                <th>Product Name</th>

                                                <th>Sale Price</th>
                                                <th>Quantity</th>
                                                <th>total price</th>
                                                @can(['pos delete'])
                                                    <th>Remove</th>
                                                @endcan
                                            </tr>
                                        </thead>
                                        <tbody class="align-middle" id="cart-items">
                                            <tr>
                                                <td colspan="5" class="text-center">Loading...</td>
                                            </tr>
                                            <p>Sub Total<span id="subtotal">$0</span></p>


                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Billing form</h4>
                            </div>
                            <div class="card-body">
                                <form id="posorderForm">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label>First Name</label>
                                            <input class="form-control" name="first_name" id="first_name" type="text"
                                                value="{{ old('first_name') }}" placeholder="First Name">
                                            <span class="text-danger" id="first_name_error"></span>


                                        </div>
                                        <div class="col-md-6">
                                            <label>Last Name</label>
                                            <input class="form-control" type="text" name="last_name" id="last_name"
                                                value="{{ old('last_name') }}" placeholder="Last Name">
                                            <span class="text-danger" id="last_name_error"></span>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label>E-mail</label>
                                            <input class="form-control" type="text" name="email" id="email"
                                                value="{{ old('email') }}" placeholder="E-mail">
                                            <span class="text-danger" id="email_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Mobile No</label>
                                            <input class="form-control" type="text" name="mobile_no" id="mobile_no"
                                                value="{{ old('mobile_no') }}" placeholder="Mobile No">
                                            <span class="text-danger" id="mobile_no_error"></span>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <label>Address</label>
                                            <input class="form-control" type="text" name="address" id="address"
                                                placeholder="Address">

                                            <span class="text-danger" id="address_error"></span>
                                        </div>
                                        <div class="col-md-6 mb-4">
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
                                        <div class="col-md-6 mb-4">
                                            <label>State</label>
                                            <input class="form-control" id="state" name="state" type="text"
                                                placeholder="State">
                                            <span class="text-danger" id="state_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label>ZIP Code</label>
                                            <input class="form-control" id="zipcode" name="zipcode" type="text"
                                                placeholder="ZIP Code" value="">
                                            <span class="text-danger" id="zipcode_error"></span>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <button type="submit"
                                                class="w-full bg-red-600 hover:bg-red-700 text-black font-bold py-3 rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300 ease-in-out">
                                                Place Order
                                            </button>
                                        </div>


                                    </div>
                            </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>


    </div>
    </div>
    <script>
        // getting data add to cart
        function viewdata() {
            $.ajax({
                url: "{{ route('admin.admin.getAddToCart') }}",
                type: 'GET',
                success: function(data) {
                    let subtotal = 0;
                    let html = '';
                    if (data.length === 0) {
                        html = `<tr><td colspan="5" class="text-center">Cart is empty</td></tr>`;
                    } else {
                        data.forEach(function(item) {
                            subtotal += parseFloat(item.total_price);


                            html += `
                        <tr>
                            <td><img src="/products/${item.cart_product_image}" alt="${item.cart_product_name}" style="width: 50px;"></td>
                            <td>${item.cart_product_name}</td>
                            <td>$${item.cart_product_sale_price}</td>
                            <td>
                            <div class="qty d-flex align-items-center gap-2">
    <!-- Minus Button (Green) -->
    <button type="button" class="btn btn-success btn-sm rounded-circle px-2"
        onclick="updateQuantity('d1_${item.id}')">
        <i class="fa fa-minus"></i>
    </button>

    <!-- Quantity Input (Centered) -->
    <input type="text"
        class="form-control text-center px-2 py-1"
        value="${item.cart_quantity}" readonly
        style="width: 60px;">

    <!-- Plus Button (Red) -->
    <button type="button" class="btn btn-danger btn-sm rounded-circle px-2"
        onclick="updateQuantity('i1_${item.id}')">
        <i class="fa fa-plus"></i>
    </button>
</div>

                            </td>
                            <td>$${item.total_price}</td>
                            <td>
                            @can('pos delete')
                            <button class="btn btn-danger delete-btn w-100 text-center" data-id="${item.id}" style="max-width: 100px;">
                            <i class="fas fa-trash-alt"></i>
                             </button> 
                             @endcan
                            </td>

                        </tr>
                    `;

                        });

                    }
                    $('#subtotal').text(`$${subtotal.toFixed(2)}`);

                    $('#cart-items').html(html);

                },
                error: function(err) {
                    console.error("Error loading cart:", err.responseText);
                }
            });
        }
        viewdata();
        // update quantity

        function updateQuantity(data) {
            var values = data.split('_');
            var incrementdecrement = values[0];
            var cartid = values[1];
            $.ajax({
                url: '{{ route('admin.admin.pos_update_quantity') }}',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token for Laravel
                    incrementdecrement: incrementdecrement,
                    cart_id: cartid
                },
                success: function(response) {
                    console.log(response);
                    viewdata();
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });
        }

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

            //   add to cart product
            $(document).on('click', '.add-to-cart', function(e) {
                e.preventDefault();

                let productId = $(this).data('id');
                const quantity = $('#qty_input_' + productId).val();

                $.ajax({
                    url: '{{ route('admin.admin.pos_add_admin_cart') }}',
                    type: 'POST',
                    data: {
                        product_id: productId,
                        quantity: quantity,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            toast: true,
                            position: 'top-end',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        viewdata();
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: err.responseJSON?.message ||
                                'Unexpected error occurred',
                            toast: true,
                            position: 'top-end',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }

                });
            });


            // store pos billing form

            $('#posorderForm').on('submit', function(e) {
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
                        url: "{{ route('admin.admin.pos_add_admin_bill') }}",
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
                                    window.location.href =
                                        "{{ route('admin.getorders') }}";
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
        });

        // delete the add to cart product
        $(document).on('click', '.delete-btn', function() {

            const id = $(this).data('id');
            const target = this;
            Swal.fire({
                title: 'Are you sure?',
                text: "This item will be removed from your cart!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/admincart/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Item has been removed from your cart.',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            });

                            // $(target).closest('tr').fadeOut();
                            viewdata();
                        },
                        error: function(xhr) {
                            console.error("Delete failed:", xhr.responseText);
                            Swal.fire('Error!', 'Something went wrong!', 'error');
                        }
                    });
                }
            });
        });
    </script>
@endsection
