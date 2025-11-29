@extends('layout.user_app')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/product_list') }}">Products</a></li>
                <li class="breadcrumb-item active">Product List</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product List Start -->
    <div class="product-view">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="product-view-top">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="product-search">
                                            <input type="email" value="Search">
                                            <button><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="product-short">
                                            <div class="dropdown">
                                                <div class="dropdown-toggle" data-toggle="dropdown">Product short by</div>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item">Newest</a>
                                                    <a href="#" class="dropdown-item">Popular</a>
                                                    <a href="#" class="dropdown-item">Most sale</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="product-price-range">
                                            <div class="dropdown">
                                                <div class="dropdown-toggle" data-toggle="dropdown">Product price range
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="#" class="dropdown-item">$0 to $50</a>
                                                    <a href="#" class="dropdown-item">$51 to $100</a>
                                                    <a href="#" class="dropdown-item">$101 to $150</a>
                                                    <a href="#" class="dropdown-item">$151 to $200</a>
                                                    <a href="#" class="dropdown-item">$201 to $250</a>
                                                    <a href="#" class="dropdown-item">$251 to $300</a>
                                                    <a href="#" class="dropdown-item">$301 to $350</a>
                                                    <a href="#" class="dropdown-item">$351 to $400</a>
                                                    <a href="#" class="dropdown-item">$401 to $450</a>
                                                    <a href="#" class="dropdown-item">$451 to $500</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach ($products as $product)
                            <div class="col-md-4 mb-8">
                                <div class="product-item">
                                    <div class="product-title">
                                        <a
                                            href="{{ route('user.product_detail', $product->id) }}">{{ $product->product_name }}</a>
                                        <div class="ratting">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i class="fa fa-star{{ $i < ($product->rating ?? 4) ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="product-image">
                                        <a href="{{ url('/product_detail' . $product->id) }}">
                                            @php
                                                $images = json_decode($product->product_image, true);
                                                $firstImage = is_array($images) && count($images) ? $images[0] : null;
                                            @endphp
                                            @if ($firstImage)
                                                <img src="{{ asset('products/' . $firstImage) }}" alt="Product Image"
                                                    height="200">
                                            @else
                                                <img src="" alt="No Image" height="200">
                                            @endif
                                        </a>
                                        <div class="product-action">
                                            <a href="#"><i class="fa fa-cart-plus"></i></a>
                                            <a href="#"><i class="fa fa-heart"></i></a>
                                            <a href="#"><i class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="product-price d-flex justify-content-between align-items-center">
                                        <h5 class="text-white mb-0"><span>$</span>{{ $product->product_price }}</h5>

                                        <button type="button" class="btn btn-primary add-to-cart"
                                            data-id="{{ $product->id }}" style="padding: 4px 10px; font-size: 12px;">
                                            <i class="fa fa-shopping-cart"></i> Add to Cart
                                        </button>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>

                    <!-- Pagination Start -->
                    <div class="col-md-12 mb-8">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">

                                {{-- Previous Button --}}
                                @if ($products->onFirstPage())
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}">Previous</a>
                                    </li>
                                @endif

                                {{-- Page Numbers --}}
                                @for ($i = 1; $i <= $products->lastPage(); $i++)
                                    <li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                {{-- Next Button --}}
                                @if ($products->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                @endif

                            </ul>
                        </nav>
                    </div>


                    <!-- Pagination Start -->
                </div>


                <!-- Side Bar Start -->
                <div class="col-lg-4 sidebar">
                    <div class="sidebar-widget category">
                        <h2 class="title">Categories</h2>
                        <nav class="navbar bg-light">
                            <ul class="navbar-nav">
                                @foreach ($categories as $category)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('category_list/' . $category->id) }}">
                                            <i class="fa fa-tags"></i> {{ $category->category_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>


                    <div class="sidebar-widget category">
                        <h2 class="title">Subcategories</h2>
                        <nav class="navbar bg-light">
                            <ul class="navbar-nav">
                                @foreach ($subcategories as $subcategory)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('subcategory_list/' . $subcategory->id) }}">
                                            <i class="fa fa-angle-right"></i> {{ $subcategory->sub_category_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>


                    <div class="sidebar-widget widget-slider">
                        <div class="sidebar-slider normal-slider">
                            @foreach ($products as $product)
                                <div class="col-md-4">
                                    <div class="product-item">
                                        <div class="product-title">
                                            <a
                                                href="{{ url('/product_detail' . $product->id) }}">{{ $product->product_name }}</a>
                                            <div class="ratting">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i
                                                        class="fa fa-star{{ $i < ($product->rating ?? 4) ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="product-image">
                                            <a href="{{ url('/product_detail' . $product->id) }}">
                                                @php
                                                    $images = json_decode($product->product_image, true);
                                                    $firstImage =
                                                        is_array($images) && count($images) ? $images[0] : null;
                                                @endphp
                                                @if ($firstImage)
                                                    <img src="{{ asset('products/' . $firstImage) }}" alt="Product Image"
                                                        height="200">
                                                @else
                                                    <img src="" alt="No Image" height="200">
                                                @endif
                                            </a>
                                            <div class="product-action">
                                                <a href="#"><i class="fa fa-cart-plus"></i></a>
                                                <a href="#"><i class="fa fa-heart"></i></a>
                                                <a href="#"><i class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-price">
                                            <h3><span>$</span>{{ $product->product_price }}</h3>
                                             <button type="button" class="btn btn-primary add-to-cart"
                                            data-id="{{ $product->id }}" style="padding: 4px 10px; font-size: 12px;">
                                            <i class="fa fa-shopping-cart"></i> Add to Cart
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach



                        </div>
                    </div>

                    <div class="sidebar-widget brands">
                        <h2 class="title">Our Brands</h2>
                        <ul>
                            <li><a href="#">Nulla </a><span>(45)</span></li>
                            <li><a href="#">Curabitur </a><span>(34)</span></li>
                            <li><a href="#">Nunc </a><span>(67)</span></li>
                            <li><a href="#">Ullamcorper</a><span>(74)</span></li>
                            <li><a href="#">Fusce </a><span>(89)</span></li>
                            <li><a href="#">Sagittis</a><span>(28)</span></li>
                        </ul>
                    </div>

                    <div class="sidebar-widget tag">
                        <h2 class="title">Tags Cloud</h2>
                        <a href="#">Lorem ipsum</a>
                        <a href="#">Vivamus</a>
                        <a href="#">Phasellus</a>
                        <a href="#">pulvinar</a>
                        <a href="#">Curabitur</a>
                        <a href="#">Fusce</a>
                        <a href="#">Sem quis</a>
                        <a href="#">Mollis metus</a>
                        <a href="#">Sit amet</a>
                        <a href="#">Vel posuere</a>
                        <a href="#">orci luctus</a>
                        <a href="#">Nam lorem</a>
                    </div>
                </div>
                <!-- Side Bar End -->
            </div>
        </div>
    </div>
    <!-- Product List End -->

    <div class="brand">
        <div class="container-fluid">
            <div class="brand-slider">
                <div class="brand-item"><img src="{{ asset('user_assets/img/brand-1.png') }}" alt=""></div>
                <div class="brand-item"><img src="{{ asset('user_assets/img/brand-2.png') }}" alt=""></div>
                <div class="brand-item"><img src="{{ asset('user_assets/img/brand-3.png') }}" alt=""></div>
                <div class="brand-item"><img src="{{ asset('user_assets/img/brand-4.png') }}" alt=""></div>
                <div class="brand-item"><img src="{{ asset('user_assets/img/brand-5.png') }}" alt=""></div>
                <div class="brand-item"><img src="{{ asset('user_assets/img/brand-6.png') }}" alt=""></div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.add-to-cart').on('click', function(e) {
                e.preventDefault();
                let button = $(this);

                let productId = $(this).data('id');

                $.ajax({
                    url: '{{ route('user.cart') }}',
                    type: 'POST',
                    data: {
                        product_id: productId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {

                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            toast: true,
                            position: 'top-end',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        button.removeClass('btn-secondary')
                            .addClass('btn-success')
                            .html('<i class="fa fa-check"></i> Added')
                            .prop('disabled', true);


                        updateCartCount();

                    },
                    error: function(xhr) {
                        let message = "Unexpected error occurred";

                        if (xhr.status === 401) {
                            message = "Please login first to add products to your cart.";
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: message,
                            toast: true,
                            position: 'top-end',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }

                });
            });
        });
    </script>
@endsection
