<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanHarian;
use App\Models\Kandang;
use Illuminate\Http\Request;

class LaporanHarianController extends Controller
{
    public function index(Request $request)
    {
        $query = LaporanHarian::with([
            'kandang',
            'user',
        ])
        ->latest('tanggal');

        if ($request->filled('tanggal')) {
            $query->whereDate(
                'tanggal',
                $request->tanggal
            );
        }

        if ($request->filled('kandang_id')) {
            $query->where(
                'kandang_id',
                $request->kandang_id
            );
        }

        $laporan = $query->paginate(20);

        $kandangs = Kandang::orderBy('nama')->get();

        return view(
            'admin.laporan.index',
            compact(
                'laporan',
                'kandangs'
            )
        );
    }
}
