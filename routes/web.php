<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Frontend/Index');
})->name('home');
Route::get('about', function () {
    return Inertia::render('Frontend/About');
})->name('about');

Route::get('contact', function () {
    return Inertia::render('Frontend/Contact');
})->name('contact');

Route::get('login', [AuthController::class, 'Login'])
    ->name('login');

// Include dashboard routes
require __DIR__ . '/dashboard.php';
