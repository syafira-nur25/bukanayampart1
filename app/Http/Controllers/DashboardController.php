<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Populasi;
use App\Models\ProduksiTelur;
use App\Models\PenjualanTelur;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKandang = Kandang::count();

        $totalAyam = Populasi::sum('sisa');

        $totalTelur = ProduksiTelur::sum('jumlah_produksi');

        $totalPenjualan = PenjualanTelur::sum('total');

        $produksiTerbaru = ProduksiTelur::with([
            'kandang'
        ])
        ->latest('tanggal')
        ->limit(10)
        ->get();

        $chart = ProduksiTelur::selectRaw(
            'tanggal, SUM(jumlah_produksi) as total'
        )
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->limit(7)
        ->get();

        $chartLabels = $chart->map(
            fn ($item) => $item->tanggal->format('d M')
        );

        $chartData = $chart->pluck('total');

        return view('dashboard', compact(
            'totalKandang',
            'totalAyam',
            'totalTelur',
            'totalPenjualan',
            'produksiTerbaru',
            'chartLabels',
            'chartData'
        ));
    }
}
