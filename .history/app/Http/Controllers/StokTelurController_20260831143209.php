<?php

namespace App\Http\Controllers;

use App\Models\GudangTelur;
use App\Models\ReturnTelur;
use App\Models\ProduksiTelur;
use App\Models\PenjualanTelur;
use App\Models\StokMasukTelur;
use Illuminate\Http\Request;

class StokTelurController extends Controller
{
    public function index()
    {
        $gudangs = GudangTelur::orderBy('id')->get();
        $returns = ReturnTelur::with('gudang')->latest('tanggal')->latest('id')->get();

        // ✅ Telur masuk gabungan: dari PRODUKSI + dari STOK MANUAL
        $masukProduksi = ProduksiTelur::with('gudang')->whereNotNull('gudang_id')->get()
            ->map(fn ($m) => [
                'tanggal' => $m->tanggal,
                'gudang'  => $m->gudang->nama ?? '-',
                'jumlah'  => (int) $m->jumlah_produksi,
                'sumber'  => 'Produksi',
                'id'      => null,
            ]);

        $masukManual = StokMasukTelur::with('gudang')->get()
            ->map(fn ($m) => [
                'tanggal' => $m->tanggal,
                'gudang'  => $m->gudang->nama ?? '-',
                'jumlah'  => (int) $m->jumlah,
                'sumber'  => $m->keterangan ? 'Manual · ' . $m->keterangan : 'Manual',
                'id'      => $m->id,
            ]);

        $masukGabungan = $masukProduksi->merge($masukManual)
            ->sortByDesc('tanggal')->values()->take(20);

        $keluarTerbaru = PenjualanTelur::with('gudang')
            ->whereNotNull('gudang_id')->latest('tanggal')->latest('id')->limit(20)->get();

        return view('stok_telur.index', compact(
            'gudangs', 'returns', 'masukGabungan', 'keluarTerbaru'
        ));
    }

    /** ✅ Tambah stok manual langsung dari halaman stok */
    public function storeStok(Request $request)
    {
        $validated = $request->validate([
            'tanggal'    => 'required|date',
            'gudang_id'  => 'required|exists:gudang_telur,id',
            'jumlah'     => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        StokMasukTelur::create($validated);

        return redirect()->route('stok-telur.index')
            ->with('success', 'Stok gudang berhasil ditambahkan.');
    }

    public function destroyStok(StokMasukTelur $stokMasukTelur)
    {
        $stokMasukTelur->delete();
        return redirect()->route('stok-telur.index')
            ->with('success', 'Catatan stok manual berhasil dihapus.');
    }

    public function storeReturn(Request $request)
    {
        $validated = $request->validate([
            'tanggal'    => 'required|date',
            'gudang_id'  => 'required|exists:gudang_telur,id',
            'jumlah'     => 'required|integer|min:1',
            'alasan'     => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $gudang = GudangTelur::find($validated['gudang_id']);
        if ($validated['jumlah'] > $gudang->stokButir()) {
            return back()->withInput()->withErrors([
                'jumlah' => 'Return melebihi stok ' . $gudang->nama
                    . ' (stok: ' . number_format($gudang->stokButir()) . ' butir).',
            ]);
        }

        ReturnTelur::create($validated);
        return redirect()->route('stok-telur.index')->with('success', 'Return telur berhasil dicatat.');
    }

    public function destroyReturn(ReturnTelur $returnTelur)
    {
        $returnTelur->delete();
        return redirect()->route('stok-telur.index')->with('success', 'Data return berhasil dihapus.');
    }
}
