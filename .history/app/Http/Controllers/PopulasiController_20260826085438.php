<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Populasi;
use Illuminate\Http\Request;

class PopulasiController extends Controller
{
   public function index()
    {
        $populasis = Populasi::with('kandang')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        // kelompokkan: bulan (Y-m) -> kandang_id -> kumpulan record
        $perBulan = $populasis
            ->groupBy(fn ($p) => $p->tanggal->format('Y-m'))
            ->map(fn ($items) => $items->groupBy('kandang_id'));

        $kandangs = Kandang::orderBy('id')->get();

        $namaBulan = [
            1 => 'Januari',   2 => 'Februari', 3 => 'Maret',    4 => 'April',
            5 => 'Mei',       6 => 'Juni',     7 => 'Juli',     8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return view('populasi.index', compact('perBulan', 'kandangs', 'namaBulan'));
    }

    public function create()
    {
        $kandangs = Kandang::all();
        return view('populasi.create', compact('kandangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'      => 'required|date',
            'hidup'        => 'required|integer|min:0',
            'mati'         => 'required|integer|min:0',
            'afkir'        => 'required|integer|min:0',
            'umur_minggu'  => 'required|integer|min:0',
            'kandang_id'   => 'required|exists:kandang,id',
        ]);

        $validated['sisa'] = max(0, $validated['hidup'] - $validated['mati']);
        $validated['usia'] = $validated['umur_minggu'] * 7;
        unset($validated['umur_minggu']);

        Populasi::create($validated);

        return redirect()->route('populasi.index')
            ->with('success', 'Data populasi berhasil ditambahkan.');
    }

    public function show(Populasi $populasi)
    {
        $populasi->load(['kandang', 'produksiTelur', 'pemberianPakan']);
        return view('populasi.show', compact('populasi'));
    }

    public function edit(Populasi $populasi)
    {
        $kandangs = Kandang::all();
        return view('populasi.edit', compact('populasi', 'kandangs'));
    }

    public function update(Request $request, Populasi $populasi)
    {
        $validated = $request->validate([
            'tanggal'      => 'required|date',
            'hidup'        => 'required|integer|min:0',
            'mati'         => 'required|integer|min:0',
            'afkir'        => 'required|integer|min:0',
            'umur_minggu'  => 'required|integer|min:0',
            'kandang_id'   => 'required|exists:kandang,id',
        ]);

        $validated['sisa'] = max(0, $validated['hidup'] - $validated['mati']);
        $validated['usia'] = $validated['umur_minggu'] * 7;
        unset($validated['umur_minggu']);

        $populasi->update($validated);

        return redirect()->route('populasi.index')
            ->with('success', 'Data populasi berhasil diperbarui.');
    }

    public function destroy(Populasi $populasi)
    {
        $populasi->delete();
        return redirect()->route('populasi.index')
            ->with('success', 'Data populasi berhasil dihapus.');
    }
}
