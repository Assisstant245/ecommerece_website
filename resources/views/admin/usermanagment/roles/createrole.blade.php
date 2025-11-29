@extends('layout.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <section class="section w-100">
            <div class="section-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <form action="{{ route('admin.roles.store') }}" id="formbox" method="POST">
                                <div class="card-header">
                                    <h4>Add Role</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        @csrf
                                        <label>Role Name</label>
                                        <input type="text" id="role_name" name="role_name" value=""
                                            class="form-control">
                                        <span class="text-danger" id="role_name_error"></span>

                                    </div>
                                    <div class="form-group">
                                        <!-- Input Field -->
                                        <div class="form-group position-relative" style="position: relative;">
                                            <label for="permission_input">Select Permissions</label>
                                            <input type="text" id="permission_input" class="form-control multiple"
                                                placeholder="Search permissions...">

                                            <!-- Dropdown List -->
                                            <div id="permission_dropdown"
                                                class="bg-white border border-gray-300 mt-1 rounded"
                                                style="display:none; max-height: 200px; overflow-y: auto; position: absolute; width: 100%; z-index: 1000;">
                                                @foreach ($permission as $perm)
                                                    <div class="dropdown-item p-2 cursor-pointer border-b hover:bg-gray-100"
                                                        data-id="{{ $perm->id }}" data-name="{{ $perm->name }}">
                                                        {{ $perm->name }}
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Selected Permissions -->
                                            <div id="selected_permissions" class="mt-2 flex flex-wrap gap-2"></div>
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
        // Remove tag on click


        $(document).ready(function() {

            const $input = $('#permission_input');
            const $dropdown = $('#permission_dropdown');
            const $selected = $('#selected_permissions');

            const selectedIds = new Set();
            $selected.on('click', '.remove-tag', function() {
                const $tag = $(this).closest('.removable-tag');
                const id = $tag.data('id');

                selectedIds.delete(id);
                $tag.remove(); 
            });



            // Show dropdown on input focus
            $input.on('focus', function() {
                $dropdown.show();
            });

            // Hide dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.form-group').length) {
                    $dropdown.hide();
                }
            });

            // Filter permissions on typing
            $input.on('input', function() {
                const filter = $(this).val().toLowerCase();
                $dropdown.children().each(function() {
                    const name = $(this).data('name').toLowerCase();
                    $(this).toggle(name.includes(filter));
                });
            });

            // Click on permission
            $dropdown.on('click', '.dropdown-item', function(e) {
                e.stopPropagation(); 

                const $item = $(this);
                const id = $item.data('id');
                const name = $item.data('name');

                if (!selectedIds.has(id)) {
                    selectedIds.add(id);

                    // Mark item as selected with icon
                    $item.addClass('selected').append(
                        '<span class="float-right text-success">&#10003;</span>');

                    // Hidden input for submission
                    const hiddenInput = $('<input>').attr({
                        type: 'hidden',
                        name: 'permissions[]',
                        value: id
                    });

                    // Tag with remove button
                    const tag = $(`
            <span class="badge badge-primary mr-2 mb-2 removable-tag" 
                  data-id="${id}" 
                  style="display:inline-flex; align-items:center;">
                ${name}
                <span class="ml-2 text-white cursor-pointer remove-tag" 
                      style="font-weight:bold;">&times;</span>
            </span>
        `);

                    tag.append(hiddenInput);
                    $selected.append(tag);

                } else {
                    // If already selected, remove from list
                    selectedIds.delete(id);
                    $item.removeClass('selected').find('span.text-success').remove();
                    $selected.find(`.removable-tag[data-id="${id}"]`).remove();
                }

                // Keep dropdown open
                $input.val('').trigger('input');
            });
            
            // Hide dropdown only when clicking outside both input and dropdown
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#permission_input, #permission_dropdown').length) {
                    $dropdown.hide();
                }
            });

            $("#role_name").on("keyup", function() {
                var original = $(this).val();

                var check_name = /^[A-Za-z ]+$/;

                if (original.trim() === "") {
                    $("#role_name_error").text("role name is required.");
                } else if (!check_name.test(original)) {
                    $("#role_name_error").text("Name should have only letters (A-Z or a-z).");
                } else {
                    $("#role_name_error").text("");
                }

                // Clean the input for display
                var cleaned = original.replace(/[^A-Za-z ]/g, "");
                $(this).val(cleaned);
            });


            $("#formbox").on("submit", function(e) {
                e.preventDefault();

                // Clear previous errors
                $("#role_name_error").text("");

                let roleName = $("#role_name").val().trim();
                let valid = true;

                // Regex: allow only letters (and optional spaces)
                let nameRegex = /^[A-Za-z\s]+$/;

                if (roleName === "") {
                    $("#role_name_error").text("role name is required.");
                    valid = false;
                } else if (!nameRegex.test(roleName)) {
                    $("#role_name_error").text("Only letters and spaces are allowed.");
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
                            window.location.href = "{{ route('admin.roles.index') }}";
                        }, 3000);
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

        });
    </script>
@endsection
