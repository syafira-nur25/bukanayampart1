<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\PopulasiController;
use App\Http\Controllers\ProduksiTelurController;
use App\Http\Controllers\PenjualanTelurController;
use App\Http\Controllers\PakanKandangController;
use App\Http\Controllers\PemberianPakanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Manpower\LaporanHarianController;

// Halaman awal: lempar sesuai role / ke login
Route::get('/', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    return auth()->user()->role === 'admin'
        ? redirect()->route('dashboard')
        : redirect()->route('manpower.laporan.create');
});

/* ================= ADMIN ================= */
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kandang', KandangController::class);
    Route::resource('populasi', PopulasiController::class);
    Route::resource('produksi-telur', ProduksiTelurController::class);
    Route::resource('penjualan-telur', PenjualanTelurController::class);
    Route::resource('pemberian-pakan', PemberianPakanController::class);
    Route::resource('pakan-kandang', PakanKandangController::class);

    Route::get('/laporan-pakan', [PakanKandangController::class, 'laporan'])->name('pakan.laporan');

    // Admin melihat semua laporan harian manpower
    Route::get('/admin/laporan', [LaporanHarianController::class, 'index'])->name('admin.laporan.index');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
});

/* ================= MANPOWER (anak kandang) ================= */
Route::middleware(['auth', 'role:manpower'])->group(function () {
    Route::get('/manpower/laporan', [LaporanHarianController::class, 'create'])->name('manpower.laporan.create');
    Route::post('/manpower/laporan', [LaporanHarianController::class, 'store'])->name('manpower.laporan.store');
});

require __DIR__.'/auth.php';
