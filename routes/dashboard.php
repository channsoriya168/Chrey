<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\RoleManagementController;
use App\Http\Controllers\Dashboard\UserManagementController;
use App\Http\Controllers\Dashboard\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Dashboard routes - accessible to users with 'access dashboard' permission
Route::prefix('dashboard')->name('dashboard.')->middleware(['auth', 'permission:access dashboard'])->group(function () {
    // Dashboard home
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // Product Management
    Route::resource('products', ProductController::class);

    // User Management (only for users with appropriate permissions)
    Route::resource('users', UserManagementController::class);

    // Role Management (only for users with appropriate permissions)
    Route::resource('roles', RoleManagementController::class);
});
