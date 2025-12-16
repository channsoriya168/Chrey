<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\FrontEndController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;




Route::get('/', [FrontEndController::class, 'index'])->name('home');

Route::get('product/{slug}', [FrontEndController::class, 'productDetail'])->name('product.detail');

Route::get('register', [AuthController::class, 'register'])
    ->name('register');
Route::post('register', [AuthController::class, 'storeRegister'])
    ->name('register.store');

Route::get('login', [AuthController::class, 'login'])
    ->name('login');
Route::post('login', [AuthController::class, 'storeLogin'])
    ->name('login.store');

Route::middleware('auth')->group(function () {
    // checkout 
    Route::resource('cart', CartController::class)->only(['store', 'update', 'destroy']);
    Route::get('api/cart/items', [CartController::class, 'getCartItems'])->name('api.cart.items');

    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('checkout', [OrderController::class, 'checkout'])->name('checkout');

    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');
});

// Include dashboard routes
require __DIR__ . '/dashboard.php';
