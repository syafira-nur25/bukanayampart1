<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\PopulasiController;
use App\Http\Controllers\ProduksiTelurController;
use App\Http\Controllers\PenjualanTelurController;
use App\Http\Controllers\PakanKandangController;
use App\Http\Controllers\PemberianPakanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Manpower\LaporanHarianController;
use App\Http\Controllers\BobotAyamController;

// LANDING PAGE (publik)
Route::get('/', function () {
    return view('landing');
})->name('landing');

/* ========== KHUSUS ADMIN ========== */
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kandang', KandangController::class);
    Route::resource('populasi', PopulasiController::class);
    Route::resource('bobot', BobotAyamController::class);
    Route::resource('produksi-telur', ProduksiTelurController::class);
    Route::resource('penjualan-telur', PenjualanTelurController::class);
    Route::resource('pemberian-pakan', PemberianPakanController::class);
    Route::resource('pakan-kandang', PakanKandangController::class);
    

Route::get('/laporan-pakan', [PakanKandangController::class, 'laporan'])->name('pakan.laporan');
Route::get('/laporan-pakan/export', [PakanKandangController::class, 'exportExcel'])->name('pakan.laporan.export'); // <-- BARU
    // Laporan harian (rekap kiriman man power)
    Route::get('/admin/laporan', [LaporanHarianController::class, 'index'])->name('admin.laporan.index');

    // Export Excel (aktifkan kalau method exportExcel sudah ada di controller)
    // Route::get('/laporan-pakan/export', [PakanKandangController::class, 'exportExcel'])->name('pakan.laporan.export');
    // Route::get('/admin/laporan/export', [LaporanHarianController::class, 'exportExcel'])->name('admin.laporan.export');
});

/* ========== KHUSUS MAN POWER ========== */
Route::middleware(['auth', 'role:manpower'])->group(function () {
    Route::get('/manpower/laporan', [LaporanHarianController::class, 'create'])->name('manpower.laporan.create');
    Route::post('/manpower/laporan', [LaporanHarianController::class, 'store'])->name('manpower.laporan.store');
});

require __DIR__.'/auth.php';
