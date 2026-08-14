<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanHarian;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLaporan = LaporanHarian::count();

        $laporanHariIni = LaporanHarian::whereDate(
            'tanggal',
            today()
        )->count();

        $totalMati = LaporanHarian::sum('mati');

        $totalProduksi = LaporanHarian::sum('produksi_telur');

        return view('admin.dashboard', compact(
            'totalLaporan',
            'laporanHariIni',
            'totalMati',
            'totalProduksi'
        ));
    }
}
