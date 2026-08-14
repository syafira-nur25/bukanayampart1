<?php

namespace App\Http\Controllers;

use App\Models\PenjualanTelur;
use App\Models\ProduksiTelur;
use Illuminate\Http\Request;

class PenjualanTelurController extends Controller
{
    public function index()
    {
        $penjualans = PenjualanTelur::with('produksiTelur')
            ->latest('tanggal')
            ->get();

        return view('penjualan_telur.index', compact('penjualans'));
    }

    public function create()
    {
        $produksis = ProduksiTelur::with('kandang')
            ->latest('tanggal')
            ->get();

        return view('penjualan_telur.create', compact('produksis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'customer' => 'required|string|max:100',
            'total' => 'required|integer|min:0',
            'produksi_id' => 'required|exists:produksi_telur,id',
            'harga' => 'required|numeric|min:0',
        ]);

        PenjualanTelur::create($validated);

        return redirect()
            ->route('penjualan-telur.index')
            ->with('success', 'Penjualan telur berhasil ditambahkan.');
    }

    public function show(PenjualanTelur $penjualanTelur)
    {
        $penjualanTelur->load('produksiTelur');

        return view(
            'penjualan_telur.show',
            compact('penjualanTelur')
        );
    }

    public function edit(PenjualanTelur $penjualanTelur)
    {
        $produksis = ProduksiTelur::with('kandang')
            ->latest('tanggal')
            ->get();

        return view('penjualan_telur.edit', compact(
            'penjualanTelur',
            'produksis'
        ));
    }

    public function update(
        Request $request,
        PenjualanTelur $penjualanTelur
    ) {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'customer' => 'required|string|max:100',
            'total' => 'required|integer|min:0',
            'produksi_id' => 'required|exists:produksi_telur,id',
            'harga' => 'required|numeric|min:0',
        ]);

        $penjualanTelur->update($validated);

        return redirect()
            ->route('penjualan-telur.index')
            ->with('success', 'Penjualan telur berhasil diperbarui.');
    }

    public function destroy(PenjualanTelur $penjualanTelur)
    {
        $penjualanTelur->delete();

        return redirect()
            ->route('penjualan-telur.index')
            ->with('success', 'Penjualan telur berhasil dihapus.');
    }
}
