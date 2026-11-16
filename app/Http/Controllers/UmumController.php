<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Populasi;
use App\Models\ProduksiTelur;
use App\Models\PenjualanTelur;
use App\Models\PakanKandang;
use App\Models\LaporanHarian;

class UmumController extends Controller
{
    public function index()
    {
        $totalKandang = Kandang::count();
        $totalAyam = Populasi::orderByDesc('tanggal')->orderByDesc('id')
            ->get()->unique('kandang_id')->sum('sisa');
        $totalTelur = (int) ProduksiTelur::sum('jumlah_produksi');
        $totalPenjualan = (int) PenjualanTelur::sum('total');

        $produksiTerbaru = ProduksiTelur::with('kandang')->latest('tanggal')->latest('id')->limit(10)->get();
        $penjualanTerbaru = PenjualanTelur::latest('tanggal')->latest('id')->limit(10)->get();

        return view('umum.home', compact(
            'totalKandang', 'totalAyam', 'totalTelur', 'totalPenjualan',
            'produksiTerbaru', 'penjualanTerbaru'
        ));
    }

    public function populasi()
    {
        $populasis = Populasi::with('kandang')->latest('tanggal')->latest('id')->get();
        return view('umum.populasi', compact('populasis'));
    }

    public function produksi()
    {
        $produksis = ProduksiTelur::with('kandang')->latest('tanggal')->latest('id')->get();
        return view('umum.produksi', compact('produksis'));
    }

    public function penjualan()
    {
        $penjualans = PenjualanTelur::latest('tanggal')->latest('id')->get();
        return view('umum.penjualan', compact('penjualans'));
    }

    public function pakan()
    {
        $pakans = PakanKandang::with('kandang')->latest('tanggal')->latest('id')->get();
        $stokKg = PakanKandang::stokKg();
        return view('umum.pakan', compact('pakans', 'stokKg'));
    }

    public function laporan()
    {
        $laporans = LaporanHarian::with(['kandang', 'user'])->latest('tanggal')->latest('id')->get();
        return view('umum.laporan', compact('laporans'));
    }
}
