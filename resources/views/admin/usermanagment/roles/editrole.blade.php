@extends('layout.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <section class="section w-100">
            <div class="section-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <form action="{{ route('admin.roles.update', $roles->id) }}" id="formbox" method="POST">
                                <div class="card-header">
                                    <h4>Edit Roles</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        @csrf
                                        @method('PUT')
                                        <label>Role Name</label>
                                        <input type="text" id="role_name" name="role_name" value="{{ $roles->name }}"
                                            class="form-control">
                                        <span class="text-danger" id="role_name_error"></span>

                                    </div>
                                    <div class="form-group">
                                        <div class="form-group position-relative" style="position: relative;">
                                            <label for="permission_input">Select Permissions</label>
                                            <input type="text" id="permission_input" class="form-control"
                                                placeholder="Search permissions...">

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

                                            <div id="selected_permissions" class="mt-2 flex flex-wrap gap-2">
                                                @foreach ($roles->permissions as $perm)
                                                    <div class="bg-blue-100 badge badge-primary text-blue-800 text-xs px-2 py-1 rounded mr-2 mb-2 flex items-center removable-tag "
                                                        data-id="{{ $perm->id }}">
                                                        <span>{{ $perm->name }}</span>
                                                        <span
                                                            class="remove-tag ml-2 font-bold text-red-400 hover:text-red-600 cursor-pointer">&times;</span>

                                                        <input type="hidden" name="permissions[]"
                                                            value="{{ $perm->id }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

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
            const $input = $('#permission_input');
            const $dropdown = $('#permission_dropdown');
            const $selected = $('#selected_permissions');

            const selectedIds = new Set();
            $('#selected_permissions .removable-tag').each(function() {
                const id = $(this).data('id');

                // Step 2: Find corresponding dropdown item
                const $dropdownItem = $(`#permission_dropdown .dropdown-item[data-id="${id}"]`);

                // Step 3: Add 'selected' class and checkmark icon if not already present
                if (!$dropdownItem.hasClass('selected')) {
                    $dropdownItem.addClass('selected');
                    $dropdownItem.append('<span class="float-right text-success">&#10003;</span>');
                }
            });
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

            $selected.on('click', '.remove-tag', function() {
                const $tag = $(this).closest('.removable-tag');
                const id = $tag.data('id');
                selectedIds.delete(id);
                $tag.remove();
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

        });
        $("#formbox").on("submit", function(e) {
            e.preventDefault();
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
                            window.location.href = "{{ route('admin.roles.index') }}";
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
