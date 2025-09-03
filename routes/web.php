<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes (custom for Laravel 11 without laravel/ui)
Route::view('/login', 'auth.login')->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Siswa
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/siswa/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
});


Route::get('/redirect-role', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('absensi.index');
    }
})->middleware('auth');