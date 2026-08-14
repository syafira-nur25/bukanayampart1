<?php

namespace App\Http\Controllers;

use App\Models\PemberianPakan;
use App\Models\Populasi;
use Illuminate\Http\Request;

class PemberianPakanController extends Controller
{
    public function index()
    {
        $pemberians = PemberianPakan::with([
            'populasi.kandang',
        ])->latest()->get();

        return view(
            'pemberian_pakan.index',
            compact('pemberians')
        );
    }

    public function create()
    {
        $populasis = Populasi::with('kandang')
            ->latest('tanggal')
            ->get();

        return view(
            'pemberian_pakan.create',
            compact('populasis')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|string|max:20',
            'populasi_id' => 'required|exists:populasi,id',
            'gr' => 'required|integer|min:0',
            'kg' => 'required|integer|min:0',
            'total' => 'required|integer|min:0',
            'jenis_pakan' => 'required|string|max:50',
            'harga' => 'required|integer|min:0',
            'pengeluaran' => 'required|integer|min:0',
        ]);

        PemberianPakan::create($validated);

        return redirect()
            ->route('pemberian-pakan.index')
            ->with('success', 'Pemberian pakan berhasil ditambahkan.');
    }

    public function show(PemberianPakan $pemberianPakan)
    {
        $pemberianPakan->load('populasi.kandang');

        return view(
            'pemberian_pakan.show',
            compact('pemberianPakan')
        );
    }

    public function edit(PemberianPakan $pemberianPakan)
    {
        $populasis = Populasi::with('kandang')
            ->latest('tanggal')
            ->get();

        return view('pemberian_pakan.edit', compact(
            'pemberianPakan',
            'populasis'
        ));
    }

    public function update(
        Request $request,
        PemberianPakan $pemberianPakan
    ) {
        $validated = $request->validate([
            'bulan' => 'required|string|max:20',
            'populasi_id' => 'required|exists:populasi,id',
            'gr' => 'required|integer|min:0',
            'kg' => 'required|integer|min:0',
            'total' => 'required|integer|min:0',
            'jenis_pakan' => 'required|string|max:50',
            'harga' => 'required|integer|min:0',
            'pengeluaran' => 'required|integer|min:0',
        ]);

        $pemberianPakan->update($validated);

        return redirect()
            ->route('pemberian-pakan.index')
            ->with('success', 'Pemberian pakan berhasil diperbarui.');
    }

    public function destroy(PemberianPakan $pemberianPakan)
    {
        $pemberianPakan->delete();

        return redirect()
            ->route('pemberian-pakan.index')
            ->with('success', 'Pemberian pakan berhasil dihapus.');
    }
}
