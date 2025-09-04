<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AbsensiApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Use web middleware to enable session-based auth for API calls
// This allows the API to use Laravel's session-based authentication instead of token-based auth
// It's useful when you want to share authentication state between web and API routes
// Route::middleware(['web'])->group(function () {
//     // Auth (session based)
//     Route::post('/login', [AuthController::class, 'loginApi'])->name('api.login')->middleware('guest');

//     Route::middleware(['auth'])->group(function () {
//         Route::post('/logout', [AuthController::class, 'logoutApi'])->name('api.logout');
//         Route::get('/me', [AuthController::class, 'me'])->name('api.me');

//         // Siswa endpoints
//         Route::get('/absensi', [AbsensiApiController::class, 'index'])->name('api.absensi.index');
//         Route::post('/absensi', [AbsensiApiController::class, 'store'])->name('api.absensi.store');

//         // Admin endpoints
//         Route::middleware(['role:admin'])->group(function () {
//             Route::get('/admin/absensi', [AbsensiApiController::class, 'adminIndex'])->name('api.admin.absensi.index');
//         });
//     });
// });

// Auth API
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout')->middleware('auth:sanctum');

// Admin
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('api.admin.dashboard');
});

// Siswa
Route::middleware(['auth:sanctum', 'role:siswa'])->group(function () {
    Route::get('/siswa/absensi', [AbsensiApiController::class, 'index'])->name('api.absensi.index');
    Route::post('/siswa/absensi', [AbsensiApiController::class, 'store'])->name('api.absensi.store');
});

// Redirect role (API biasanya tidak redirect, tapi balikin JSON)
Route::middleware('auth:sanctum')->get('/redirect-role', function () {
    $role = Auth::user()->role;   

    return response()->json([
        'redirect_to' => $role === 'admin' ? 'admin.dashboard' : 'absensi.index'
    ]);
});