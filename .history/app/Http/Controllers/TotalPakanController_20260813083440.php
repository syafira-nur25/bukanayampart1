<?php

namespace App\Http\Controllers;

use App\Models\PakanKandang;
use App\Models\TotalPakan;
use Illuminate\Http\Request;

class TotalPakanController extends Controller
{
    public function index()
    {
        $totals = TotalPakan::with([
            'pakanKandang.kandang',
        ])->latest()->get();

        return view('total_pakan.index', compact('totals'));
    }

    public function create()
    {
        $pakanKandangs = PakanKandang::with('kandang')
            ->latest('tanggal')
            ->get();

        return view(
            'total_pakan.create',
            compact('pakanKandangs')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pakan_kandang_id' => 'required|exists:pakan_kandang,id',
            'total' => 'required|numeric|min:0',
        ]);

        TotalPakan::create($validated);

        return redirect()
            ->route('total-pakan.index')
            ->with('success', 'Total pakan berhasil ditambahkan.');
    }

    public function show(TotalPakan $totalPakan)
    {
        $totalPakan->load('pakanKandang.kandang');

        return view(
            'total_pakan.show',
            compact('totalPakan')
        );
    }

    public function edit(TotalPakan $totalPakan)
    {
        $pakanKandangs = PakanKandang::with('kandang')
            ->latest('tanggal')
            ->get();

        return view('total_pakan.edit', compact(
            'totalPakan',
            'pakanKandangs'
        ));
    }

    public function update(
        Request $request,
        TotalPakan $totalPakan
    ) {
        $validated = $request->validate([
            'pakan_kandang_id' => 'required|exists:pakan_kandang,id',
            'total' => 'required|numeric|min:0',
        ]);

        $totalPakan->update($validated);

        return redirect()
            ->route('total-pakan.index')
            ->with('success', 'Total pakan berhasil diperbarui.');
    }

    public function destroy(TotalPakan $totalPakan)
    {
        $totalPakan->delete();

        return redirect()
            ->route('total-pakan.index')
            ->with('success', 'Total pakan berhasil dihapus.');
    }
}
