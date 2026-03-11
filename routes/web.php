<?php
// routes/web.php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Route;

// ─── User Routes ─────────────────────────────────────────────────────────────
Route::get('/', [UserController::class, 'index'])->name('user.form');
Route::post('/daftar', [UserController::class, 'store'])->name('user.store');
Route::get('/berhasil', [UserController::class, 'success'])->name('user.success');
Route::get('/api/kecamatan', [UserController::class, 'getKecamatan'])->name('api.kecamatan');
Route::get('/api/kelurahans', [UserController::class, 'getKelurahans'])->name('api.kelurahans');

// ─── Admin Routes ─────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');

    Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
        
        // Dua halaman utama
        Route::get('/data',  [AdminController::class, 'data'])->name('data');
        Route::get('/peta',  [AdminController::class, 'peta'])->name('peta');

        // Detail & logout
        Route::get('/rumah/{rumah}', [AdminController::class, 'show'])->name('show');
        Route::get('/logout',        [AdminController::class, 'logout'])->name('logout');

        // API peta
        Route::get('/api/map-data',  [AdminController::class, 'mapData'])->name('map-data');
        Route::get('/api/kelurahans', [AdminController::class, 'getKelurahans'])->name('api.kelurahans');

        // ── Wilayah CRUD ──────────────────────────────────────────────────────
        Route::get('/wilayah/kecamatan',                [WilayahController::class, 'kecamatanIndex'])->name('wilayah.kecamatan');
        Route::post('/wilayah/kecamatan',               [WilayahController::class, 'kecamatanStore'])->name('wilayah.kecamatan.store');
        Route::put('/wilayah/kecamatan/{kecamatan}',    [WilayahController::class, 'kecamatanUpdate'])->name('wilayah.kecamatan.update');
        Route::delete('/wilayah/kecamatan/{kecamatan}', [WilayahController::class, 'kecamatanDestroy'])->name('wilayah.kecamatan.destroy');

        Route::get('/wilayah/kelurahan',                [WilayahController::class, 'kelurahanIndex'])->name('wilayah.kelurahan');
        Route::post('/wilayah/kelurahan',               [WilayahController::class, 'kelurahanStore'])->name('wilayah.kelurahan.store');
        Route::put('/wilayah/kelurahan/{kelurahan}',    [WilayahController::class, 'kelurahanUpdate'])->name('wilayah.kelurahan.update');
        Route::delete('/wilayah/kelurahan/{kelurahan}', [WilayahController::class, 'kelurahanDestroy'])->name('wilayah.kelurahan.destroy');
    });
});