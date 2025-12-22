<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\PaymentController;
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
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::resource('cart', CartController::class)->only(['store', 'update', 'destroy']);
    Route::get('api/cart/items', [CartController::class, 'getCartItems'])->name('api.cart.items');

    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('checkout', [OrderController::class, 'checkout'])->name('checkout');

    // Payment - KHQR
    Route::get('payment/khqr/{order}', [PaymentController::class, 'showKhqrPayment'])->name('payment.khqr');
    Route::get('payment/status/{order}', [PaymentController::class, 'checkPaymentStatus'])->name('payment.status');

    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');
});

// Bakong Webhook (outside auth middleware)
Route::post('webhook/bakong', [PaymentController::class, 'handleWebhook'])->name('webhook.bakong');

// Include dashboard routes
require __DIR__ . '/dashboard.php';
