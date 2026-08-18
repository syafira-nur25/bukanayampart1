<?php

namespace App\Http\Controllers\Manpower;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use App\Models\LaporanHarian;
use Illuminate\Http\Request;
use App\Models\Populasi;

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
public function create()
{
    $kandangs = Kandang::orderBy('id')->get();

    // Populasi terakhir per kandang:
    // prioritas dari sisa laporan terakhir, kalau belum ada dari tabel populasi
    $populasiTerakhir = [];

    foreach ($kandangs as $kandang) {
        $lastLaporan = LaporanHarian::where('kandang_id', $kandang->id)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->first();

        if ($lastLaporan) {
            $populasiTerakhir[$kandang->id] = [
                'sisa'    => (int) $lastLaporan->sisa_ayam,
                'tanggal' => $lastLaporan->tanggal->format('d/m/Y'),
            ];
        } else {
            $pop = Populasi::where('kandang_id', $kandang->id)
                ->orderByDesc('tanggal')
                ->first();

            $populasiTerakhir[$kandang->id] = [
                'sisa'    => $pop ? (int) $pop->sisa : 0,
                'tanggal' => $pop ? $pop->tanggal->format('d/m/Y') : null,
            ];
        }
    }

    return view('manpower.create', [
        'kandangs'         => $kandangs,
        'populasiTerakhir' => $populasiTerakhir,
    ]);
}

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

        // cegah laporan dobel: 1 kandang 1 tanggal
        $sudahAda = LaporanHarian::where('kandang_id', $validated['kandang_id'])
            ->whereDate('tanggal', $validated['tanggal'])
            ->exists();

        if ($sudahAda) {
            return back()->withInput()->withErrors([
                'tanggal' => 'Laporan tanggal ini untuk kandang tersebut sudah ada.',
            ]);
        }

        // POPULASI AWAL:
        // - kalau sudah ada riwayat (laporan/populasi) → ikut rantai, input manual diabaikan
        // - kalau benar-benar pertama kali → pakai angka yang diisi manpower
        $baseline = LaporanHarian::baselineSebelum(
            (int) $validated['kandang_id'],
            $validated['tanggal']
        );

        $validated['user_id']   = $request->user()->id;
        $validated['hidup']     = $baseline ?? (int) ($validated['hidup'] ?? 0);
        $validated['sisa_ayam'] = 0; // dihitung otomatis

        $laporan = LaporanHarian::create($validated);

        // hidup = baseline/manual, sisa = hidup - mati - afkir (berantai)
        LaporanHarian::hitungUlangRantai(
            $laporan->kandang_id,
            $laporan->tanggal->toDateString()
        );

        return redirect()->route('manpower.laporan.create')
            ->with('success', 'Laporan harian berhasil disimpan.');
    }
}
