<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ApprovalController;
use Illuminate\Support\Facades\Route;

// Guest Routes (Halaman Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Route Bookings
    Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store']);

    // Route Approvals
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::post('/approvals/{id}/process', [ApprovalController::class, 'process'])->name('approvals.process');
});