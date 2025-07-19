<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/', function () {
    return Inertia::render('Index');
})->name('home');

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard/Index');
    })->name('index');

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});
