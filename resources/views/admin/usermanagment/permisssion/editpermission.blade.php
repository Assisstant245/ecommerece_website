@extends('layout.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <section class="section w-100">
            <div class="section-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <form action="{{ route('admin.permission.update', $permission->id) }}" id="formbox"
                                method="POST">
                                <div class="card-header">
                                    <h4>Edit Permission</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        @csrf
                                        @method('PUT')
                                        <label>Permission Name</label>
                                        <input type="text" id="permission_name" name="permission_name"
                                            value="{{ $permission->name }}" class="form-control">
                                        <span class="text-danger" id="permission_name_error"></span>

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

            // permision input validations

            $("#permission_name").on("keyup", function() {
                var original = $(this).val();

                var check_name = /^[A-Za-z ]+$/;

                if (original.trim() === "") {
                    $("#permission_name_error").text("Category name is required.");
                } else if (!check_name.test(original)) {
                    $("#permission_name_error").text("Name should have only letters (A-Z or a-z).");
                } else {
                    $("#permission_name_error").text("");
                }

                // Clean the input for display
                var cleaned = original.replace(/[^A-Za-z ]/g, "");
                $(this).val(cleaned);
            });

        });

        // form submit with validations
        
        $("#formbox").on("submit", function(e) {
            e.preventDefault();
            $("#permission_name_error").text("");

            let permissionName = $("#permission_name").val().trim();
            let valid = true;

            // Regex: allow only letters (and optional spaces)
            let nameRegex = /^[A-Za-z\s]+$/;

            if (permissionName === "") {
                $("#permission_name_error").text("permission name is required.");
                valid = false;
            } else if (!nameRegex.test(permissionName)) {
                $("#permission_name_error").text("Only letters and spaces are allowed.");
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
                    console.log(res.message);
                    if (res.message) {
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
                            window.location.href = "{{ route('admin.permission.index') }}";
                        }, 3000);
                    } else {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Product was saved, but response was unclear.',
                            icon: 'warning',
                            confirmButtonText: 'Close'
                        });
                    }
                },

                error: function(err) {
                    if (err.status === 422) {
                        let errors = err.responseJSON.errors;
                        $('.text-danger').text('');
                        $.each(errors, function(field, messages) {
                            $(`#${field}_error`).text(messages[0]);
                        });
                    } else if (err.status === 409) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'warning',
                            title: err.responseJSON.message,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: err.responseJSON?.message ||
                                'Something went wrong.',
                            icon: 'error',
                            confirmButtonText: 'Close'
                        });
                    }
                }

            });
        });
    </script>
@endsection
