<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AbsensiApiController;
use Illuminate\Support\Facades\Route;

// Use web middleware to enable session-based auth for API calls
// This allows the API to use Laravel's session-based authentication instead of token-based auth
// It's useful when you want to share authentication state between web and API routes
Route::middleware(['web'])->group(function () {
    // Auth (session based)
    Route::post('/login', [AuthController::class, 'loginApi'])->name('api.login')->middleware('guest');

    Route::middleware(['auth'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logoutApi'])->name('api.logout');
        Route::get('/me', [AuthController::class, 'me'])->name('api.me');

        // Siswa endpoints
        Route::get('/absensi', [AbsensiApiController::class, 'index'])->name('api.absensi.index');
        Route::post('/absensi', [AbsensiApiController::class, 'store'])->name('api.absensi.store');

        // Admin endpoints
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/admin/absensi', [AbsensiApiController::class, 'adminIndex'])->name('api.admin.absensi.index');
        });
    });
});