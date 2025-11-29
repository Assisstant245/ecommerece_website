@extends('layout.user_app')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/product_list') }}">Products</a></li>
                <li class="breadcrumb-item active">Cart</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Cart Start -->
    <div class="cart-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-page-inner">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Product Image</th>
                                        <th>Product Name</th>

                                        <th>Sale Price</th>
                                        <th>Quantity</th>
                                        <th>total price</th>
                                        <th>Remove</th>

                                    </tr>
                                </thead>
                                <tbody class="align-middle" id="cart-items">
                                    <tr>
                                        <td colspan="5" class="text-center">Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart-page-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="coupon">
                                    <input type="text" placeholder="Coupon Code">
                                    <button>Apply Code</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="cart-summary">
                                    <div class="cart-content">
                                        <h1>Cart Summary</h1>
                                        <p>Sub Total<span id="subtotal">$0</span></p>
                                        <h2>Grand Total<span id="grandtotal">$0</span></h2>
                                    </div>
                                    <div class="cart-btn button">
                                        <button> <a href="{{ url('/checkout') }}">Checkout</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateQuantity(data) {
            var values = data.split('_');
            var incrementdecrement = values[0];
            var cartid = values[1];
            $.ajax({
                url: '/cart/update-quantity',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token for Laravel
                    incrementdecrement: incrementdecrement,
                    cart_id: cartid
                },
                success: function(response) {
                    console.log(response);
                    viewdata();
                },
                error: function(xhr) {
                    console.error("Error:", xhr.responseText);
                }
            });
        }

        function viewdata() {
            $.ajax({
                url: "{{ route('getuser.cart') }}",
                type: 'GET',
                success: function(data) {
                    let subtotal = 0;
                    let html = '';
                    if (data.length === 0) {
                        html = `<tr><td colspan="5" class="text-center">Cart is empty</td></tr>`;
                    } else {
                        data.forEach(function(item) {
                            subtotal += parseFloat(item.total_price);
                            console.log("Item total_price:", subtotal);

                            html += `
                        <tr>
                            <td><img src="/products/${item.cart_product_image}" alt="${item.cart_product_name}" style="width: 50px;"></td>
                            <td>${item.cart_product_name}</td>
                            <td>$${item.cart_product_sale_price}</td>
                              <td>
                                                <div class="qty">
    <button class="btn-minus" onclick="updateQuantity('d1_${item.id}')"><i class="fa fa-minus"></i></button>
    <input type="text" class="qty-input" value="${item.cart_quantity}" readonly>
    <button class="btn-plus" onclick="updateQuantity('i1_${item.id}')"><i class="fa fa-plus"></i></button>
</div>
                                            </td>
                        <td>$${item.total_price}</td>

                            
                            <td>
                            <button class="btn btn-danger delete-btn w-100 text-center" data-id="${item.id}" style="max-width: 100px;">
                            <i class="fas fa-trash-alt"></i>
                             </button> 
                            </td>

                        </tr>
                    `;

                        });
                    }


                    $('#cart-items').html(html);
                    $('#subtotal').text(`$${subtotal.toFixed(2)}`);
                    $('#grandtotal').text(`$${subtotal.toFixed(2)}`);



                },
                error: function(err) {
                    console.error("Error loading cart:", err.responseText);
                }
            });
        }
        viewdata();
        $(document).on('click', '.delete-btn', function() {

            const id = $(this).data('id');
            const target = this;
            Swal.fire({
                title: 'Are you sure?',
                text: "This item will be removed from your cart!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/cart/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                 toast: true,
                                position: 'top-end',
                                icon: 'success',
                                text: 'Item has been removed from your cart.',
                                timer: 1500,
                                showConfirmButton: false,

                            });
                            // $(target).closest('tr').fadeOut();
                            viewdata();
                            updateCartCount();
                        },
                        error: function(xhr) {
                            console.error("Delete failed:", xhr.responseText);
                            Swal.fire('Error!', 'Something went wrong!', 'error');
                        }
                    });
                }
            });
        });
    </script>
@endsection
