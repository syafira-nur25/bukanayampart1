<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Populasi;
use Illuminate\Http\Request;

class PopulasiController extends Controller
{
    public function index()
    {
        $populasis = Populasi::with('kandang')->latest('tanggal')->get();
        return view('populasi.index', compact('populasis'));
    }

    public function create()
    {
        $kandangs = Kandang::all();
        return view('populasi.create', compact('kandangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'    => 'required|date',
            'hidup'      => 'required|integer|min:0',
            'mati'       => 'required|integer|min:0',
            'afkir'      => 'required|integer|min:0',
            'usia'       => 'required|integer|min:0',
            'kandang_id' => 'required|exists:kandang,id',
        ]);

        // SISA OTOMATIS = hidup - mati - afkir
        $validated['sisa'] = max(0, $validated['hidup'] - $validated['mati'] - $validated['afkir']);

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
            'tanggal'    => 'required|date',
            'hidup'      => 'required|integer|min:0',
            'mati'       => 'required|integer|min:0',
            'afkir'      => 'required|integer|min:0',
            'usia'       => 'required|integer|min:0',
            'kandang_id' => 'required|exists:kandang,id',
        ]);

        $validated['sisa'] = max(0, $validated['hidup'] - $validated['mati'] - $validated['afkir']);

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
