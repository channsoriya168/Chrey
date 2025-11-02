<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', [DashboardController::class, 'index'])
//     ->name('index');

// Route::resource('categories', CategoryController::class);
// Route::resource('products', ProductController::class);
Route::prefix('dashboard')->name('dashboard.')->middleware(['auth', 'role:admin'])->group(function () {
    //   
});
