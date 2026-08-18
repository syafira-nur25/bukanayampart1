<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\PopulasiController;
use App\Http\Controllers\ProduksiTelurController;
use App\Http\Controllers\PenjualanTelurController;
use App\Http\Controllers\PakanKandangController;
use App\Http\Controllers\PemberianPakanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Manpower\LaporanHarianController;

// LANDING PAGE (publik)
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kandang', KandangController::class);
    Route::resource('populasi', PopulasiController::class);
    Route::resource('produksi-telur', ProduksiTelurController::class);
    Route::resource('penjualan-telur', PenjualanTelurController::class);
    Route::resource('pemberian-pakan', PemberianPakanController::class);
    Route::resource('pakan-kandang', PakanKandangController::class);

Route::get('/laporan-pakan', [PakanKandangController::class, 'laporan'])->name('pakan.laporan');
Route::get('/laporan-pakan/export', [PakanKandangController::class, 'exportExcel'])->name('pakan.laporan.export'); // <-- BARU
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kandang', KandangController::class);
    Route::resource('populasi', PopulasiController::class);
    Route::resource('produksi-telur', ProduksiTelurController::class);
    Route::resource('penjualan-telur', PenjualanTelurController::class);
    Route::resource('pemberian-pakan', PemberianPakanController::class);
    Route::resource('pakan-kandang', PakanKandangController::class);

    Route::get('/laporan-pakan', [PakanKandangController::class, 'laporan'])->name('pakan.laporan');
    Route::get('/laporan-pakan/export', [PakanKandangController::class, 'exportExcel'])->name('pakan.laporan.export');

    // TAMBAHKAN BARIS INI UNTUK LAPORAN HARIAN ADMIN
    Route::get('/admin/laporan', [LaporanHarianController::class, 'index'])->name('admin.laporan.index');
});

require __DIR__.'/auth.php';
