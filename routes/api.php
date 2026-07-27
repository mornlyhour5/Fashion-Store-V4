<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Coupon\CouponController;
use App\Http\Controllers\Coupon\CouponUsageController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\OrderItemController;
use App\Http\Controllers\Order\OrderStatusHistoryController;
use App\Http\Controllers\Product\BrandController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductImageController;
use App\Http\Controllers\Product\ProductVariantController;
use App\Http\Controllers\Wishlist\WishlistController;
use App\Http\Controllers\Wishlist\WishlistItemController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// /*
// |--------------------------------------------------------------------------
// | Public Routes
// |--------------------------------------------------------------------------
// */
// Route::middleware('guest')->group(function () {
//     Route::post('/login', [LoginController::class, 'login']);
//     Route::post('/register', [RegisterController::class, 'register']);
//     Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
//     Route::post('/reset-password', [ResetPasswordController::class, 'reset']);
// });

// /*
// |--------------------------------------------------------------------------
// | Protected Routes
// |--------------------------------------------------------------------------
// */
// Route::middleware('auth:sanctum')->group(function () {
//     // auth
//     Route::post('/logout', [LoginController::class, 'logout']);

//     Route::get('/me', function (Request $request) {
//         return response()->json([
//             'error'   => false,
//             'status'  => 'success',
//             'message' => 'Authenticated user',
//             'data'    => $request->user(),
//         ]);
//     });

//     // customer
//     Route::get('/customers',         [CustomerController::class, 'index']);
//     Route::post('/customers',        [CustomerController::class, 'store']);
//     Route::get('/customers/{id}',    [CustomerController::class, 'show']);
//     Route::put('/customers/{id}',    [CustomerController::class, 'update']);
//     Route::delete('/customers/{id}', [CustomerController::class, 'delete']);

//     // address
//     Route::get('/addresses',         [AddressController::class, 'index']);
//     Route::get('/addresses/{id}',    [AddressController::class, 'show']);
//     Route::post('/addresses',        [AddressController::class, 'store']);
//     Route::put('/addresses/{id}',    [AddressController::class, 'update']);
//     Route::delete('/addresses/{id}', [AddressController::class, 'delete']);

//     // orders
//     Route::post('/Mainorders', [ProductsController::class, 'store']);
// });

// /*
// |--------------------------------------------------------------------------
// | Public Product Routes
// |--------------------------------------------------------------------------
// */
// Route::get('/category',         [CategoryController::class, 'index']);
// Route::post('/category',        [CategoryController::class, 'store']);
// Route::get('/category/{id}',    [CategoryController::class, 'show']);
// Route::put('/category/{id}',    [CategoryController::class, 'update']);
// Route::delete('/category/{id}', [CategoryController::class, 'delete']);

// Route::get('/products',         [ProductController::class, 'index']);
// Route::post('/products',        [ProductController::class, 'store']);
// Route::get('/products/{id}',    [ProductController::class, 'show']);
// Route::put('/products/{id}',    [ProductController::class, 'update']);
// Route::delete('/products/{id}', [ProductController::class, 'delete']);

// Route::get('/Product-image',         [ProductImageController::class, 'index']);
// Route::post('/Product-image',        [ProductImageController::class, 'store']);
// Route::get('/Product-image/{id}',    [ProductImageController::class, 'show']);
// Route::put('/Product-image/{id}',    [ProductImageController::class, 'update']);
// Route::delete('/Product-image/{id}', [ProductImageController::class, 'delete']);

// Route::get('/Product-variant',         [ProductVariantController::class, 'index']);
// Route::post('/Product-variant',        [ProductVariantController::class, 'store']);
// Route::get('/Product-variant/{id}',    [ProductVariantController::class, 'show']);
// Route::put('/Product-variant/{id}',    [ProductVariantController::class, 'update']);
// Route::delete('/Product-variant/{id}', [ProductVariantController::class, 'delete']);

// Route::get('/wishlist',         [WishlistController::class, 'index']);
// Route::post('/wishlist',        [WishlistController::class, 'store']);
// Route::get('/wishlist/{id}',    [WishlistController::class, 'show']);
// Route::put('/wishlist/{id}',    [WishlistController::class, 'update']);
// Route::delete('/wishlist/{id}', [WishlistController::class, 'delete']);

// Route::get('/wishlistItem',         [WishlistItemController::class, 'index']);
// Route::post('/wishlistItem',        [WishlistItemController::class, 'store']);
// Route::get('/wishlistItem/{id}',    [WishlistItemController::class, 'show']);
// Route::put('/wishlistItem/{id}',    [WishlistItemController::class, 'update']);
// Route::delete('/wishlistItem/{id}', [WishlistItemController::class, 'delete']);

