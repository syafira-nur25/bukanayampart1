<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\LaporanHarian;
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
            ->latest('tanggal')
            ->limit(10)
            ->get();

        /* ===== GRAFIK PRODUKSI TELUR ===== */
        $chart = ProduksiTelur::selectRaw('tanggal, SUM(jumlah_produksi) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->limit(7)
            ->get();

        $chartLabels = $chart->map(fn ($item) => $item->tanggal->format('d M'));
        $chartData   = $chart->pluck('total');

        /* ===== DATA KEMATIAN (laporan harian manpower, fallback: populasi) ===== */
        $pakaiLaporan = LaporanHarian::query()->exists();
        $sumberKematian = $pakaiLaporan ? 'Laporan Harian Man Power' : 'Data Populasi';

        $kematian = ($pakaiLaporan
            ? LaporanHarian::selectRaw('tanggal, SUM(mati) as mati, SUM(afkir) as afkir')
            : Populasi::selectRaw('tanggal, SUM(mati) as mati, SUM(afkir) as afkir'))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // ambil 7 tanggal terakhir untuk grafik
        $chartKematian = $kematian->take(-7)->values();

        $kematianLabels = $chartKematian->map(fn ($item) => $item->tanggal->format('d M'));
        $kematianMati   = $chartKematian->pluck('mati');
        $kematianAfkir  = $chartKematian->pluck('afkir');

        /* ===== RESUME KEMATIAN ===== */
        $totalMati  = (int) $kematian->sum('mati');
        $totalAfkir = (int) $kematian->sum('afkir');

        // mortality rate = mati ÷ (sisa sekarang + mati + afkir) × 100
        $denominator   = $totalMati + $totalAfkir + (int) $totalAyam;
        $mortalityRate = $denominator > 0
            ? round($totalMati / $denominator * 100, 2)
            : 0;

        return view('dashboard', compact(
            'totalKandang', 'totalAyam', 'totalTelur', 'totalPenjualan',
            'produksiTerbaru', 'chartLabels', 'chartData',
            'sumberKematian', 'kematianLabels', 'kematianMati', 'kematianAfkir',
            'totalMati', 'totalAfkir', 'mortalityRate'
        ));
    }
}
