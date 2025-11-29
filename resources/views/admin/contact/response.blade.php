@extends('layout.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <section class="section w-100">
            <div class="section-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <form action="{{ route('admin.admin.contact.send') }}" id="responseForm" method="POST">
                                <div class="card-header">
                                    <h4>Send Response to {{ $contact->user_name }}</h4>
                                </div>
                                <div class="card-body">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $contact->id }}">
                                    <input type="hidden" name="email" value="{{ $contact->user_email }}">

                                    {{-- User Name --}}
                                    <div class="form-group">
                                        <label>User Name:</label>
                                        <input type="text" class="form-control" value="{{ $contact->user_name }}" readonly>
                                    </div>

                                    {{-- User Email --}}
                                    <div class="form-group">
                                        <label>User Email:</label>
                                        <input type="text" class="form-control" value="{{ $contact->user_email }}" readonly>
                                    </div>

                                    {{-- User Subject --}}
                                    <div class="form-group">
                                        <label>User Subject:</label>
                                        <input type="text" class="form-control" name='subject' value="{{ $contact->user_subject }}" readonly>
                                    </div>

                                    {{-- User Message --}}
                                    <div class="form-group">
                                        <label>User Message:</label>
                                        <textarea class="form-control" rows="5" name='message' readonly>{{ $contact->user_message }}</textarea>
                                    </div>

                                    {{-- Admin Response --}}
                                    <div class="form-group">
                                        <label>Your Response:</label>
                                        <textarea name="response" id="response" name='response' class="form-control" rows="5" required></textarea>
                                        <span class="text-danger" id="response_error"></span>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-success">Send Response</button>
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
            $('#responseForm').on('submit', function(e) {
                e.preventDefault();

                $('#response_error').text('');

                let formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
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

                        $('#responseForm')[0].reset();

                        setTimeout(function() {
                            window.location.href = "{{ route('admin.admin.getContactDetail') }}";
                        }, 3000);
                    },
                    error: function(err) {
                        if (err.status === 422) {
                            let errors = err.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                $('#' + field + '_error').text(messages[0]);
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
