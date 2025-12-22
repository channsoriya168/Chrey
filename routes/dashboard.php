<?php

use \App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OrderManagementController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\RoleManagementController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\UserManagementController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



// Dashboard routes - accessible to users with 'access dashboard' permission
Route::prefix('dashboard')->name('dashboard.')->middleware(['auth', 'permission:access dashboard'])->group(function () {
    // Dashboard home
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // Product Management
    Route::resource('products', ProductController::class);

    // Order Management
    Route::resource('orders', OrderManagementController::class)->only(['index', 'show', 'destroy']);

    // User Management (only for users with appropriate permissions)
    Route::resource('users', UserManagementController::class);

    // Role Management (only for users with appropriate permissions)
    Route::resource('roles', RoleManagementController::class);
    //settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
});
