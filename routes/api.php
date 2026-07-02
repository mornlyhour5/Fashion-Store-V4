<?php

use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductImageController;
use App\Http\Controllers\Product\ProductVariantController;
use App\Http\Controllers\Wishlist\WishlistController;
use App\Http\Controllers\Wishlist\WishlistItemController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Order\OrderItemController;
use App\Http\Controllers\Order\OrderStatusHistoryController;
use App\Http\Controllers\Product\BrandController;
use App\Http\Controllers\ProductsController;
// use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;

//----------------------------------------------------------
//                    Public Routes
//----------------------------------------------------------
Route::post('/login',    [LoginController::class,   'login']);
Route::post('/register', [RegisterController::class, 'register']);


    // Route::get('/addresses', [AddressController::class, 'show']);
//----------------------------------------------------------
//                    Protected Routes
//----------------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [LoginController::class, 'logout']);

    // ✅ Me route — get current logged in customer
    Route::get('/me', [CustomerController::class, 'me']);

    // ✅ Customer routes — protected
    Route::get('/customers',        [CustomerController::class, 'index']);
    Route::post('/customers',       [CustomerController::class, 'store']);
    Route::get('/customers/{id}',   [CustomerController::class, 'show']);
    Route::put('/customers/{id}',   [CustomerController::class, 'update']);
    Route::delete('/customers/{id}',[CustomerController::class, 'delete']);

    // ✅ Address routes — protected
    Route::get('/addresses',         [AddressController::class, 'index']);   // get all
    Route::get('/addresses/{id}',    [AddressController::class, 'show']);    // get one
    Route::post('/addresses',        [AddressController::class, 'store']);   // create
    Route::put('/addresses/{id}',    [AddressController::class, 'update']);  // update
    Route::delete('/addresses/{id}', [AddressController::class, 'delete']);

    // Route::get('/getAddressBySession', [AddressController::class, 'getAddressBySession']);
    // Orders
    Route::post('/Mainorders', [ProductsController::class, 'store']);

});

// Route::post('/Mainorders', [ProductsController::class, 'store']);


Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('/reset-password', [ResetPasswordController::class, 'reset']);


//----------------------------------------------------------------------------------
//                              Block Route in folder products
//----------------------------------------------------------------------------------
Route::get('/category', [CategoryController::class, 'index']);
Route::post('/category', [CategoryController::class, 'store']);
Route::get('/category/{id}', [CategoryController::class, 'show']);
Route::put('/category/{id}', [CategoryController::class, 'update']);
Route::delete('/category/{id}', [CategoryController::class, 'delete']);


Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'delete']);


Route::get('/Product-image', [ProductImageController::class, 'index']);
Route::post('/Product-image', [ProductImageController::class, 'store']);
Route::get('/Product-image/{id}', [ProductImageController::class, 'show']);
Route::put('/Product-image/{id}', [ProductImageController::class, 'update']);
Route::delete('/Product-image/{id}', [ProductImageController::class, 'delete']);


Route::get('/Product-variant', [ProductVariantController::class, 'index']);
Route::post('/Product-variant', [ProductVariantController::class, 'store']);
Route::get('/Product-variant/{id}', [ProductVariantController::class, 'show']);
Route::put('/Product-variant/{id}', [ProductVariantController::class, 'update']);
Route::delete('/Product-variant/{id}', [ProductVariantController::class, 'delete']);



Route::get('/customers', [CustomerController::class, 'index']);
Route::post('/customers', [CustomerController::class, 'store']);
Route::get('/customers/{id}', [CustomerController::class, 'show']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::delete('/customers/{id}', [CustomerController::class, 'delete']);


//----------------------------------------------------------------------------------
//                              Block Route in folder wishlist
//----------------------------------------------------------------------------------
Route::get('/wishlist', [WishlistController::class, 'index']);
Route::post('/wishlist', [WishlistController::class, 'store']);
Route::get('/wishlist/{id}', [WishlistController::class, 'show']);
Route::put('/wishlist/{id}', [WishlistController::class, 'update']);
Route::delete('/wishlist/{id}', [WishlistController::class, 'delete']);


Route::get('/wishlistItem', [WishlistItemController::class, 'index']);
Route::post('/wishlistItem', [WishlistItemController::class, 'store']);
Route::get('/wishlistItem/{id}', [WishlistItemController::class, 'show']);
Route::put('/wishlistItem/{id}', [WishlistItemController::class, 'update']);
Route::delete('/wishlistItem/{id}', [WishlistItemController::class, 'delete']);



//----------------------------------------------------------------------------------
//                              Block Route in folder orders
//----------------------------------------------------------------------------------
Route::get('/Orders', [OrderController::class, 'index']);
Route::post('/Orders', [OrderController::class, 'store']);
Route::get('/Orders/{id}', [OrderController::class, 'show']);
Route::put('/Orders/{id}', [OrderController::class, 'update']);
Route::delete('/Orders/{id}', [OrderController::class, 'delete']);


Route::get('/Order-item', [OrderItemController::class, 'index']);
Route::post('/Order-item', [OrderItemController::class, 'store']);
Route::get('/Order-item/{id}', [OrderItemController::class, 'show']);
Route::put('/Order-item/{id}', [OrderItemController::class, 'update']);
Route::delete('/Order-item/{id}', [OrderItemController::class, 'delete']);


Route::get('/Order-status-history', [OrderStatusHistoryController::class, 'index']);
Route::post('/Order-status-history', [OrderStatusHistoryController::class, 'store']);
Route::get('/Order-status-history/{id}', [OrderStatusHistoryController::class, 'show']);
Route::put('/Order-status-history/{id}', [OrderStatusHistoryController::class, 'update']);
Route::delete('/Order-status-history/{id}', [OrderStatusHistoryController::class, 'delete']);


Route::get('/brand',         [BrandController::class, 'index']);
Route::post('/brand',        [BrandController::class, 'store']);
// Route::get('brand',          [BrandController::class, 'getBrandPagination']);
Route::get('/brand/{id}',    [BrandController::class, 'show']);
Route::put('/brand/{id}',    [BrandController::class, 'update']);
Route::delete('/brand/{id}', [BrandController::class, 'delete']);