Route::get('/Orders',         [OrderController::class, 'index']);
Route::post('/Orders',        [OrderController::class, 'store']);
Route::get('/Orders/{id}',    [OrderController::class, 'show']);
Route::put('/Orders/{id}',    [OrderController::class, 'update']);
Route::delete('/Orders/{id}', [OrderController::class, 'delete']);

Route::get('/Order-item',         [OrderItemController::class, 'index']);
Route::post('/Order-item',        [OrderItemController::class, 'store']);
Route::get('/Order-item/{id}',    [OrderItemController::class, 'show']);
Route::put('/Order-item/{id}',    [OrderItemController::class, 'update']);
Route::delete('/Order-item/{id}', [OrderItemController::class, 'delete']);



// Route::get('/Order-status-history',         [OrderStatusHistoryController::class, 'index']);
// Route::post('/Order-status-history',        [OrderStatusHistoryController::class, 'store']);
// Route::get('/Order-status-history/{id}',    [OrderStatusHistoryController::class, 'show']);
// Route::put('/Order-status-history/{id}',    [OrderStatusHistoryController::class, 'update']);
// Route::delete('/Order-status-history/{id}', [OrderStatusHistoryController::class, 'delete']);

// Route::get('/brand',         [BrandController::class, 'index']);
// Route::post('/brand',        [BrandController::class, 'store']);
// Route::get('/brand/{id}',    [BrandController::class, 'show']);
// Route::put('/brand/{id}',    [BrandController::class, 'update']);
// Route::delete('/brand/{id}', [BrandController::class, 'delete']);

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);


Route::middleware('auth:api')->group(function () {

//this block route users
    Route::post('/logout',       [LoginController::class, 'logout']);
    Route::get('/me',            [CustomerController::class, 'me']);



//customerProfile

//  admin route manages
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/getforuser',    [OrderController::class, 'getforuser']);
    Route::get('/wishlists',         [WishlistController::class, 'index']);

    Route::get('/coupons',             [CouponController::class, 'index']);
    Route::post('/coupons',            [CouponController::class, 'create']);
    Route::get('/coupons/{id}',        [CouponController::class, 'show']);
    Route::put('/coupons/{id}',        [CouponController::class, 'update']);
    Route::delete('/coupons/{id}',     [CouponController::class, 'delete']);

    Route::get('/coupon-usages',       [CouponUsageController::class,  'index']);
    Route::post('/coupon-usages',            [CouponUsageController::class, 'create']);
    Route::get('/coupon-usages/{id}',        [CouponUsageController::class, 'show']);
    Route::put('/coupon-usages/{id}',        [CouponUsageController::class, 'update']);
    Route::delete('/coupon-usages/{id}',     [CouponUsageController::class, 'delete']);
    
    Route::delete('/Product-variant/{variantId}/image/{imageId}', [ProductVariantController::class, 'deleteImage']);
    Route::patch('/Product-variant/{variantId}/image/{imageId}/main', [ProductVariantController::class, 'setMainImage']);



    //customer
    Route::get('/users',                   [CustomerController::class, 'getuser']);
    Route::get('/users/{id}',              [CustomerController::class, 'getuserbyId']);
    Route::get('/staff',                   [CustomerController::class, 'getstaff']);
    Route::patch('/customers/{id}/status', [CustomerController::class, 'updateStatusUser']);
    Route::get('/customerProfile/{id}',    [CustomerController::class, 'customerProfile']);
    Route::put('/customer/profile',        [CustomerController::class, 'updateProfile']);
    Route::post('/customer/avatar',        [CustomerController::class, 'updateAvatar']);

});
/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
// Route::middleware('auth:sanctum')->group(function () {
//     // auth
//     Route::post('/logout', [LoginController::class, 'logout']);

//     Route::get('/me', function (Request $request) {
//         return response()->json([
//             'error'   => false,
//             'status'  => 'success',
//             'message' => 'Authenticated user',
//             'data'    => $request->user(),
//         ]);
//     });

//     // customer

    Route::get('/customers',         [CustomerController::class, 'index']);
    Route::post('/customers',        [CustomerController::class, 'store']);
    Route::get('/customers/{id}',    [CustomerController::class, 'show']);
    Route::put('/customers/{id}',    [CustomerController::class, 'update']);
    Route::delete('/customers/{id}', [CustomerController::class, 'delete']);

//     // address
    Route::get('/addresses',         [AddressController::class, 'index']);
    Route::get('/getAddressAdmin',         [AddressController::class, 'getAddressAdmin']);
    Route::get('/addresses/{id}',    [AddressController::class, 'show']);
    Route::post('/addresses',        [AddressController::class, 'store']);
    Route::put('/addresses/{id}',    [AddressController::class, 'update']);
    Route::delete('/addresses/{id}', [AddressController::class, 'delete']);

