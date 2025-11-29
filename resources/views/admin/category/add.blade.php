@extends('layout.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <section class="section w-100">
            <div class="section-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <form action="{{ route('admin.categories.store') }}" id="formbox" method="POST">
                                <div class="card-header">
                                    <h4>Add Category</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        @csrf
                                        <label>Category Name</label>
                                        <input type="text" id="category_name" name="category_name" value=""
                                            class="form-control">
                                        <span class="text-danger" id="category_name_error"></span>

                                    </div>

                                    <div class="form-group mb-0">
                                        <label>Description</label>
                                        <textarea class="form-control" id="category_description" name="category_description" value="category_description"></textarea>
                                        <span class="text-danger" id="category_description_error"></span>

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

            // input validation 
            
            $("#category_name").on("keyup", function() {
                var original = $(this).val();

                var check_name = /^[A-Za-z ]+$/;

                if (original.trim() === "") {
                    $("#category_name_error").text("Category name is required.");
                } else if (!check_name.test(original)) {
                    $("#category_name_error").text("Name should have only letters (A-Z or a-z).");
                } else {
                    $("#category_name_error").text("");
                }

                // Clean the input for display
                var cleaned = original.replace(/[^A-Za-z ]/g, "");
                $(this).val(cleaned);
            });

            // category submit form


            $("#formbox").on("submit", function(e) {
                e.preventDefault();

                // Clear previous errors
                $("#category_name_error").text("");
                $("#category_description_error").text("");

                let categoryName = $("#category_name").val().trim();
                let description = $("#category_description").val().trim();
                let valid = true;

                // Regex: allow only letters (and optional spaces)
                let nameRegex = /^[A-Za-z\s]+$/;

                if (categoryName === "") {
                    $("#category_name_error").text("Category name is required.");
                    valid = false;
                } else if (!nameRegex.test(categoryName)) {
                    $("#category_name_error").text("Only letters and spaces are allowed.");
                    valid = false;
                }

                if (description === "") {
                    $("#category_description_error").text("Description is required.");
                    valid = false;
                }

                if (!valid) return;

                let formData = new FormData(this);
                let btn = $(this).find("button[type=submit]");
                btn.prop("disabled", true).text("Processing...");
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
                                    "{{ route('admin.categories.index') }}";
                            }, 3000);

                        }
                        else{

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
                                "{{ route('admin.categories.index') }}";
                        }, 3000);
                        btn.prop("disabled", false).text("category");

                    }
                },
                    error: function(err) {
                        if (err.status === 422) {
                            let errors = err.responseJSON.errors;
                            $('.text-danger').text('');
                            $.each(errors, function(field, messages) {
                                $(`#${field}_error`).text(messages[0]);
                            });
                            btn.prop("disabled", false).text("category");


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
