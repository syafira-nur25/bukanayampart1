<?php

namespace App\Http\Controllers\Manpower;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use App\Models\LaporanHarian;
use App\Models\Populasi;
use Illuminate\Http\Request;

class LaporanHarianController extends Controller
{
    /** ADMIN: melihat semua kiriman laporan manpower */
    public function index(Request $request)
    {
        $kandangs = Kandang::orderBy('id')->get();

        $laporan = LaporanHarian::with(['kandang', 'user'])
            ->when($request->tanggal, fn ($q, $t) => $q->whereDate('tanggal', $t))
            ->when($request->kandang_id, fn ($q, $k) => $q->where('kandang_id', $k))
            ->latest('tanggal')
            ->paginate(15)
            ->withQueryString();

        return view('admin.laporan.index', compact('kandangs', 'laporan'));
    }

    /** MANPOWER: form laporan harian */
    public function create()
    {
        $kandangs = Kandang::orderBy('id')->get();
        $populasiTerakhir = [];

        foreach ($kandangs as $kandang) {
            // ✅ SELALU ambil dari data Populasi (input admin), bukan dari laporan sebelumnya
            $pop = Populasi::where('kandang_id', $kandang->id)
                ->latest('tanggal')->first();

            $populasiTerakhir[$kandang->id] = $pop ? [
                'sisa'          => (int) $pop->sisa,
                'hidup'         => (int) $pop->hidup,
                'mati'          => (int) $pop->mati,
                'afkir'         => (int) $pop->afkir,
                'tanggal'       => $pop->tanggal->format('d/m/Y'),
                'usia_dasar'    => (int) $pop->usia,
                'tanggal_dasar' => $pop->tanggal->toDateString(),
            ] : null;
        }

        return view('manpower.create', [
            'kandangs'         => $kandangs,
            'populasiTerakhir' => $populasiTerakhir,
            'today'            => now()->toDateString(),
        ]);
    }

    /** MANPOWER: simpan laporan — TIDAK mengubah data Populasi admin */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'        => 'required|date',
            'kandang_id'     => 'required|exists:kandang,id',
            'umur_minggu'    => 'required|integer|min:0',
            'hidup'          => 'nullable|integer|min:0',
            'mati'           => 'required|integer|min:0',
            'afkir'          => 'required|integer|min:0',
            'total_pakan'    => 'required|numeric|min:0',
            'produksi_telur' => 'required|integer|min:0',
            'telur_pecah'    => 'required|integer|min:0',
            'column_10'      => 'nullable|string|max:255',
        ]);

        // Cegah laporan dobel: 1 kandang 1 tanggal
        $sudahAda = LaporanHarian::where('kandang_id', $validated['kandang_id'])
            ->whereDate('tanggal', $validated['tanggal'])
            ->exists();

        if ($sudahAda) {
            return back()->withInput()->withErrors([
                'tanggal' => 'Laporan tanggal ini untuk kandang tersebut sudah ada.',
            ]);
        }

        // ✅ Ambil baseline SELALU dari Populasi admin (bukan dari laporan sebelumnya)
        $pop = Populasi::where('kandang_id', $validated['kandang_id'])
            ->latest('tanggal')->first();

        $validated['user_id'] = $request->user()->id;

        // Populasi awal = sisa dari data admin, atau input manual jika belum ada
        $validated['hidup'] = $pop
            ? (int) $pop->sisa
            : (int) ($validated['hidup'] ?? 0);

        // Sisa ayam = hidup - mati (afkir tidak mengurangi, sesuai aturan sebelumnya)
        $validated['sisa_ayam'] = max(0, $validated['hidup'] - (int) $validated['mati']);

        // ✅ Simpan ke laporan_harian SAJA — TIDAK mengubah tabel populasi admin
        LaporanHarian::create($validated);

        // ✅ TIDAK memanggil hitungUlangRantai — data manpower independen dari admin
        return redirect()->route('manpower.laporan.create')
            ->with('success', 'Laporan harian berhasil disimpan.');
    }
}
