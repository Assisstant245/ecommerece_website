<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\frontendsite\FrontendController;

use Illuminate\Support\Facades\Route;



// Frontend routes
Route::middleware(['web'])->group(function () {

    // without middleware routes

    Route::get('/', [FrontendController::class, 'home']);
    Route::get('/contact', [FrontendController::class, 'contact']);
    Route::post('/addcontact', [FrontendController::class, 'addcontact'])->name('user.contact');
    Route::get('/product_detail/{id}', [FrontendController::class, 'product_detail'])->name('user.product_detail');
    Route::get('/product_list', [FrontendController::class, 'product_list']);
    Route::get('/category_list/{id}', [FrontendController::class, 'category_list']);
    Route::get('/subcategory_list/{id}', [FrontendController::class, 'subcategory_list']);

    Route::middleware(['checkfrontenduser'])->group(function () {

        // cart routes

        Route::post('/cart', [FrontendController::class, 'addToCart'])->name('user.cart');
        Route::get('/cart',  [FrontendController::class, 'cartPage'])->name('user.cart.page');
        Route::get('/cart/count', [FrontendController::class, 'cartCount'])->name('cart.count');
        Route::post('/cart/update-quantity', [FrontendController::class, 'updateQuantity']);
        Route::delete('/cart/{id}', [FrontendController::class, 'destroy'])->name('user.destroy');
        Route::get('/getcart', [FrontendController::class, 'cart'])->name('getuser.cart');
        // Route::get('/cart/total', [FrontendController::class, 'getCartTotal'])->name('cart.total');

        // place order

        Route::post('/place-order', [FrontendController::class, 'orderstore'])->name('place.order');

        // checkout function

        Route::get('/checkout', [FrontendController::class, 'checkout']);

        // account routes

        Route::post('/update_account_details/{id}', [FrontendController::class, 'updateAccountDetail'])->name('account.updateAccountDetail');
        Route::post('/update_password_details/{id}', [FrontendController::class, 'updatePasswordDetail'])->name('account.updatePasswordDetail');
        Route::get('/my_account', [FrontendController::class, 'my_account']);

        // logout function
        
        Route::get('/logout', [FrontendController::class, 'logout'])->name('logout');

    });

    Route::get('/login', [FrontendController::class, 'login']);
    Route::get('/register', [FrontendController::class, 'register'])->name('user.getRegisterForm');
    Route::post('/registersubmit', [FrontendController::class, 'registersubmit'])->name('user.registersubmit');
    Route::post('/loginsubmit', [FrontendController::class, 'loginsubmit'])->name('user.loginsubmit');
});

