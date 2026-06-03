<?php

use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('login');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');



Route::get('/products', [ProductsController::class, 'index']);
Route::post('/products', [ProductsController::class, 'store']);
Route::get('/checkout', [ProductsController::class, 'checkout']);
// Route::get('/products/{id}', [ProductsController::class, 'show']);
// Route::put('/products/{id}', [ProductsController::class, 'update']);
// Route::delete('/products/{id}', [ProductsController::class, 'delete']);
