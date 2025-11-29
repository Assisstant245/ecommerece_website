@extends('layout.app')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Contact Messages</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contact as $index => $contactItem)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $contactItem->user_name }}</td>
                                                <td>{{ $contactItem->user_email }}</td>
                                                <td>{{ $contactItem->user_subject }}</td>
                                                <td>{{ $contactItem->user_message }}</td>
                                                <td>{{ $contactItem->created_at->format('d M Y, h:i A') }}</td>
                                                @can('respond contact button')
                                                <td>
                                                    <a href="{{ route('admin.admin.contact.response', $contactItem->id) }}"
                                                        class="btn btn-primary btn-sm">Respond</a>
                                                </td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Optional: Pagination --}}
                            {{-- {{ $contact->links() }} --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
