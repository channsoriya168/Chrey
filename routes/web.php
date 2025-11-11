<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\FrontEndController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;




Route::get('/', [FrontEndController::class, 'index'])->name('home');
Route::get('about', function () {
    return Inertia::render('Frontend/About');
})->name('about');

Route::get('contact', function () {
    return Inertia::render('Frontend/Contact');
})->name('contact');

Route::get('register', [AuthController::class, 'register'])
    ->name('register');
Route::post('register', [AuthController::class, 'storeRegister'])
    ->name('register.store');

Route::get('login', [AuthController::class, 'login'])
    ->name('login');
Route::post('login', [AuthController::class, 'storeLogin'])
    ->name('login.store');

Route::post('logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Include dashboard routes
require __DIR__ . '/dashboard.php';
