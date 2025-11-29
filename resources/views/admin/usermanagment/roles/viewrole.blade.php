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
                                <h4>View roles</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    
                                    <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>role Name</th>
                                                <th>Permissions</th>

                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($roles as $role)
                                                <tr>
                                                    <td>{{ $role->id }}</td>
                                                    <td>{{ $role->name }}</td>
                                                    <td>
                                                        @if ($role->permissions->isNotEmpty())
                                                            @foreach ($role->permissions as $permission)
                                                                 <span>{{ $permission->name }}@if (!$loop->last)
                                                                        ,
                                                                    @endif
                                                                </span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">No Permissions</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            @can('role edit')
                                                                <a href="{{ route('admin.roles.show', $role->id) }}"
                                                                    class="btn btn-success w-100 text-center m-2"
                                                                    style="max-width: 100px;">Edit</a>
                                                            @endcan
                                                            @can('role delete')
                                                                <form class="deleteForm"
                                                                    action="{{ route('admin.roles.destroy', $role->id) }}"
                                                                    method="POST" data-id="{{ $role->id }}">
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
