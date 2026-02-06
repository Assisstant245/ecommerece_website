<?php

namespace App\Http\Controllers\frontendsite;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;


use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;

use App\Models\Cart;

use Illuminate\Support\Facades\Hash;


use Illuminate\Http\Request;

class FrontendController extends Controller

{
    // home function

    public function home()
    {
        $categories = Category::all();

        return view('user.index', compact('categories'));
    }

    // Contact function

    public function contact()
    {
        return view('user.contact');
    }

    // Add contact

    public function addcontact(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email',
            'user_subject' => 'nullable|string|max:255',
            'user_message' => 'required|string',
        ]);

        Contact::create([
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_subject' => $request->user_subject,
            'user_message' => $request->user_message,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    // Product list function

    public function product_list()
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $products = Product::where('product_status', 'online')->paginate(12);
        return view('user.product_list', compact('products', 'categories', 'subcategories'));
    }

    // Add to cart function

    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Please login first'], 401);
            
            
        }

        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $sku = $product->product_sku ?? 'SKU-' . $product->id;

        $existingCartItem = Cart::where('cart_product_sku', $sku)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingCartItem) {
            return response()->json(['message' => 'This product is already in your cart'], 409);
        }

        Cart::create([
            'cart_product_name' => $product->product_name,
            'cart_product_sku' => $sku,
            'cart_product_image' => is_array(json_decode($product->product_image, true))
                ? json_decode($product->product_image, true)[0]
                : $product->product_image,
            'cart_product_sale_price' => $product->product_price ?? 0,
            'cart_quantity' => 1,
            'total_price' => $product->product_price ?? 0,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Product added to cart successfully']);
    }

    // get cart items 

    public function cart()

    {
        $userId = Auth::id();

        $cartItems = Cart::where('user_id', $userId)->get();
        // return view('user.cart', compact('cartItems'));
        return response()->json($cartItems);
    }

    // get cart page

    public function cartPage()
    {
        return view('user.cart'); // Show blade view
    }

    // cart items count

    public function cartCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Cart::where('user_id',  Auth::id())->count();

        return response()->json(['count' => $count]);
    }

    // updatequantity function

    public function updateQuantity(Request $request)
    {
        $incrementdecrement = $request->input('incrementdecrement');
        $cartId = $request->input('cart_id');

        $cartItem = Cart::findOrFail($cartId);

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

//    view checkhout page

    public function checkout()
    {
        $userId = Auth::id();

        $cartItems = Cart::where('user_id', $userId)->get();
        // return view('user.cart', compact('cartItems'));
        // return response()->json($cartItems);
        return view('user.checkout', compact('cartItems'));
    }

    // order store

    public function orderstore(Request $request)
    {
        // print_r($request->all());
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

            // Validate arrays
            'cart_product_name' => 'required|array',
            'cart_quantity' => 'required|array',
            'total_price' => 'required|array',
            'product_image' => 'required|array',

        ]);
        
        $product_name_array = $request->cart_product_name;
        $product_quantity_array = $request->cart_quantity;
        $product_total_price_array = $request->total_price;
        $product_sale_price_array = $request->cart_product_sale_price;
        $product_cart_sku_array = $request->cart_product_sku;

        $product_image_array = $request->product_image;

        $userId = Auth::id();
        $data = [];

        foreach ($product_name_array as $key => $val) {


            $productImages = $product_image_array[$key] ?? '';


            $data[] = [
                'product_name' => $val,
                'product_quantity' => $product_quantity_array[$key],
                'product_total_price' => $product_total_price_array[$key],
                'product_sale_price' => $product_sale_price_array[$key],
                'product_cart_sku' => $product_cart_sku_array[$key],

                'product_images' => $productImages,
            ];
        }
        $totalPrice = array_sum($product_total_price_array);


        Order::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'order_email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
            'country' => $request->country,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zipcode,
            'product_items' => json_encode($data), // save as JSON
            'user_id' => Auth::id(),
            'order_status' => 'pending',
            'total_price' => $totalPrice,
            'order_product_image' => 'null',




        ]);


        Cart::where('user_id', $userId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully and cart cleared.',
        ]);
    }
      // category list show


    public function category_list($id)
    {
        $category = Category::all();
        $subcategories = SubCategory::where('category_id', $id)->get();
        $products = Product::where('category_id', $id)->get();

        return view('user.category_list', compact('subcategories', 'products', 'category'));
    }
    // subcategory list
    public function subcategory_list($id)
    {
        $category = Category::all();
        $clickedSubcategory = SubCategory::find($id); // $id is subcategory id

        $subcategories = SubCategory::where('category_id', $clickedSubcategory->category_id)->get();
        $products = Product::where('subcategory_id', $id)->get();

        return view('user.category_list', compact('subcategories', 'products', 'category'));
    }

    public function product_detail($id)
    {

        $product = Product::findOrFail($id); // fetch product by id
        return view('user.product_detail', compact('product'));
    }


    public function loginsubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->name === 'webuser') {
                $request->session()->regenerate();
                $request->session()->put('user_id', $user->id);
                $request->session()->put('user_email', $user->email);
                $request->session()->put('user_name', $user->name);

                return response()->json([
                    'status' => true,
                    'message' => 'Login successful',
                    
                ]);
            }

            Auth::logout();
            return response()->json([
                'status' => false,
                'message' => 'Access denied for this user role.'
            ], 403);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }




    public function login()
    {

        return view('user.login');
    }
    public function register()
    {

        return view('user.register');
    }
    public function registersubmit(Request $request)
    {

        $request->validate([

            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'mobile_no' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed', // Will check against 'password_confirmation'
        ]);

        $user = User::create([
            'name' => 'webuser',
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'password' => Hash::make($request->password),
        ]);
        Auth::login($user);
    }
    public function my_account()
    {
        $userId = Auth::id();

        $orders = Order::where('user_id', $userId)
            ->latest()
            ->get();


        return view('user.my_account', compact('orders'));
    }
    public function updateAccountDetail(Request $request, $id)
    {

        $userId = Auth::id();

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',

            'email' => 'required|email|unique:users,email,' . $id,
            'mobile_no' => 'nullable|string|max:20',
        ]);

        $user = User::findOrFail($id);

        if ($user->id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,

            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Account updated successfully!',
        ]);
    }
    public function updatePasswordDetail(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'The current password is incorrect.',
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully');
    }
    public function destroy($id)
    {

        $cart = Cart::findorFail($id);
        $cart->delete();
        return response()->json(['message' => 'cart product deleted successfully.']);
    }
}
