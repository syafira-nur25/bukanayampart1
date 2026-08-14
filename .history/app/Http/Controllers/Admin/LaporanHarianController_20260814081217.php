<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanHarian;

class LaporanHarianController extends Controller
{
    public function index()
    {
        $laporans = LaporanHarian::with([
            'user',
            'kandang'
        ])
            ->latest('tanggal')
            ->get();

        return view(
            'admin.laporan.index',
            compact('laporans')
        );
    }

    public function show(LaporanHarian $laporan)
    {
        $laporan->load([
            'user',
            'kandang'
        ]);

        return view(
            'admin.laporan.show',
            compact('laporan')
        );
    }
}