//     // orders
//     Route::post('/Mainorders', [ProductsController::class, 'store']);
// });

/*
|--------------------------------------------------------------------------
| Public Product Routes
|--------------------------------------------------------------------------
*/
Route::get('/categories',         [CategoryController::class, 'index']);
Route::post('/categories',        [CategoryController::class, 'store']);
Route::get('/categories/{id}',    [CategoryController::class, 'show']);
Route::put('/categories/{id}',    [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'delete']);

Route::get('/products',         [ProductController::class, 'index']);
Route::post('/products',        [ProductController::class, 'store']);
Route::get('/products/{id}',    [ProductController::class, 'show']);
Route::put('/products/{id}',    [ProductController::class, 'update']);
Route::post('/products/{id}',   [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'delete']);

Route::get('/Product-image',         [ProductImageController::class, 'index']);
Route::post('/Product-image',        [ProductImageController::class, 'store']);
Route::get('/Product-image/{id}',    [ProductImageController::class, 'show']);
Route::put('/Product-image/{id}',    [ProductImageController::class, 'update']);
Route::delete('/Product-image/{id}', [ProductImageController::class, 'delete']);

Route::get('/Product-variant',         [ProductVariantController::class, 'index']);
Route::post('/Product-variant',        [ProductVariantController::class, 'store']);
Route::get('/Product-variant/{id}',    [ProductVariantController::class, 'show']);
Route::put('/Product-variant/{id}',    [ProductVariantController::class, 'update']);
Route::delete('/Product-variant/{id}', [ProductVariantController::class, 'delete']);

Route::get('/wishlistItem',         [WishlistItemController::class, 'index']);
Route::post('/wishlists',        [WishlistController::class, 'store']);
Route::get('/wishlists/{id}',    [WishlistController::class, 'show']);
Route::put('/wishlists/{id}',    [WishlistController::class, 'update']);
Route::delete('/wishlists/{id}', [WishlistController::class, 'delete']);

Route::post('/wishlistItem',        [WishlistItemController::class, 'store']);
Route::get('/wishlistItem/{id}',    [WishlistItemController::class, 'show']);
Route::put('/wishlistItem/{id}',    [WishlistItemController::class, 'update']);
Route::delete('/wishlistItem/{id}', [WishlistItemController::class, 'delete']);

Route::get('/Orders',         [OrderController::class, 'index']);
Route::post('/Orders',        [OrderController::class, 'store']);
Route::get('/Orders/{id}',    [OrderController::class, 'show']);
Route::put('/Orders/{id}',    [OrderController::class, 'update']);
Route::delete('/Orders/{id}', [OrderController::class, 'delete']);

Route::get('/Order-item',         [OrderItemController::class, 'index']);
Route::post('/Order-item',        [OrderItemController::class, 'store']);
Route::get('/Order-item/{id}',    [OrderItemController::class, 'show']);
Route::put('/Order-item/{id}',    [OrderItemController::class, 'update']);
Route::delete('/Order-item/{id}', [OrderItemController::class, 'delete']);

Route::get('/Order-status-history',         [OrderStatusHistoryController::class, 'index']);
Route::post('/Order-status-history',        [OrderStatusHistoryController::class, 'store']);
Route::get('/Order-status-history/{id}',    [OrderStatusHistoryController::class, 'show']);
Route::put('/Order-status-history/{id}',    [OrderStatusHistoryController::class, 'update']);
Route::delete('/Order-status-history/{id}', [OrderStatusHistoryController::class, 'delete']);

// Route::get('/brand',         [BrandController::class, 'index']);
// Route::post('/brand',        [BrandController::class, 'store']);
// Route::get('/brand/{id}',    [BrandController::class, 'show']);
// Route::put('/brand/{id}',    [BrandController::class, 'update']);
// Route::delete('/brand/{id}', [BrandController::class, 'delete']);

    Route::get('/brands', [BrandController::class, 'index']);
    Route::post('/brands', [BrandController::class, 'store']);
    Route::get('/brands/{id}', [BrandController::class, 'show']);
    Route::put('/brands/{id}', [BrandController::class, 'update']);
    Route::delete('/brands/{id}', [BrandController::class, 'delete']);


Route::prefix('carts')->group(function () {
    Route::get('/', [BrandController::class, 'index']);
    Route::post('/', [BrandController::class, 'store']);
    Route::get('/{id}', [BrandController::class, 'show']);
    Route::put('/{id}', [BrandController::class, 'update']);
    Route::delete('/{id}', [BrandController::class, 'delete']);
});




