@extends('layout.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>View Orders</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile No</th>
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>State</th>
                                                <th>ZIP</th>
                                                <th>Country</th>
                                                <th>Total Price</th>


                                                <th>Order_status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $index => $order)
                                                <tr class="order-row">
                                                    <td> <a href="{{ url('/admin/invoice', $order->id) }}">
                                                            {{ $index + 1 }} </a></td>
                                                    <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                                    <td>{{ $order->order_email }}</td>
                                                    <td>{{ $order->mobile_no }}</td>
                                                    <td>{{ $order->address }}</td>
                                                    <td>{{ $order->city }}</td>
                                                    <td>{{ $order->state }}</td>
                                                    <td>{{ $order->zip_code }}</td>
                                                    <td>{{ $order->country }}</td>
                                                    <td>{{ $order->total_price }}</td>

                                                    {{-- @can('order status view ') --}}

                                                    <td>
                                                        @php
                                                            $status = $order->order_status;
                                                            $badgeClass = match ($status) {
                                                                'pending'
                                                                    => 'badge bg-warning text-dark', // Yellow for pending
                                                                'cancel' => 'badge bg-danger', // Red for cancel
                                                                'Deliver' => 'badge bg-success', // Green for delivered
                                                                default
                                                                    => 'badge bg-secondary', // Grey for anything else
                                                            };
                                                        @endphp
                                                        <span class="{{ $badgeClass }}">{{ ucfirst($status) }}</span>
                                                    </td>
                                                    {{-- @endcan --}}
                                                    <td>
                                                        <div class="d-flex align-items-center gap-3">

                                                            {{-- View Button --}}

                                                            <div style="margin-right: 10px;">
                                                                @can('order button view')
                                                                    <button class="btn btn-sm btn-primary view-order-btn"
                                                                        data-products='@json(json_decode($order->product_items))'
                                                                        data-total="{{ $order->total_price }}">
                                                                        View
                                                                    </button>
                                                                @endcan
                                                            </div>

                                                            {{-- Edit Button --}}
                                                            @can('order edit')
                                                                <div style="margin-right: 10px;">
                                                                    <a href="{{ route('admin.admin.getAddAdminToCart', $order->id) }}"
                                                                        class="btn btn-success btn-sm text-center">
                                                                        Edit
                                                                    </a>
                                                                </div>
                                                            @endcan

                                                            {{-- Delete Button --}}
                                                            @can('order delete')
                                                                <div style="margin-right: 10px;">
                                                                    <form class="deleteForm d-inline"
                                                                        data-id="{{ $order->id }}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm deleteBtn">Delete</button>
                                                                    </form>
                                                                </div>
                                                            @endcan

                                                            {{-- Status Dropdown --}}
                                                            <div style="margin-right: 10px;">
                                                                @can('order status create')
                                                                    <select
                                                                        class="form-control form-control-sm status-dropdown w-auto"
                                                                        onchange="updateOrderStatus(this.value)">
                                                                        <option selected disabled>Select Status</option>
                                                                        <option value="pending_{{ $order->id }}">Pending
                                                                        </option>
                                                                        <option value="cancel_{{ $order->id }}">Cancel
                                                                        </option>
                                                                        <option value="Deliver_{{ $order->id }}">Deliver
                                                                        </option>
                                                                    </select>
                                                                @endcan
                                                            </div>

                                                        </div>
                                                    </td>







                                                    {{-- <td>${{ $order->order_subtotal }}</td> --}}


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
        <!-- Modal -->
        <div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog"
            aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Image</th>

                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Sub Total</th>

                                </tr>
                            </thead>
                            <tbody id="orderProductsBody"></tbody>
                        </table>
                        <p><strong>Total Price:</strong> $<span id="orderTotalPrice"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Reuse delete script --}}
    <script>
        function updateOrderStatus(concatenatedValue) {
            const values = concatenatedValue.split("_");
            const status = values[0];
            const orderId = values[1];
            $.ajax({
                url: `/admin/order/status/${orderId}/${status}`,
                type: 'GET',
                success: function(response) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Order status updated!',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });

                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Failed to update status!',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });

                    console.error(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {

            $(document).on('click', '.view-order-btn', function() {
                let products = $(this).data('products');

                if (typeof products === 'string') {
                    try {
                        products = JSON.parse(products);
                    } catch (e) {
                        console.error("Failed to parse products JSON", e);
                        return;
                    }
                }

                if (!Array.isArray(products)) {
                    console.error("products is not an array after parsing:", products);
                    return;
                }

                const total = $(this).data('total');

                let html = '';
                products.forEach(item => {
                    html += `<tr>
            <td><img src="/products/${item.product_images}" width="50" height="50"></td>
            <td>${item.product_name}</td>
            <td>${item.product_quantity}</td>
            <td>${item.product_total_price}</td>
        </tr>`;
                });

                $('#orderProductsBody').html(html);
                $('#orderTotalPrice').text(parseFloat(total).toFixed(2));

                $('#orderDetailsModal').modal('show');
            });



            $(document).on('click', '.deleteBtn', function() {
                let form = $(this).closest('.deleteForm');
                let orderId = form.data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You will not be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/admin/order/delete/${orderId}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
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
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete the order.',
                                    'error'
                                );
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
