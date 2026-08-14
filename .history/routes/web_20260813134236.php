<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\PopulasiController;
use App\Http\Controllers\ProduksiTelurController;
use App\Http\Controllers\PenjualanTelurController;
use App\Http\Controllers\PakanKandangController;
use App\Http\Controllers\PemberianPakanController;
use App\Http\Controllers\TotalPakanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Manpower\LaporanHarianController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('kandang', KandangController::class);

Route::resource('populasi', PopulasiController::class);

Route::resource('produksi-telur', ProduksiTelurController::class);

Route::resource('penjualan-telur', PenjualanTelurController::class);

Route::resource('pakan-kandang', PakanKandangController::class);

Route::resource('pemberian-pakan', PemberianPakanController::class);

Route::resource('total-pakan', TotalPakanController::class);

Route::middleware(['auth', 'role:manpower'])
    ->prefix('manpower')
    ->name('manpower.')
    ->group(function () {

        Route::get(
            '/laporan',
            [LaporanHarianController::class, 'create']
        )->name('laporan.create');

        Route::post(
            '/laporan',
            [LaporanHarianController::class, 'store']
        )->name('laporan.store');

    });
