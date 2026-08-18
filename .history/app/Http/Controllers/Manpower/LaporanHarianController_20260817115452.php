<?php

namespace App\Http\Controllers\Manpower;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use App\Models\LaporanHarian;
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

    /** MANPOWER: form daily recording */
    public function create()
    {
        return view('manpower.create', [
            'kandangs' => Kandang::orderBy('id')->get(),
        ]);
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
}
