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
        $totalKandang   = Kandang::count();
        $totalAyam      = Populasi::sum('sisa');
        $totalTelur     = ProduksiTelur::sum('jumlah_produksi');
        $totalPenjualan = PenjualanTelur::sum('total');

        $produksiTerbaru = ProduksiTelur::with(['kandang'])
            ->latest('tanggal')->limit(10)->get();

        /* ===== Grafik produksi telur ===== */
        $chart = ProduksiTelur::selectRaw('tanggal, SUM(jumlah_produksi) as total')
            ->groupBy('tanggal')->orderBy('tanggal')->limit(7)->get();
        $chartLabels = $chart->map(fn ($item) => $item->tanggal->format('d M'));
        $chartData   = $chart->pluck('total');

        /* ===== Grafik penjualan (7 hari terakhir) ===== */
        $penjualanChart = PenjualanTelur::selectRaw('tanggal, SUM(total) as total')
            ->where('tanggal', '>=', now()->subDays(6)->toDateString())
            ->groupBy('tanggal')->orderBy('tanggal')->get();

        $penjualanMap = $penjualanChart->pluck('total', 'tanggal')->map(fn ($v) => (int) $v);
        $penjualanLabels = collect();
        $penjualanData   = collect();
        for ($i = 6; $i >= 0; $i--) {
            $penjualanLabels->push(now()->subDays($i)->format('d M'));
            $penjualanData->push($penjualanMap[now()->subDays($i)->toDateString()] ?? 0);
        }

        /* ===== Grafik kematian — SELALU dari input admin di Populasi ===== */
        $sumberKematian = 'Data Populasi (input admin)';

        $kematian = Populasi::selectRaw('tanggal, SUM(mati) as mati, SUM(afkir) as afkir')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $chartKematian  = $kematian->take(-7)->values();
        $kematianLabels = $chartKematian->map(fn ($item) => $item->tanggal->format('d M'));
        $kematianMati   = $chartKematian->pluck('mati');
        $kematianAfkir  = $chartKematian->pluck('afkir');

        /* ===== Resume kematian ===== */
        $totalMati     = (int) $kematian->sum('mati');
        $totalAfkir    = (int) $kematian->sum('afkir');
        $denominator   = $totalMati + $totalAfkir + (int) $totalAyam;
        $mortalityRate = $denominator > 0
            ? round($totalMati / $denominator * 100, 2)
            : 0;

        return view('dashboard', compact(
            'totalKandang', 'totalAyam', 'totalTelur', 'totalPenjualan',
            'produksiTerbaru', 'chartLabels', 'chartData',
            'penjualanLabels', 'penjualanData',
            'sumberKematian', 'kematianLabels', 'kematianMati', 'kematianAfkir',
            'totalMati', 'totalAfkir', 'mortalityRate'
        ));
    }
}
