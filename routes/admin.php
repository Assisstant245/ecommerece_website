<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController\LoginController;
use App\Http\Controllers\AdminController\LogoutController;
use App\Http\Controllers\AdminController\InventoryController;
use App\Http\Controllers\AdminController\CategoryController;
use App\Http\Controllers\AdminController\ProductController;
use App\Http\Controllers\AdminController\SubCategoryController;
use App\Http\Controllers\AdminController\OrderController;
use App\Http\Controllers\AdminController\PosController;
use App\Http\Controllers\PermissionRole\PermissionController;
use App\Http\Controllers\PermissionRole\UserController;
use App\Http\Controllers\AdminController\ContactController;

use App\Http\Controllers\PermissionRole\RoleController;





Route::middleware(['web'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {

        // Login and logout
        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'showLoginForm'])->name('login.submit');


        Route::middleware(['checkLogin'])->group(function () {

            // dashboard route

            Route::get('/dashboard', [InventoryController::class, 'index'])->name('dashboard');

            // category controller

            Route::resource('/categories', CategoryController::class);

            // product controller

            Route::resource('product', ProductController::class);
            Route::get('/product/subcategories/{category_id}', [ProductController::class, 'getSubcategories'])->name('product.getSubcategories');

            // subcategory controller

            Route::resource('subcategory', SubCategoryController::class);

            // permission controller

            Route::resource('permission', PermissionController::class);

            // roles controller

            Route::resource('roles', RoleController::class);

            // users controller

            Route::resource('users', UserController::class);

            // order routes

            // get orders page

            Route::get('/order', [OrderController::class, 'index'])->name('getorders');

            // order status update

            Route::get('/order/status/{order_id}/{status}', [OrderController::class, 'updateOrderStatus'])
                ->name('order.status.update');

            // order delete

            Route::delete('/admin/order/delete/{id}', [OrderController::class, 'destroy'])->name('admin.order.delete');

            // end order routes
            // Pos routes
            // get pos page

            Route::get('/pos_view_admin_cart', [PosController::class, 'pos_view_admin_cart'])->name('pos_view_admin_cart');

            // add to cart product

            Route::post('/pos_add_admin_cart', [PosController::class, 'addToCart'])->name('admin.pos_add_admin_cart');

            // get add to cart

             Route::get('/pos_get_admin_cart', [PosController::class, 'getAddToCart'])->name('admin.getAddToCart');

            // pos update quantity

            Route::post('/pos/update-quantity', [PosController::class, 'pos_update_quantity'])->name('admin.pos_update_quantity');

            // create pos order
            Route::post('/pos_add_admin_bill', [PosController::class, 'addBill'])->name('admin.pos_add_admin_bill');

            // pos edit page
            Route::get('/pos_get_addadmin_cart/{id}', [PosController::class, 'getAddAdminToCart'])->name('admin.getAddAdminToCart');

            // pos update and create order

             Route::post('/pos_edit_admin_cart/{id}', [PosController::class, 'pos_edit_admin_cart'])->name('pos_edit_admin_cart');

            //  pos delete
            
            Route::delete('/admincart/{id}', [PosController::class, 'destroy'])->name('admincart.destroy');



            // invoice route

            Route::get('/invoice/{id}', [InventoryController::class, 'invoice'])->name('invoice');
            Route::get('/getContactDetail', [InventoryController::class, 'getContactDetail'])->name('admin.getContactDetail');

            

            Route::get('/admin/contact/response/{id}', [ContactController::class, 'showResponseForm'])->name('admin.contact.response');
            Route::post('/admin/contact/response/send', [ContactController::class, 'sendResponse'])->name('admin.contact.send');


            Route::get('/logout', [LogoutController::class, 'index'])->name('logout');



           

        });
    });
});
