<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use Illuminate\Http\Request;

class KandangController extends Controller
{
    public function index()
    {
        $kandangs = Kandang::latest()->get();

        return view('kandang.index', compact('kandangs'));
    }

    public function create()
    {
        return view('kandang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
        ]);

        Kandang::create($validated);

        return redirect()
            ->route('kandang.index')
            ->with('success', 'Kandang berhasil ditambahkan.');
    }

    public function show(Kandang $kandang)
    {
        return view('kandang.show', compact('kandang'));
    }

    public function edit(Kandang $kandang)
    {
        return view('kandang.edit', compact('kandang'));
    }

    public function update(Request $request, Kandang $kandang)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
        ]);

        $kandang->update($validated);

        return redirect()
            ->route('kandang.index')
            ->with('success', 'Kandang berhasil diperbarui.');
    }

    public function destroy(Kandang $kandang)
    {
        $kandang->delete();

        return redirect()
            ->route('kandang.index')
            ->with('success', 'Kandang berhasil dihapus.');
    }
}
