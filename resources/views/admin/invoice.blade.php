@extends('layout.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="invoice">
                    <div class="invoice-print">
                        <div class="row">
                            <div class="col-lg-12" id="invoiceArea">
                                @foreach ($invoice as $order)
                                    <div class="invoice-title">
                                        <h2>Invoice</h2>
                                        <div class="invoice-number">Order #{{ $order->id }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <address>
                                                <strong>Shipped To:</strong><br>
                                                {{ $order->first_name }} {{ $order->last_name }}<br>
                                                {{ $order->address }}<br>
                                                {{ $order->city }}, {{ $order->state }}<br>
                                                {{ $order->zip_code }}, {{ $order->country }}
                                            </address>
                                        </div>
                                        <div class="col-md-6 text-md-right">
                                            <address>
                                                <strong>Order Date:</strong><br>
                                                {{ $order->created_at->format('F d, Y') }}
                                            </address>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div class="section-title">Order Summary</div>
                                            <p class="section-lead">All items here cannot be deleted.</p>
                                            @php
                                                $items = json_decode($order->product_items, true);
                                            @endphp

                                            @if (is_array($items))
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover table-md">
                                                        <thead>
                                                            <tr>
                                                                <th data-width="40">#</th>
                                                                <th>Image</th>
                                                                <th>Item</th>
                                                                <th class="text-center">Quantity</th>
                                                                <th class="text-right">Totals</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($items as $index => $item)
                                                                @if (is_array($item))
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>
                                                                            @if (!empty($item['product_images']))
                                                                                <img src="{{ asset('products/' . $item['product_images']) }}"
                                                                                    alt="Product Image" width="50">
                                                                            @else
                                                                                <span class="text-muted">No Image</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $item['product_name'] ?? 'N/A' }}</td>
                                                                        <td class="text-center">
                                                                            {{ $item['product_quantity'] ?? 0 }}</td>
                                                                        <td class="text-right">
                                                                            ${{ number_format($item['product_total_price'] ?? 0, 2) }}
                                                                        </td>
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <td colspan="5" class="text-danger">Invalid
                                                                            product item format</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                </div>
                                            @else
                                                <p class="text-danger">Invalid product item data.</p>
                                            @endif

                                            <div class="text-right mt-3">
                                                <strong>Total Amount:</strong> ${{ number_format($order->total_price, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>

                            

                        </div>
                        <div class="d-flex justify-content-between flex-wrap">
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-icon icon-left">
                                        <i class="fas fa-credit-card"></i> Process Payment
                                    </button>
                                    <button class="btn btn-danger btn-icon icon-left">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                </div>
                                <div class="mb-3 text-right">
                                    <button class="btn btn-warning btn-icon icon-left" onclick="printInvoice()">
                                        <i class="fas fa-print"></i> Print
                                    </button>
                                </div>
                            </div>

                    </div>
        </section>
        <script>
            function printInvoice() {
                var printContents = document.getElementById('invoiceArea').innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
                location.reload();
            }
        </script>
    @endsection
