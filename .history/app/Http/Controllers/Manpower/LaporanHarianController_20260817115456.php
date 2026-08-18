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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'        => 'required|date',
            'kandang_id'     => 'required|exists:kandang,id',
            'umur_minggu'    => 'required|integer|min:0',
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

        $validated['user_id']    = $request->user()->id;
        $validated['hidup']      = 0; // diisi otomatis
        $validated['sisa_ayam']  = 0; // diisi otomatis

        $laporan = LaporanHarian::create($validated);

        // hidup = sisa kemarin, sisa = hidup - mati - afkir
        LaporanHarian::hitungUlangRantai(
            $laporan->kandang_id,
            $laporan->tanggal->toDateString()
        );

        return redirect()->route('manpower.laporan.create')
            ->with('success', 'Laporan harian berhasil disimpan.');
    }
}
