<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Populasi;
use App\Models\ProduksiTelur;
use App\Models\PenjualanTelur;
use App\Models\LaporanHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    private const NAMA_BULAN = [
        1  => 'Januari',   2  => 'Februari',  3  => 'Maret',
        4  => 'April',     5  => 'Mei',        6  => 'Juni',
        7  => 'Juli',      8  => 'Agustus',    9  => 'September',
        10 => 'Oktober',   11 => 'November',   12 => 'Desember',
    ];

    public function index(Request $request)
    {
        /* ===== 1. DAFTAR BULAN PER SUMBER DATA ===== */
        $daftarBulanProduksi  = $this->daftarBulan(ProduksiTelur::pluck('tanggal'));
        $daftarBulanPenjualan = $this->daftarBulan(PenjualanTelur::pluck('tanggal'));
        $daftarBulanKematian  = $this->daftarBulan(Populasi::pluck('tanggal'));

        $bulanProduksi  = $this->pilihBulan($request->query('bulan_produksi'),  $daftarBulanProduksi);
        $bulanPenjualan = $this->pilihBulan($request->query('bulan_penjualan'), $daftarBulanPenjualan);
        $bulanKematian  = $this->pilihBulan($request->query('bulan_kematian'),  $daftarBulanKematian);

        $labelBulanProduksi  = $this->labelBulan($bulanProduksi);
        $labelBulanPenjualan = $this->labelBulan($bulanPenjualan);
        $labelBulanKematian  = $this->labelBulan($bulanKematian);

        /* ===== 2. KARTU RINGKASAN (global / semua periode) ===== */
        $totalKandang = Kandang::count();

        $totalAyam = Populasi::orderByDesc('tanggal')->orderByDesc('id')
            ->get()
            ->unique('kandang_id')   // sisakan 1 record terbaru per kandang
            ->sum('sisa');

        $totalTelur     = ProduksiTelur::sum('jumlah_produksi');
        $totalPenjualan = PenjualanTelur::sum('total');

        $produksiTerbaru = ProduksiTelur::with(['kandang'])
            ->latest('tanggal')->limit(10)->get();

        /* ===== 3. GRAFIK PRODUKSI (filter sendiri) ===== */
        [$chartLabelsProduksi, $chartDataProduksi] = $this->buildChart(
            $bulanProduksi,
            ProduksiTelur::selectRaw('tanggal, SUM(jumlah_produksi) as total')
        );

        /* ===== 4. GRAFIK PENJUALAN (filter sendiri) ===== */
        [$chartLabelsPenjualan, $chartDataPenjualan] = $this->buildChart(
            $bulanPenjualan,
            PenjualanTelur::selectRaw('tanggal, SUM(total) as total')
        );

        /* ===== 5. GRAFIK KEMATIAN (filter sendiri, 2 dataset) ===== */
        [$start, $end] = $this->rentangBulan($bulanKematian);

        $kematianMap = Populasi::selectRaw('tanggal, SUM(mati) as mati, SUM(afkir) as afkir')
            ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
            ->groupBy('tanggal')
            ->get()
            ->keyBy(fn ($r) => Carbon::parse($r->tanggal)->toDateString());

        $chartLabelsKematian = [];
        $kematianMati  = [];
        $kematianAfkir = [];
        $hari = $start->copy();
        while ($hari <= $end) {
            $key = $hari->toDateString();
            $chartLabelsKematian[] = $hari->format('d M');
            $kematianMati[]  = (int) ($kematianMap[$key]->mati ?? 0);
            $kematianAfkir[] = (int) ($kematianMap[$key]->afkir ?? 0);
            $hari->addDay();
        }

        /* ===== 6. RINGKASAN PENJUALAN (ikut bulan penjualan terpilih) ===== */
        $avgSales = count($chartDataPenjualan) ? round(collect($chartDataPenjualan)->avg()) : 0;
        $sumSales = collect($chartDataPenjualan)->sum();

        $namaBulan = self::NAMA_BULAN;

        return view('dashboard', compact(
            'totalKandang', 'totalAyam', 'totalTelur', 'totalPenjualan', 'produksiTerbaru',
            'daftarBulanProduksi', 'daftarBulanPenjualan', 'daftarBulanKematian',
            'bulanProduksi', 'bulanPenjualan', 'bulanKematian',
            'labelBulanProduksi', 'labelBulanPenjualan', 'labelBulanKematian',
            'chartLabelsProduksi', 'chartDataProduksi',
            'chartLabelsPenjualan', 'chartDataPenjualan',
            'chartLabelsKematian', 'kematianMati', 'kematianAfkir',
            'avgSales', 'sumSales', 'namaBulan'
        ));
    }

    /* ================= HELPER ================= */

    private function daftarBulan($tanggalCollection)
    {
        return $tanggalCollection
            ->filter()
            ->map(fn ($t) => Carbon::parse($t)->format('Y-m'))
            ->unique()
            ->sortDesc()
            ->values();
    }

    private function pilihBulan(?string $input, $daftar): string
    {
        return ($input && $daftar->contains($input))
            ? $input
            : ($daftar->first() ?? Carbon::now()->format('Y-m'));
    }

    /** ✅ Label bulan aman — tidak pakai createFromFormat('Y-m') */
    private function labelBulan(string $bulan): string
    {
        [$tahun, $bln] = explode('-', $bulan);
        return self::NAMA_BULAN[(int) $bln] . ' ' . $tahun;
    }

    /** ✅ Hari dipaksa '-01' supaya tidak luber ke bulan berikutnya */
    private function rentangBulan(string $bulan): array
    {
        $start = Carbon::createFromFormat('Y-m-d', $bulan . '-01')->startOfDay();
        return [$start, $start->copy()->endOfMonth()];
    }

    /** Bangun [labels, data] harian untuk 1 bulan dari query SUM per tanggal */
    private function buildChart(string $bulan, $query): array
    {
        [$start, $end] = $this->rentangBulan($bulan);

        $map = $query
            ->whereBetween('tanggal', [$start->toDateString(), $end->toDateString()])
            ->groupBy('tanggal')
            ->get()
            ->mapWithKeys(fn ($r) => [
                Carbon::parse($r->tanggal)->toDateString() => (int) $r->total,
            ]);

        $labels = [];
        $data   = [];
        $hari = $start->copy();
        while ($hari <= $end) {
            $key = $hari->toDateString();
            $labels[] = $hari->format('d M');
            $data[]   = (int) ($map[$key] ?? 0);
            $hari->addDay();
        }

        return [$labels, $data];
    }
}
