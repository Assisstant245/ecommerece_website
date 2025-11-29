<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order Status</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }

        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <h2>Order Status: {{ $status }}</h2>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productItems as $item)
                <tr>
                    <td>{{ $item['product_name'] }}</td>
                    <td>
                        @if(!empty($item['product_images']))
                            <img src="{{ $message->embed(public_path('products/' . $item['product_images'])) }}" alt="Product Image">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>{{ $item['product_quantity'] }}</td>
                    <td>Rs. {{ number_format($item['product_total_price'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}</p>
    <p>Thank you for shopping with us!</p>
</body>

</html>
