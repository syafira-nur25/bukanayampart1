<?php

namespace App\Http\Controllers;

use App\Models\GudangTelur;
use Illuminate\Http\Request;

class GudangTelurController extends Controller
{
    public function index()
    {
        $gudangs = GudangTelur::orderBy('id')->get();
        return view('gudang_telur.index', compact('gudangs'));
    }

    public function create()
    {
        return view('gudang_telur.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:100',
            'lokasi' => 'nullable|string|max:100',
        ]);
        GudangTelur::create($validated);
        return redirect()->route('gudang-telur.index')->with('success', 'Gudang berhasil ditambahkan.');
    }

    public function edit(GudangTelur $gudangTelur)
    {
        return view('gudang_telur.edit', compact('gudangTelur'));
    }

    public function update(Request $request, GudangTelur $gudangTelur)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:100',
            'lokasi' => 'nullable|string|max:100',
        ]);
        $gudangTelur->update($validated);
        return redirect()->route('gudang-telur.index')->with('success', 'Gudang berhasil diperbarui.');
    }

    public function destroy(GudangTelur $gudangTelur)
    {
        $gudangTelur->delete();
        return redirect()->route('gudang-telur.index')->with('success', 'Gudang berhasil dihapus.');
    }
}
