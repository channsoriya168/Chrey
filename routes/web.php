<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\ProfileController;
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

// Cart routes (accessible to guests)
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::resource('cart', CartController::class)->only(['store', 'update', 'destroy']);
Route::get('api/cart/items', [CartController::class, 'getCartItems'])->name('api.cart.items');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Checkout flow
    Route::get('checkout/address', [OrderController::class, 'showAddressPage'])->name('checkout.address');
    Route::post('checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('checkout/status', [OrderController::class, 'checkoutStatus'])->name('checkout.status');

    // Payment - KHQR
    Route::get('payment/status/{cart}', [OrderController::class, 'checkPaymentStatus'])->name('payment.status');

    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');
});

// Include dashboard routes
require __DIR__ . '/dashboard.php';
