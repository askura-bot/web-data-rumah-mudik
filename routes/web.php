<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ─── User Routes ─────────────────────────────────────────────────────────────
Route::get('/', [UserController::class, 'index'])->name('user.form');
Route::post('/daftar', [UserController::class, 'store'])->name('user.store');
Route::get('/berhasil', [UserController::class, 'success'])->name('user.success');
Route::get('/api/kecamatan', [UserController::class, 'getKecamatan'])->name('api.kecamatan');

// ─── Admin Routes ─────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');

    Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/rumah/{rumah}', [AdminController::class, 'show'])->name('show');
        Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/api/map-data', [AdminController::class, 'mapData'])->name('map-data');
    });
});
