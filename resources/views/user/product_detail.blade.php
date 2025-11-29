@extends('layout.user_app')
@section('content')

<div class="container">
    <div class="row">
        @foreach ($product as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    {{-- Show Image --}}
                    {{-- @php
                        $images = json_decode($product->product_image, true); // if saved as JSON
                        $firstImage = $images[0] ?? 'default.jpg';
                    @endphp
                    <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" alt="Product Image"> --}}

                    <div class="card-body">
                        {{-- Name --}}
                        <h5 class="card-title">{{ $product->product_name }}</h5>

                        {{-- Category/Subcategory --}}
                        <p class="card-text">
                            Category: {{ $product->category->category_name ?? '-' }}<br>
                            Subcategory: {{ $product->subcategory->sub_category_name ?? '-' }}
                        </p>

                        {{-- Price --}}
                        <p>
                            <strong>Sale:</strong> ${{ $product->product_sale_price }}<br>
                            <strong>Wholesale:</strong> ${{ $product->product_whole_price }}
                        </p>

                        {{-- SKU + Status --}}
                        <p>SKU: {{ $product->product_sku }}</p>
                        <p>Status: 
                            @if($product->product_status == 'online')
                                <span class="badge bg-success">Online</span>
                            @else
                                <span class="badge bg-danger">Offline</span>
                            @endif
                        </p>

                        {{-- Link to detail --}}
                        <a href="{{ route('user.product_detail', $product->id) }}" class="btn btn-primary">View Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
