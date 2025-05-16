<?php

use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\InstansiController;
use App\Http\Controllers\Admin\KelompokController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\TugasController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::view('/', 'auth.login')->name('login');
});

Route::middleware(['auth', 'role:1'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Kelompok
    Route::resource('kelompok', KelompokController::class);
    // Peserta
    Route::resource('peserta', PesertaController::class);
    // User
    Route::resource('user', UsersController::class);
    //Absensi
    Route::resource('absensi', AbsensiController::class);
});

Route::middleware(['auth', 'role:1,2'])->group(function () {
    // Absensi
    Route::get('absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('absensi/check/{id}', [AbsensiController::class, 'absen'])->name('absensi.check');
    Route::post('absensi/{id}/save', [AbsensiController::class, 'storeAbsen'])->name('absensi.absen.store');
    Route::post('absensi/{id}/konfirmasi', [AbsensiController::class, 'konfirmasi'])->name('absensi.konfirmasi');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::fallback(function () {
    return view('errors.404');
});
