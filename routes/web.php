<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Frontend/Home');
})->name('home');
Route::get('about', function () {
    return Inertia::render('Frontend/About');
})->name('about');

Route::get('contact', function () {
    return Inertia::render('Frontend/Contact');
})->name('contact');

// Include dashboard routes
require __DIR__ . '/dashboard.php';
