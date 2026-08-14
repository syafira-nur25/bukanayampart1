<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Populasi;
use App\Models\ProduksiTelur;
use Illuminate\Http\Request;

class ProduksiTelurController extends Controller
{
    public function index()
    {
        $produksis = ProduksiTelur::with([
            'kandang',
            'populasi',
        ])
            ->latest('tanggal')
            ->get();

        return view('produksi_telur.index', compact('produksis'));
    }

    public function create()
    {
        $kandangs = Kandang::all();
        $populasis = Populasi::with('kandang')
            ->latest('tanggal')
            ->get();

        return view('produksi_telur.create', compact(
            'kandangs',
            'populasis'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'populasi_id' => 'required|exists:populasi,id',
            'kandang_id' => 'required|exists:kandang,id',
            'jumlah_produksi' => 'required|integer|min:0',
            'presentase' => 'required|numeric|min:0|max:100',
            'mati' => 'required|integer|min:0',
            'afkir' => 'required|integer|min:0',
            'sisa_ayam' => 'required|integer|min:0',
            'telur_bagus' => 'required|integer|min:0',
            'telur_reject' => 'required|integer|min:0',
        ]);

        ProduksiTelur::create($validated);

        return redirect()
            ->route('produksi-telur.index')
            ->with('success', 'Produksi telur berhasil ditambahkan.');
    }

    public function show(ProduksiTelur $produksiTelur)
    {
        $produksiTelur->load([
            'kandang',
            'populasi',
            'penjualanTelur',
        ]);

        return view(
            'produksi_telur.show',
            compact('produksiTelur')
        );
    }

    public function edit(ProduksiTelur $produksiTelur)
    {
        $kandangs = Kandang::all();
        $populasis = Populasi::with('kandang')
            ->latest('tanggal')
            ->get();

        return view('produksi_telur.edit', compact(
            'produksiTelur',
            'kandangs',
            'populasis'
        ));
    }

    public function update(
        Request $request,
        ProduksiTelur $produksiTelur
    ) {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'populasi_id' => 'required|exists:populasi,id',
            'kandang_id' => 'required|exists:kandang,id',
            'jumlah_produksi' => 'required|integer|min:0',
            'presentase' => 'required|numeric|min:0|max:100',
            'mati' => 'required|integer|min:0',
            'afkir' => 'required|integer|min:0',
            'sisa_ayam' => 'required|integer|min:0',
            'telur_bagus' => 'required|integer|min:0',
            'telur_reject' => 'required|integer|min:0',
        ]);

        $produksiTelur->update($validated);

        return redirect()
            ->route('produksi-telur.index')
            ->with('success', 'Produksi telur berhasil diperbarui.');
    }

    public function destroy(ProduksiTelur $produksiTelur)
    {
        $produksiTelur->delete();

        return redirect()
            ->route('produksi-telur.index')
            ->with('success', 'Produksi telur berhasil dihapus.');
    }
}
