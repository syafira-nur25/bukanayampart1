<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Populasi;
use App\Models\ProduksiTelur;
use Illuminate\Http\Request;

class ProduksiTelurController extends Controller
{
    /** Laporan pivot per tanggal (sesuai spreadsheet) */
    public function index()
    {
        $kandangs = Kandang::orderBy('id')->get();

        $perTanggal = ProduksiTelur::orderBy('tanggal')->orderBy('id')->get()
            ->groupBy(fn ($r) => $r->tanggal->toDateString());

        $laporan = [];
        foreach ($perTanggal as $tanggal => $items) {
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
                    'populasi'   => $pop,
                    'produksi'   => $prod,
                    'persentase' => $pop > 0 ? round($prod / $pop * 100, 2) : 0,
                ];

                $row['totalPopulasi'] += $pop;
                $row['totalProduksi'] += $prod;
            }

            $row['totalPersentase'] = $row['totalPopulasi'] > 0
                ? round($row['totalProduksi'] / $row['totalPopulasi'] * 100, 2)
                : 0;

            $laporan[] = $row;
        }

        return view('produksi_telur.index', compact('kandangs', 'laporan'));
    }

    public function create()
    {
        return view('produksi_telur.create', [
            'kandangs'     => Kandang::orderBy('id')->get(),
            'populisis'    => Populasi::with('kandang')->latest('tanggal')->get(),
            'sisaPopulasi' => Populasi::pluck('sisa', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'         => 'required|date',
            'kandang_id'      => 'required|exists:kandang,id',
            'populasi_id'     => 'required|exists:populasi,id',
            'jumlah_produksi' => 'required|integer|min:0',
            'telur_bagus'     => 'required|integer|min:0',
            'telur_reject'    => 'required|integer|min:0',
            'mati'            => 'required|integer|min:0',
            'afkir'           => 'required|integer|min:0',
        ]);

        // SISA & PERSENTASE otomatis dari populasi yang dipilih
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
        $produksiTelur->load(['kandang', 'populasi', 'penjualanTelur']);

        return view('produksi_telur.show', compact('produksiTelur'));
    }

    public function edit(ProduksiTelur $produksiTelur)
    {
        return view('produksi_telur.edit', [
            'produksiTelur' => $produksiTelur,
            'kandangs'      => Kandang::orderBy('id')->get(),
            'populisis'     => Populasi::with('kandang')->latest('tanggal')->get(),
            'sisaPopulasi'  => Populasi::pluck('sisa', 'id'),
        ]);
    }

    public function update(Request $request, ProduksiTelur $produksiTelur)
    {
        $validated = $request->validate([
            'tanggal'         => 'required|date',
            'kandang_id'      => 'required|exists:kandang,id',
            'populasi_id'     => 'required|exists:populasi,id',
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
