<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ApprovalController;
use Illuminate\Support\Facades\Route;


// Public Route (Landing Page)
Route::get('/', function () {
    return view('index');
});

// Guest Routes (Hanya bisa diakses jika BELUM login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes (Hanya bisa diakses jika SUDAH login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Route Bookings
    Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store']);

    Route::get('/bookings/export', [BookingController::class, 'export'])->name('bookings.export');

    // Route Approvals
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::post('/approvals/{id}/process', [ApprovalController::class, 'process'])->name('approvals.process');
});