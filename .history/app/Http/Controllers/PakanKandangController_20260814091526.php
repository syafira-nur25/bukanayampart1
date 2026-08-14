<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\PakanKandang;
use Illuminate\Http\Request;

class PakanKandangController extends Controller
{
    public function index()
    {
        $pakans = PakanKandang::with('kandang')
            ->latest('tanggal')
            ->get();

        return view('pakan_kandang.index', compact('pakans'));
    }

public function create()
{
    $kandangs = Kandang::all();

    // Ambil data pakans untuk dikirim ke view create
    $pakans = PakanKandang::with('kandang')->latest('tanggal')->get();

    return view('pakan_kandang.create', compact('kandangs', 'pakans'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'total_masuk' => 'required|numeric|min:0',
            'kandang_id' => 'required|exists:kandang,id',
            'keluar' => 'required|numeric|min:0',
            'sisa' => 'required|numeric|min:0',
        ]);

        PakanKandang::create($validated);

        return redirect()
            ->route('pakan-kandang.index')
            ->with('success', 'Data pakan berhasil ditambahkan.');
    }

    public function show(PakanKandang $pakanKandang)
    {
        $pakanKandang->load([
            'kandang',
            'totalPakan',
        ]);

        return view(
            'pakan_kandang.show',
            compact('pakanKandang')
        );
    }

    public function edit(PakanKandang $pakanKandang)
    {
        $kandangs = Kandang::all();

        return view('pakan_kandang.edit', compact(
            'pakanKandang',
            'kandangs'
        ));
    }

    public function update(
        Request $request,
        PakanKandang $pakanKandang
    ) {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'total_masuk' => 'required|numeric|min:0',
            'kandang_id' => 'required|exists:kandang,id',
            'keluar' => 'required|numeric|min:0',
            'sisa' => 'required|numeric|min:0',
        ]);

        $pakanKandang->update($validated);

        return redirect()
            ->route('pakan-kandang.index')
            ->with('success', 'Data pakan berhasil diperbarui.');
    }

    public function destroy(PakanKandang $pakanKandang)
    {
        $pakanKandang->delete();

        return redirect()
            ->route('pakan-kandang.index')
            ->with('success', 'Data pakan berhasil dihapus.');
    }
}
