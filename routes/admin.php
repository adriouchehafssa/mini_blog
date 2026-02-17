<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;

// Admin Login Routes
Route::prefix('admin')->name('admin.')->group(function () {
    
// Guest routes (not authenticated)
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.post');
    });

    // Authenticated admin routes
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });
});