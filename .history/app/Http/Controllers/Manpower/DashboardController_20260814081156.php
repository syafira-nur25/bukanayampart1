<?php

namespace App\Http\Controllers\Manpower;

use App\Http\Controllers\Controller;
use App\Models\LaporanHarian;

class DashboardController extends Controller
{
    public function index()
    {
        $laporanSaya = LaporanHarian::where(
            'user_id',
            auth()->id()
        )
            ->latest('tanggal')
            ->get();

        return view(
            'manpower.dashboard',
            compact('laporanSaya')
        );
    }
}
