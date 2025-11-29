@extends('layout.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <section class="section w-100">
            <div class="section-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <form action="{{ route('admin.product.update', $product->id) }}" id="formbox" method="POST">
                                <div class="card-header">
                                    <h4>Edit Product</h4>
                                </div>
                                <div class="card-body">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        {{-- <label class="form-label">Select Category</label> --}}
                                        <select name="category_id" id="category_name" class="form-select form-control">
                                            <option value="">-- Select Category --</option>
                                            @foreach ($category as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Subcategory --}}
                                    <div class="mb-3">
                                        <select name="subcategory_id" id="subcategory_name"
                                            class="form-select form-control">
                                            <option value="">-- Select Sub Category --</option>
                                            {{-- {{ $category->id == $product->category_id ? 'selected' : '' }} --}}
                                        </select>
                                        <span class="text-danger" id="sub_category_name_error"></span>

                                    </div>
                                    <div class="form-group">

                                        <label>Product Name</label>
                                        <input type="text" id="product_name" name="product_name"
                                            value="{{ $product->product_name }}" class="form-control">
                                        <span class="text-danger" id="product_name_error"></span>

                                    </div>

                                    <div class="form-group mb-0">
                                        <label>Description</label>

                                        <textarea class="form-control" id="product_description" name="product_description">{{ $product->product_description }}</textarea>
                                        <span class="text-danger" id="product_description_error"></span>

                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Image</label>
                                        <input type="file" id="product_image" name="product_image[]"
                                            value="{{ $product->product_image }}" multiple>
                                        @php
                                            $images = json_decode($product->product_image, true);
                                        @endphp

                                        @if (is_array($images) && count($images))
                                            <img src="{{ asset('products/' . $images[0]) }}" width="50" height="50"
                                                class="rounded-circle me-1" />
                                        @else
                                            <span class="text-danger">No images</span>
                                        @endif

                                        <span class="text-danger" id="product_image_error"></span>

                                    </div>
                                    {{-- Wholesale Price --}}
                                    <div class="mb-3">
                                        <label class="form-label">Product Wholesale Price</label>
                                        <input type="text" name="product_whole_price" id="product_whole_price"
                                            value="{{ $product->product_whole_price }}" class="form-control" step="0.01"
                                            min="0" placeholder="Enter price">
                                        <span class="text-danger" id="product_whole_price_error"></span>

                                    </div>

                                    {{-- Sale Price --}}
                                    <div class="mb-3">
                                        <label class="form-label">Product Sale Price</label>
                                        <input type="text" name="product_sale_price" id="product_sale_price"
                                            value="{{ $product->product_price }}" class="form-control" step="0.01"
                                            min="0" placeholder="Enter price">
                                        <span class="text-danger" id="product_sale_price_error"></span>
                                    </div>

                                    {{-- SKU --}}
                                    <div class="mb-3">
                                        <label class="form-label">SKU</label>
                                        <input type="text" class="form-control" value="{{ $product->sku }}"
                                            id="product_sku" name="product_sku" placeholder="e.g., ABC-1234">
                                        <span class="text-danger" id="product_sku_error"></span>
                                    </div>

                                    {{-- Product Status --}}
                                    <div class="mb-3">
                                        <label class="form-label">Product Status</label><br>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="product_status"
                                                id="statusOnline" value="online"
                                                {{ $product->product_status === 'online' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="statusOnline">Online</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="product_status"
                                                id="statusOffline" value="offline"
                                                {{ $product->product_status === 'offline' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="statusOffline">Offline</label>
                                        </div>
                                    </div>

                                    <span class="text-danger" id="product_status_error"></span>

                                </div>

                        </div>
                        <div class="card-footer text-right">
                            <button type='submit' class="btn btn-primary">Submit</button>
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
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            const maxSizeInBytes = 2 * 1024 * 1024; // 2 MB

            // get subcategories according to one category

            var selectedSubcategoryId = "{{ $product->subcategory_id ?? '' }}";

            $('#category_name').on('change', function() {
                var categoryId = $(this).val();

                if (categoryId) {
                    $.ajax({
                        url: '/admin/product/subcategories/' + categoryId,
                        type: 'GET',
                        success: function(subcategories) {
                            var subcategorySelect = $('#subcategory_name');
                            subcategorySelect.empty()
                                .append(
                                    '<option value="">-- Select Sub Category --</option>'
                                );

                            $.each(subcategories, function(i, subcat) {
                                var selected = (subcat.id ==
                                        selectedSubcategoryId) ?
                                    'selected' : '';
                                subcategorySelect.append(
                                    '<option value="' + subcat.id +
                                    '" ' + selected + '>' +
                                    subcat.sub_category_name +
                                    '</option>'
                                );
                            });
                        },
                        error: function() {
                            alert('Could not fetch subcategories');
                        }
                    });
                } else {
                    $('#subcategory_name').html(
                        '<option value="">-- Select Sub Category --</option>');
                }
            });

            if (selectedSubcategoryId) {
                $('#category_name').trigger('change');
            }

            // start check single inputs validations

            // product name

            $("#product_name").on("keyup", function() {
                var original = $(this).val();

                var check_name = /^[A-Za-z ]+$/;

                if (original.trim() === "") {
                    $("#product_name_error").text("");
                } else if (!check_name.test(original)) {
                    $("#product_name_error").text("Name should have only letters (A-Z or a-z).");
                } else {
                    $("#product_name_error").text("");
                }

                // Clean the input for display
                var cleaned = original.replace(/[^A-Za-z ]/g, "");
                $(this).val(cleaned);
            });
            $("#product_image").on("change", function() {
                $("#product_image_error").text("");


                let files = this.files;
                let errorMessages = [];

                for (let i = 0; i < files.length; i++) {
                    let file = files[i];

                    // Check type
                    if (!allowedTypes.includes(file.type)) {
                        errorMessages.push(
                            `File "${file.name}" is not a valid image. Only JPG, PNG allowed.`);
                    }

                    // Check size
                    if (file.size > maxSizeInBytes) {
                        errorMessages.push(`File "${file.name}" is too big. Max size allowed is 2MB.`);
                    }
                }

                if (errorMessages.length > 0) {
                    $("#product_image_error").html(errorMessages.join("<br>"));
                    $(this).val('');
                }
            });




            //  Wholesale Price
            $("#product_whole_price").on("keyup", function() {
                var original = $(this).val();

                // Validate format: only digits and optional decimal with max 2 places
                var check_price = /^\d+(\.\d{0,2})?$/;

                if (original.trim() === "") {
                    $("#product_whole_price_error").text("");
                } else if (!check_price.test(original)) {
                    $("#product_whole_price_error").text(
                        "only numbers are allowed!Enter a valid price (e.g., 12.99).");
                } else {
                    $("#product_whole_price_error").text("");
                }

                // Clean visually: allow only digits and one decimal point
                var cleaned = original.replace(/[^0-9.]/g, "");
                var parts = cleaned.split('.');
                if (parts.length > 2) {
                    cleaned = parts[0] + '.' + parts[1]; // Keep only first decimal
                }
                $(this).val(cleaned);
            });

            // Sale Price
            $("#product_sale_price").on("keyup", function() {
                var original = $(this).val();

                // Validate format: only digits and optional decimal with max 2 places
                var check_price = /^\d+(\.\d{0,2})?$/;

                if (original.trim() === "") {
                    $("#product_sale_price_error").text("");
                } else if (!check_price.test(original)) {
                    $("#product_sale_price_error").text(
                        "only allowed numbers!Enter a valid price (e.g., 12.99).");
                } else {
                    $("#product_sale_price_error").text("");
                }

                // Clean visually: allow only digits and one decimal point
                var cleaned = original.replace(/[^0-9.]/g, "");
                var parts = cleaned.split('.');
                if (parts.length > 2) {
                    cleaned = parts[0] + '.' + parts[1]; // Keep only first decimal
                }
                $(this).val(cleaned);
            });

            //SKU Format
            $("#product_sku").on("keyup", function() {
                let original = $(this).val().toUpperCase(); // Convert to uppercase

                // Check format: 3 letters, hyphen, 4 numbers
                let check_sku = /^[A-Z]{3}-\d{4}$/;

                if (original.trim() === "") {
                    $("#product_sku_error").text("");
                } else if (!check_sku.test(original)) {
                    $("#product_sku_error").text("SKU must be in format ABC-1234.");
                } else {
                    $("#product_sku_error").text("");
                }

                // Clean visually: allow only uppercase letters, numbers, and one hyphen
                let cleaned = original.replace(/[^A-Z0-9\-]/g, "");

                // Only keep first hyphen if multiple
                let parts = cleaned.split("-");
                if (parts.length > 2) {
                    cleaned = parts[0] + "-" + parts[1];
                }

                $(this).val(cleaned);
            });

            // end validationseperate inputs

            // edit form submit
            
            $("#formbox").on("submit", function(e) {
                e.preventDefault();
                $(".text-danger").text("");

                let productName = $("#product_name").val().trim();
                let description = $("#product_description").val().trim();
                let wholesalePrice = $("#product_whole_price").val().trim();
                let salePrice = $("#product_sale_price").val().trim();
                let sku = $("#product_sku").val().trim();
                let productStatus = $("input[name='product_status']:checked").val();

                let valid = true;

                // Regex
                let nameRegex = /^[A-Za-z\s]+$/;
                let priceRegex = /^\d+(\.\d{1,2})?$/;
                let skuRegex = /^[A-Z]{3}-\d{4}$/;

                if (productName === "") {
                    $("#product_name_error").text("Product name is required.");
                    valid = false;
                } else if (!nameRegex.test(productName)) {
                    $("#product_name_error").text("Only letters and spaces are allowed.");
                    valid = false;
                }

                if (description === "") {
                    $("#product_description_error").text("Description is required.");
                    valid = false;
                }

                if (wholesalePrice === "") {
                    $("#product_whole_price_error").text("Wholesale price is required.");
                    valid = false;
                } else if (!priceRegex.test(wholesalePrice)) {
                    $("#product_whole_price_error").text("Enter a valid price (e.g., 12.99).");
                    valid = false;
                }

                if (salePrice === "") {
                    $("#product_sale_price_error").text("Sale price is required.");
                    valid = false;
                } else if (!priceRegex.test(salePrice)) {
                    $("#product_sale_price_error").text("Enter a valid price (e.g., 9.99).");
                    valid = false;
                }

                if (sku === "") {
                    $("#product_sku_error").text("SKU is required.");
                    valid = false;
                } else if (!skuRegex.test(sku)) {
                    $("#product_sku_error").text("SKU must be in format ABC-1234.");
                    valid = false;
                }

                if (!productStatus) {
                    $("#product_status_error").text("Please select a product status.");
                    valid = false;
                }


                if (!valid) return;
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

                        if (res.status === 'exists') {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'warning',
                                title: res.message,
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.product.index') }}";
                            }, 3000);
                        } else {

                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: res.message,
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                            let selectedCategory = $('#category_name').val();
                            $('#formbox')[0].reset();
                            if (selectedCategory) {
                                $('#category_name').val(selectedCategory).trigger('change');
                            }


                            setTimeout(() => {
                                window.location.href =
                                    "{{ route('admin.product.index') }}";
                            }, 3000);
                        }
                    },
                    error: function(err) {
                        console.log("AJAX Error Response:", err);

                        if (err.status === 422) {
                            let errors = err.responseJSON.errors;

                            // Clear all previous error messages
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
