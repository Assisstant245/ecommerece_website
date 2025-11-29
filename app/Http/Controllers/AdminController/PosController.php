<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;

use App\Models\AdminCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PosController extends Controller
{
   public static function middleware(): array
   {
      return [
         new Middleware('auth'),

         new Middleware('permission:pos view', only: ['pos_view_admin_cart']),
         new Middleware('permission:pos edit', only: ['getAddAdminToCart']),

         // new Middleware('permission:order button view', only: ['updateOrderStatus']),
         // new Middleware('permission:order status create', only: ['updateOrderStatus']),
         // new Middleware('permission:order status view', only: ['updateOrderStatus']),
         // new Middleware('permission:order edit', only: ['edit', 'update']),
         new Middleware('permission:pos delete', only: ['destroy']),
      ];
   }

   // pos update quantity

   public function pos_update_quantity(Request $request)
   {
      $incrementdecrement = $request->input('incrementdecrement');
      $cartId = $request->input('cart_id');

      $cartItem = AdminCart::findOrFail($cartId);

      if ($incrementdecrement === 'i1') {
         $cartItem->cart_quantity += 1;
      } elseif ($incrementdecrement === 'd1' && $cartItem->cart_quantity > 1) {
         $cartItem->cart_quantity -= 1;
      }

      $cartItem->total_price = $cartItem->cart_product_sale_price * $cartItem->cart_quantity;
      $cartItem->save();

      return response()->json([
         'new_quantity' => $cartItem->cart_quantity,
         'new_total' => number_format($cartItem->total_price, 2)
      ]);
   }

   // get pos page

   public function pos_view_admin_cart()
   {

      $products = Product::all();

      return view('admin.POS.pos', compact('products'));
   }


//  update edit pos

   public function pos_edit_admin_cart(Request $request, $id)
{
    $request->validate([
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'email' => 'required|email',
        'mobile_no' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'country' => 'required|string',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'zipcode' => 'required|string|max:20',
    ]);

    $userId = Auth::id();

    try {
        $cartItems = AdminCart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart is empty. Cannot place order.',
            ], 400);
        }

        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found.',
            ], 404);
        }

        $productItems = $cartItems->map(function ($item) {
            return [
                'product_name' => $item->cart_product_name,
                'product_quantity' => $item->cart_quantity,
                'product_total_price' => $item->total_price,
                'product_sale_price' => $item->cart_product_sale_price,
                'product_cart_sku' => $item->cart_product_sku,
                'product_images' => $item->cart_product_image,
            ];
        })->toArray();

        $totalPrice = $cartItems->sum('total_price');

        $updated = $order->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'order_email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
            'country' => $request->country,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zipcode,
            'user_id' => $userId,
            'order_status' => 'confirm',
            'product_items' => json_encode($productItems),
            'total_price' => $totalPrice,
            'order_product_image' => $productItems[0]['product_images'] ?? 'default.jpg',
        ]);

        if ($updated) {
            AdminCart::where('user_id', Auth::id())->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Order updated and cart cleared.',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update order.',
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Unexpected error occurred.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


   public function addToCart(Request $request)
   {
      $userId = Auth::id();

      $request->validate([
         'product_id' => 'required|exists:products,id',
         'quantity' => 'required|integer|min:1'
      ]);

      $product = Product::find($request->product_id);
      $sku = $product->product_sku ?? 'SKU-' . $product->id;
      $existingCartItem = AdminCart::where('cart_product_sku', $sku)
         ->where('user_id', $userId)
         ->first();

      if ($existingCartItem) {
         return response()->json(['message' => 'This product is already in your cart'], 409);
      }
      AdminCart::create([
         'user_id' => $userId,
         'product_id' => $product->id,
         'cart_product_name' => $product->product_name,
         'cart_product_sku' => $sku,
         'cart_product_image' => is_array(json_decode($product->product_image, true))
            ? json_decode($product->product_image, true)[0]
            : $product->product_image,
         'cart_product_sale_price' => $product->product_price,
         'cart_quantity' => $request->quantity,
         'total_price' => $product->product_price * $request->quantity,

      ]);

      return response()->json([
         'message' => 'Product added to cart successfully'
      ]);
   }

   public function getAddToCart()
   {
      $userId = Auth::id();

      $cartItems = AdminCart::where('user_id', $userId)->get();
      // return view('user.cart', compact('cartItems'));
      return response()->json($cartItems);
   }
   
   


   public function getAddAdminToCart($id)
   {

      $order = Order::findOrFail($id);
      $productItems = json_decode($order->product_items, true); // Assumes it's an array of items
      $products = Product::all();
      $userId = Auth::id();

      // Optional: Clear existing cart for this user (to avoid duplicates)
      AdminCart::where('user_id', $userId)->delete();

      // Insert each productItem into admin_cart
      foreach ($productItems as $item) {
         AdminCart::create([
            'user_id' => $userId,
            // 'product_id' => $item['product_id'],
            'cart_product_name' => $item['product_name'],
            'cart_product_sku' => $item['product_cart_sku'],

            'cart_product_image' => is_array(json_decode($item['product_images'], true))
               ? json_decode($item['product_images'], true)[0]
               : $item['product_images'],
            'cart_quantity' => $item['product_quantity'],
            'cart_product_sale_price' => $item['product_total_price'], // Optional if needed
            'total_price' => $item['product_quantity'] * $item['product_total_price'], // Optional if needed
         ]);
      }

      return view('admin.POS.edit', compact('productItems', 'order', 'products'));
   }






   public function destroy($id)
   {

      $cart = AdminCart::findorFail($id);
      $cart->delete();
      return response()->json(['message' => 'cart product deleted successfully.']);
   }
   public function addBill(Request $request)
   {
      $request->validate([
         'first_name' => 'required|string|max:100',
         'last_name' => 'required|string|max:100',
         'email' => 'required|email',
         'mobile_no' => 'required|string|max:20',
         'address' => 'required|string|max:255',
         'country' => 'required|string',
         'city' => 'required|string|max:100',
         'state' => 'required|string|max:100',
         'zipcode' => 'required|string|max:20',
      ]);

      $userId = Auth::id();

      try {
         $cartItems = AdminCart::where('user_id', $userId)->get();

         if ($cartItems->isEmpty()) {
            return response()->json([
               'status' => 'error',
               'message' => 'Cart is empty. Cannot place order.',
            ], 400);
         }

         $productItems = $cartItems->map(function ($item) {
            return [
               'product_name' => $item->cart_product_name,
               'product_quantity' => $item->cart_quantity,
               'product_total_price' => $item->total_price,
               'product_sale_price' => $item->cart_product_sale_price,
               'product_cart_sku' => $item->cart_product_sku,
               'product_images' => $item->cart_product_image,
            ];
         })->toArray();

         $totalPrice = $cartItems->sum('total_price');

         $order = Order::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'order_email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
            'country' => $request->country,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zipcode,
            'user_id' => $userId,
            'order_status' => 'confirm',
            'product_items' => json_encode($productItems),
            'total_price' => $totalPrice,
            'order_product_image' => $productItems[0]['product_images'] ?? 'default.jpg',
         ]);

         if ($order) {
            AdminCart::where('user_id', $userId)->delete();

            return response()->json([
               'status' => 'success',
               'message' => 'Order placed and cart cleared.',
            ]);
         } else {
            return response()->json([
               'status' => 'error',
               'message' => 'Failed to create order.',
            ]);
         }
      } catch (\Exception $e) {
         return response()->json([
            'status' => 'error',
            'message' => 'Unexpected error occurred.',
            'error' => $e->getMessage(),
         ], 500);
      }
   }
}
