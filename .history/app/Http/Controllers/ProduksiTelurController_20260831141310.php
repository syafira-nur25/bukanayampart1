<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Populasi;
use App\Models\ProduksiTelur;
use App\Models\GudangTelur;
use Illuminate\Http\Request;

class ProduksiTelurController extends Controller
{
    public function index()
    {
        $kandangs = Kandang::orderBy('id')->get();

        $records = ProduksiTelur::orderBy('tanggal')->orderBy('id')->get()
            ->groupBy(fn ($r) => $r->tanggal->toDateString());

        $rows = [];
        foreach ($records as $tanggal => $items) {
            $row = [
                'tanggal'       => $tanggal,
                'items'         => $items,
                'perKandang'    => [],
                'totalPopulasi' => 0,
                'totalProduksi' => 0,
            ];
            foreach ($kandangs as $kandang) {
                $item = $items->firstWhere('kandang_id', $kandang->id);
                $pop  = $item ? (int) $item->sisa_ayam : 0;
                $prod = $item ? (int) $item->jumlah_produksi : 0;
                $row['perKandang'][$kandang->id] = [
                    'item'        => $item,
                    'populasi'    => $pop,
                    'produksi'    => $prod,
                    'telurBagus'  => $item ? (int) $item->telur_bagus : 0,
                    'telurReject' => $item ? (int) $item->telur_reject : 0,
                    'persentase'  => $pop > 0 ? round($prod / $pop * 100, 2) : 0,
                ];
                $row['totalPopulasi'] += $pop;
                $row['totalProduksi'] += $prod;
            }
            $row['totalPersentase'] = $row['totalPopulasi'] > 0
                ? round($row['totalProduksi'] / $row['totalPopulasi'] * 100, 2)
                : 0;
            $rows[] = $row;
        }

        $perBulan = collect($rows)
            ->groupBy(fn ($r) => substr($r['tanggal'], 0, 7))
            ->map(fn ($bulanRows) => [
                'rows'  => $bulanRows->reverse()->values(),
                'total' => $bulanRows->sum('totalProduksi'),
            ])
            ->sortKeysDesc();

        $totalProduksi = (int) ProduksiTelur::sum('jumlah_produksi');
        $totalBagus    = (int) ProduksiTelur::sum('telur_bagus');
        $totalReject   = (int) ProduksiTelur::sum('telur_reject');
        $sumSisa       = (int) ProduksiTelur::where('sisa_ayam', '>', 0)->sum('sisa_ayam');
        $rataHdp       = $sumSisa > 0 ? round($totalProduksi / $sumSisa * 100, 2) : 0;

        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return view('produksi_telur.index', compact(
            'kandangs', 'perBulan', 'namaBulan',
            'totalProduksi', 'totalBagus', 'totalReject', 'rataHdp'
        ));
    }

    public function create()
    {
        return view('produksi_telur.create', [
            'kandangs'     => Kandang::orderBy('id')->get(),
            'populisis'    => Populasi::with('kandang')->latest('tanggal')->get(),
            'sisaPopulasi' => Populasi::pluck('sisa', 'id'),
            'gudangs'      => GudangTelur::orderBy('id')->get(), // ✅ TAMBAHAN
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'         => 'required|date',
            'kandang_id'      => 'required|exists:kandang,id',
            'populasi_id'     => 'required|exists:populasi,id',
            'gudang_id'       => 'nullable|exists:gudang_telur,id', // ✅ TAMBAHAN
            'jumlah_produksi' => 'required|integer|min:0',
            'telur_bagus'     => 'required|integer|min:0',
            'telur_reject'    => 'required|integer|min:0',
            'mati'            => 'required|integer|min:0',
            'afkir'           => 'required|integer|min:0',
        ]);

        $populasi = Populasi::findOrFail($validated['populasi_id']);

        $validated['sisa_ayam']  = (int) $populasi->sisa;
        $validated['presentase'] = $populasi->sisa > 0
            ? round($validated['jumlah_produksi'] / $populasi->sisa * 100, 2)
            : 0;

        ProduksiTelur::create($validated);

        return redirect()->route('produksi-telur.index')
            ->with('success', 'Produksi telur berhasil ditambahkan.');
    }

    public function show(ProduksiTelur $produksiTelur)
    {
        $produksiTelur->load(['kandang', 'populasi', 'penjualanTelur', 'gudang']);

        return view('produksi_telur.show', compact('produksiTelur'));
    }

    public function edit(ProduksiTelur $produksiTelur)
    {
        return view('produksi_telur.edit', [
            'produksiTelur' => $produksiTelur,
            'kandangs'      => Kandang::orderBy('id')->get(),
            'populisis'     => Populasi::with('kandang')->latest('tanggal')->get(),
            'sisaPopulasi'  => Populasi::pluck('sisa', 'id'),
            'gudangs'       => GudangTelur::orderBy('id')->get(), // ✅ TAMBAHAN
        ]);
    }

    public function update(Request $request, ProduksiTelur $produksiTelur)
    {
        $validated = $request->validate([
            'tanggal'         => 'required|date',
            'kandang_id'      => 'required|exists:kandang,id',
            'populasi_id'     => 'required|exists:populasi,id',
            'gudang_id'       => 'nullable|exists:gudang_telur,id', // ✅ TAMBAHAN
            'jumlah_produksi' => 'required|integer|min:0',
            'telur_bagus'     => 'required|integer|min:0',
            'telur_reject'    => 'required|integer|min:0',
            'mati'            => 'required|integer|min:0',
            'afkir'           => 'required|integer|min:0',
        ]);

        $populasi = Populasi::findOrFail($validated['populasi_id']);

        $validated['sisa_ayam']  = (int) $populasi->sisa;
        $validated['presentase'] = $populasi->sisa > 0
            ? round($validated['jumlah_produksi'] / $populasi->sisa * 100, 2)
            : 0;

        $produksiTelur->update($validated);

        return redirect()->route('produksi-telur.index')
            ->with('success', 'Produksi telur berhasil diperbarui.');
    }

    public function destroy(ProduksiTelur $produksiTelur)
    {
        $produksiTelur->delete();

        return redirect()->route('produksi-telur.index')
            ->with('success', 'Produksi telur berhasil dihapus.');
    }
}
