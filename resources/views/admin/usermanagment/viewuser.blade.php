@extends('layout.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>View Users</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="tableExport"style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Email</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>


                                                <th>Roles</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user as $user)
                                                <tr>
                                                    <td>{{ $user->id }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->first_name }}</td>
                                                    <td>{{ $user->last_name }}</td>



                                                    <td>
                                                        @if ($user->roles->isNotEmpty())
                                                            @foreach ($user->roles as $role)
                                                                <span class="badge badge-primary">{{ $role->name }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">No Roles</span>
                                                        @endif
                                                    </td>


                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            @can('edit user')
                                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                                class="btn btn-success w-100 text-center m-2"
                                                                style="max-width: 100px;">Edit</a>
                                                                @endcan
                                                                @can('delete user')

                                                            <form class="deleteForm"
                                                                action="{{ route('admin.users.destroy', $user->id) }}"
                                                                method="POST" data-id="{{ $user->id }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger w-100 text-center"
                                                                    style="max-width: 100px;">Delete</button>
                                                            </form>
                                                            @endcan
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
    </div>
    <script>
        $(document).ready(function() {
            
            $(document).on('submit', '.deleteForm', function(e) {
                e.preventDefault();

                let form = $(this);
                let id = form.data('id');
                let url = form.attr('action');
                let token = $('meta[name="csrf-token"]').attr('content');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: token,
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                });

                                form.closest('tr').remove();
                            },
                            error: function(err) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Failed to delete the product.',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                                console.error(err.responseText);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
