@extends('layout.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <section class="section w-100">
            <div class="section-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <form action="{{ route('admin.subcategory.update', $subcategory->id) }}" id="formbox"
                                method="POST">
                                <div class="card-header">
                                    <h4>Edit Sub Category</h4>
                                </div>
                                <div class="card-body">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="category_id">Select Category</label>
                                        <select name="category_id" id="category_id" class="form-control" required>
                                            <option value="">-- Select Category --</option>
                                            @foreach ($category as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="category_id_error"></span>
                                    </div>

                                    <div class="form-group">

                                        <label>Sub Category Name</label>
                                        <input type="text" id="sub_category_name" name="sub_category_name"
                                            value="{{ $subcategory->sub_category_name }}" class="form-control">
                                        <span class="text-danger" id="sub_category_name_error"></span>

                                    </div>

                                    <div class="form-group mb-0">
                                        <label>Description</label>
                                        <textarea class="form-control" id="sub_category_description" name="sub_category_description">{{ $subcategory->sub_category_description }}</textarea>
                                        <span class="text-danger" id="sub_category_description_error"></span>

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

            // vaidation input

            $("#sub_category_name").on("keyup", function() {
                var original = $(this).val();

                var check_name = /^[A-Za-z ]+$/;

                if (original.trim() === "") {
                    $("#sub_category_name_error").text("sub Category name is required.");
                } else if (!check_name.test(original)) {
                    $("#sub_category_name_error").text("Name should have only letters (A-Z or a-z).");
                } else {
                    $("#sub_category_name_error").text("");
                }

                // Clean the input for display
                var cleaned = original.replace(/[^A-Za-z ]/g, "");
                $(this).val(cleaned);
            });

            // form submit subcategory with validations
            
            $("#formbox").on("submit", function(e) {
                e.preventDefault();
                $("#sub_category_name_error").text("");
                $("#sub_category_description_error").text("");

                let subcategoryName = $("#sub_category_name").val().trim();
                let description = $("#sub_category_description").val().trim();
                let valid = true;

                // Regex: allow only letters (and optional spaces)
                let nameRegex = /^[A-Za-z\s]+$/;

                if (subcategoryName === "") {
                    $("#sub_category_name_error").text("Category name is required.");
                    valid = false;
                } else if (!nameRegex.test(subcategoryName)) {
                    $("#sub_category_name_error").text("Only letters and spaces are allowed.");
                    valid = false;
                }

                if (description === "") {
                    $("#sub_category_description_error").text("Description is required.");
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
                                    "{{ route('admin.subcategory.index') }}";
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

                            $('#formbox')[0].reset();

                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.subcategory.index') }}";
                            }, 3000);
                            btn.prop("disabled", false).text("subcategory");

                        }
                    },

                    error: function(err) {
                        console.log("AJAX Error Response:", err);

                        if (err.status === 422) {
                            let errors = err.responseJSON.errors;

                            // Clear all previous error messages
                            $('.text-danger').text('');

                            // Loop through errors and show them next to corresponding field
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
