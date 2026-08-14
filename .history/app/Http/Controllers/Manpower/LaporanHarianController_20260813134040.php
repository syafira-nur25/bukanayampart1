<?php

namespace App\Http\Controllers\Manpower;

use App\Http\Controllers\Controller;
use App\Models\Kandang;
use App\Models\LaporanHarian;
use Illuminate\Http\Request;

class LaporanHarianController extends Controller
{
    public function create()
    {
        $kandangs = Kandang::orderBy('nama')->get();

        return view(
            'manpower.laporan.create',
            compact('kandangs')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => [
                'required',
                'date',
            ],

            'umur_minggu' => [
                'required',
                'integer',
                'min:0',
            ],

            'mati' => [
                'required',
                'integer',
                'min:0',
            ],

            'hidup' => [
                'required',
                'integer',
                'min:0',
            ],

            'afkir' => [
                'required',
                'integer',
                'min:0',
            ],

            'sisa_ayam' => [
                'required',
                'integer',
                'min:0',
            ],

            'produksi_telur' => [
                'required',
                'integer',
                'min:0',
            ],

            'telur_pecah' => [
                'required',
                'integer',
                'min:0',
            ],

            'column_10' => [
                'nullable',
                'string',
                'max:255',
            ],

            'kandang_id' => [
                'required',
                'exists:kandang,id',
            ],
        ]);

        $validated['user_id'] = auth()->id();

        LaporanHarian::create($validated);

        return redirect()
            ->route('manpower.laporan.create')
            ->with(
                'success',
                'Laporan harian berhasil disimpan.'
            );
    }
}
