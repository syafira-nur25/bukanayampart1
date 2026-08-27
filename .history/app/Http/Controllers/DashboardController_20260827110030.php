<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Populasi;
use App\Models\ProduksiTelur;
use App\Models\PenjualanTelur;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    private const NAMA_BULAN = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    public function index(Request $request)
    {
        /* ===== FILTER BULAN (format Y-m) ===== */
        $daftarBulan = collect()
            ->merge(ProduksiTelur::pluck('tanggal'))
            ->merge(PenjualanTelur::pluck('tanggal'))
            ->merge(Populasi::pluck('tanggal'))
            ->filter()
            ->map(fn ($t) => Carbon::parse($t)->format('Y-m'))
            ->unique()
            ->sortDesc()
            ->values();

        $bulan = $request->query('bulan');
        if (!$bulan || !$daftarBulan->contains($bulan)) {
            $bulan = $daftarBulan->first() ?? Carbon::now()->format('Y-m');
        }

        $start = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth();
        $end   = $start->copy()->endOfMonth();
        $labelBulan = self::NAMA_BULAN[(int) $start->format('n')] . ' ' . $start->format('Y');

        /* ===== KARTU RINGKASAN ===== */
        $totalKandang = Kandang::count();

        // ✅ POPULASI = jumlah "sisa" TERBARU per kandang (bukan total semua baris)
        $totalAyam = Populasi::orderByDesc('tanggal')->orderByDesc('id')
            ->get()
            ->unique('kandang_id')   // sisakan 1 record terbaru per kandang
            ->sum('sisa');

        $totalTelur     = ProduksiTelur::sum('jumlah_produksi');
        $totalPenjualan = PenjualanTelur::sum('total');

        $produksiTerbaru = ProduksiTelur::with(['kandang'])
            ->latest('tanggal')->limit(10)->get();

        /* ===== DATA GRAFIK HARIAN (sesuai bulan filter) ===== */
        $produksiPerTanggal = ProduksiTelur::selectRaw('tanggal, SUM(jumlah_produksi) as total')
            ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
            ->groupBy('tanggal')->get()
            ->mapWithKeys(fn ($r) => [Carbon::parse($r->tanggal)->toDateString() => (int) $r->total]);

        $penjualanPerTanggal = PenjualanTelur::selectRaw('tanggal, SUM(total) as total')
            ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
            ->groupBy('tanggal')->get()
            ->mapWithKeys(fn ($r) => [Carbon::parse($r->tanggal)->toDateString() => (int) $r->total]);

        // ✅ Grafik kematian dari DATA POPULASI (input admin)
        $kematianPerTanggal = Populasi::selectRaw('tanggal, SUM(mati) as mati, SUM(afkir) as afkir')
            ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
            ->groupBy('tanggal')->get()
            ->keyBy(fn ($r) => Carbon::parse($r->tanggal)->toDateString());

        // Label = semua hari dalam bulan terpilih
        $chartLabels = []; $chartData = []; $penjualanData = [];
        $kematianMati = []; $kematianAfkir = [];

        $hari = $start->copy();
        while ($hari <= $end) {
            $key = $hari->toDateString();
            $chartLabels[]   = $hari->format('d M');
            $chartData[]     = (int) ($produksiPerTanggal[$key] ?? 0);
            $penjualanData[] = (int) ($penjualanPerTanggal[$key] ?? 0);
            $kematianMati[]  = (int) ($kematianPerTanggal[$key]->mati ?? 0);
            $kematianAfkir[] = (int) ($kematianPerTanggal[$key]->afkir ?? 0);
            $hari->addDay();
        }

        /* ===== RINGKASAN PER PERIODE ===== */
        $avgSales = count($penjualanData) ? round(collect($penjualanData)->avg()) : 0;
        $sumSales = collect($penjualanData)->sum();

        $totalMati  = collect($kematianMati)->sum();
        $totalAfkir = collect($kematianAfkir)->sum();
        $denominator   = $totalMati + $totalAfkir + (int) $totalAyam;
        $mortalityRate = $denominator > 0 ? round($totalMati / $denominator * 100, 2) : 0;

        return view('dashboard', compact(
            'totalKandang', 'totalAyam', 'totalTelur', 'totalPenjualan',
            'produksiTerbaru',
            'bulan', 'daftarBulan', 'labelBulan', 'namaBulan',
            'chartLabels', 'chartData', 'penjualanData',
            'kematianMati', 'kematianAfkir',
            'avgSales', 'sumSales', 'totalMati', 'totalAfkir', 'mortalityRate'
        ));
    }
}
