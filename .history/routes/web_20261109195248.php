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
use App\Http\Controllers\ArusKasController;
use App\Http\Controllers\GudangTelurController;
use App\Http\Controllers\StokTelurController;

// LANDING PAGE (publik)
Route::get('/', function () {
    return view('landing');
})->name('landing');

/* ========== DASHBOARD (admin + umum) ========== */
Route::middleware(['auth', 'role:admin,umum'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/* ========== ADMIN + UMUM: READ-ONLY (GET ONLY) ========== */
Route::middleware(['auth', 'role:admin,umum'])->group(function () {
    // Index (lihat data)
    Route::get('/kandang', [KandangController::class, 'index'])->name('kandang.index');
    Route::get('/populasi', [PopulasiController::class, 'index'])->name('populasi.index');
    Route::get('/bobot', [BobotAyamController::class, 'index'])->name('bobot.index');
    Route::get('/produksi-telur', [ProduksiTelurController::class, 'index'])->name('produksi-telur.index');
    Route::get('/penjualan-telur', [PenjualanTelurController::class, 'index'])->name('penjualan-telur.index');
    Route::get('/pemberian-pakan', [PemberianPakanController::class, 'index'])->name('pemberian-pakan.index');
    Route::get('/pakan-kandang', [PakanKandangController::class, 'index'])->name('pakan-kandang.index');
    Route::get('/arus-kas', [ArusKasController::class, 'index'])->name('arus-kas.index');
    Route::get('/gudang-telur', [GudangTelurController::class, 'index'])->name('gudang-telur.index');
    Route::get('/stok-telur', [StokTelurController::class, 'index'])->name('stok-telur.index');

    // Show / detail
    Route::get('/kandang/{kandang}', [KandangController::class, 'show'])->name('kandang.show');
    Route::get('/populasi/{populasi}', [PopulasiController::class, 'show'])->name('populasi.show');
    Route::get('/bobot/{bobot}', [BobotAyamController::class, 'show'])->name('bobot.show');
    Route::get('/produksi-telur/{produksiTelur}', [ProduksiTelurController::class, 'show'])->name('produksi-telur.show');
    Route::get('/penjualan-telur/{penjualanTelur}', [PenjualanTelurController::class, 'show'])->name('penjualan-telur.show');
    Route::get('/pemberian-pakan/{pemberianPakan}', [PemberianPakanController::class, 'show'])->name('pemberian-pakan.show');
    Route::get('/pakan-kandang/{pakanKandang}', [PakanKandangController::class, 'show'])->name('pakan-kandang.show');
    Route::get('/arus-kas/{arusKas}', [ArusKasController::class, 'show'])->name('arus-kas.show');
    Route::get('/gudang-telur/{gudangTelur}', [GudangTelurController::class, 'show'])->name('gudang-telur.show');

    // Laporan
    Route::get('/laporan-pakan', [PakanKandangController::class, 'laporan'])->name('pakan.laporan');
    Route::get('/laporan-pakan/export', [PakanKandangController::class, 'exportExcel'])->name('pakan.laporan.export');
    Route::get('/arus-kas/export', [ArusKasController::class, 'exportExcel'])->name('arus-kas.export');
    Route::get('/admin/laporan', [LaporanHarianController::class, 'index'])->name('admin.laporan.index');
});

/* ========== KHUSUS ADMIN: TULIS DATA (create/store/edit/update/destroy) ========== */
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/kandang/create', [KandangController::class, 'create'])->name('kandang.create');
    Route::post('/kandang', [KandangController::class, 'store'])->name('kandang.store');
    Route::get('/kandang/{kandang}/edit', [KandangController::class, 'edit'])->name('kandang.edit');
    Route::put('/kandang/{kandang}', [KandangController::class, 'update'])->name('kandang.update');
    Route::delete('/kandang/{kandang}', [KandangController::class, 'destroy'])->name('kandang.destroy');

    Route::get('/populasi/create', [PopulasiController::class, 'create'])->name('populasi.create');
    Route::post('/populasi', [PopulasiController::class, 'store'])->name('populasi.store');
    Route::get('/populasi/{populasi}/edit', [PopulasiController::class, 'edit'])->name('populasi.edit');
    Route::put('/populasi/{populasi}', [PopulasiController::class, 'update'])->name('populasi.update');
    Route::delete('/populasi/{populasi}', [PopulasiController::class, 'destroy'])->name('populasi.destroy');

    Route::get('/bobot/create', [BobotAyamController::class, 'create'])->name('bobot.create');
    Route::post('/bobot', [BobotAyamController::class, 'store'])->name('bobot.store');
    Route::get('/bobot/{bobot}/edit', [BobotAyamController::class, 'edit'])->name('bobot.edit');
    Route::put('/bobot/{bobot}', [BobotAyamController::class, 'update'])->name('bobot.update');
    Route::delete('/bobot/{bobot}', [BobotAyamController::class, 'destroy'])->name('bobot.destroy');

    Route::get('/produksi-telur/create', [ProduksiTelurController::class, 'create'])->name('produksi-telur.create');
    Route::post('/produksi-telur', [ProduksiTelurController::class, 'store'])->name('produksi-telur.store');
    Route::get('/produksi-telur/{produksiTelur}/edit', [ProduksiTelurController::class, 'edit'])->name('produksi-telur.edit');
    Route::put('/produksi-telur/{produksiTelur}', [ProduksiTelurController::class, 'update'])->name('produksi-telur.update');
    Route::delete('/produksi-telur/{produksiTelur}', [ProduksiTelurController::class, 'destroy'])->name('produksi-telur.destroy');

    Route::get('/penjualan-telur/create', [PenjualanTelurController::class, 'create'])->name('penjualan-telur.create');
    Route::post('/penjualan-telur', [PenjualanTelurController::class, 'store'])->name('penjualan-telur.store');
    Route::get('/penjualan-telur/{penjualanTelur}/edit', [PenjualanTelurController::class, 'edit'])->name('penjualan-telur.edit');
    Route::put('/penjualan-telur/{penjualanTelur}', [PenjualanTelurController::class, 'update'])->name('penjualan-telur.update');
    Route::delete('/penjualan-telur/{penjualanTelur}', [PenjualanTelurController::class, 'destroy'])->name('penjualan-telur.destroy');

    Route::get('/pemberian-pakan/create', [PemberianPakanController::class, 'create'])->name('pemberian-pakan.create');
    Route::post('/pemberian-pakan', [PemberianPakanController::class, 'store'])->name('pemberian-pakan.store');
    Route::get('/pemberian-pakan/{pemberianPakan}/edit', [PemberianPakanController::class, 'edit'])->name('pemberian-pakan.edit');
    Route::put('/pemberian-pakan/{pemberianPakan}', [PemberianPakanController::class, 'update'])->name('pemberian-pakan.update');
    Route::delete('/pemberian-pakan/{pemberianPakan}', [PemberianPakanController::class, 'destroy'])->name('pemberian-pakan.destroy');

    Route::get('/pakan-kandang/create', [PakanKandangController::class, 'create'])->name('pakan-kandang.create');
    Route::post('/pakan-kandang', [PakanKandangController::class, 'store'])->name('pakan-kandang.store');
    Route::get('/pakan-kandang/{pakanKandang}/edit', [PakanKandangController::class, 'edit'])->name('pakan-kandang.edit');
    Route::put('/pakan-kandang/{pakanKandang}', [PakanKandangController::class, 'update'])->name('pakan-kandang.update');
    Route::delete('/pakan-kandang/{pakanKandang}', [PakanKandangController::class, 'destroy'])->name('pakan-kandang.destroy');

    Route::get('/arus-kas/create', [ArusKasController::class, 'create'])->name('arus-kas.create');
    Route::post('/arus-kas', [ArusKasController::class, 'store'])->name('arus-kas.store');
    Route::get('/arus-kas/{arusKas}/edit', [ArusKasController::class, 'edit'])->name('arus-kas.edit');
    Route::put('/arus-kas/{arusKas}', [ArusKasController::class, 'update'])->name('arus-kas.update');
    Route::delete('/arus-kas/{arusKas}', [ArusKasController::class, 'destroy'])->name('arus-kas.destroy');

    Route::get('/gudang-telur/create', [GudangTelurController::class, 'create'])->name('gudang-telur.create');
    Route::post('/gudang-telur', [GudangTelurController::class, 'store'])->name('gudang-telur.store');
    Route::get('/gudang-telur/{gudangTelur}/edit', [GudangTelurController::class, 'edit'])->name('gudang-telur.edit');
    Route::put('/gudang-telur/{gudangTelur}', [GudangTelurController::class, 'update'])->name('gudang-telur.update');
    Route::delete('/gudang-telur/{gudangTelur}', [GudangTelurController::class, 'destroy'])->name('gudang-telur.destroy');

    // Stok Telur (write)
    Route::post('/stok-telur/stok', [StokTelurController::class, 'storeStok'])->name('stok-telur.stok.store');
    Route::delete('/stok-telur/stok/{stokMasukTelur}', [StokTelurController::class, 'destroyStok'])->name('stok-telur.stok.destroy');
    Route::post('/stok-telur/return', [StokTelurController::class, 'storeReturn'])->name('stok-telur.return.store');
    Route::delete('/stok-telur/return/{returnTelur}', [StokTelurController::class, 'destroyReturn'])->name('stok-telur.return.destroy');
});

/* ========== KHUSUS MAN POWER ========== */
Route::middleware(['auth', 'role:manpower'])->group(function () {
    Route::get('/manpower/laporan', [LaporanHarianController::class, 'create'])->name('manpower.laporan.create');
    Route::post('/manpower/laporan', [LaporanHarianController::class, 'store'])->name('manpower.laporan.store');
});

require __DIR__.'/auth.php';
