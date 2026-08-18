<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\LaporanHarian;
use App\Models\Populasi;
use App\Models\ProduksiTelur;
use Illuminate\Http\Request;

class ProduksiTelurController extends Controller
{
    /** Laporan pivot per tanggal (seperti spreadsheet) */
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
            'kandangs'        => Kandang::orderBy('id')->get(),
            'populasiKandang' => $this->populasiKandangMap(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'         => 'required|date',
            'kandang_id'      => 'required|exists:kandang,id',
            'jumlah_produksi' => 'required|integer|min:0',
        ]);

        // 1 kandang 1 catatan per tanggal
        $sudahAda = ProduksiTelur::where('kandang_id', $validated['kandang_id'])
            ->whereDate('tanggal', $validated['tanggal'])
            ->exists();

        if ($sudahAda) {
            return back()->withInput()->withErrors([
                'tanggal' => 'Produksi tanggal ini untuk kandang tersebut sudah ada.',
            ]);
        }

        $populasi = $this->populasiAcuan((int) $validated['kandang_id'], $validated['tanggal']);

        $validated['sisa_ayam']   = $populasi; // snapshot populasi
        $validated['presentase']  = $populasi > 0
            ? round($validated['jumlah_produksi'] / $populasi * 100, 2)
            : 0;
        $validated['populasi_id'] = Populasi::where('kandang_id', $validated['kandang_id'])
            ->orderByDesc('tanggal')->first()?->id;

        ProduksiTelur::create($validated);

        return redirect()->route('produksi-telur.index')
            ->with('success', 'Produksi telur berhasil ditambahkan.');
    }

    public function show(ProduksiTelur $produksiTelur)
    {
        return redirect()->route('produksi-telur.index');
    }

    public function edit(ProduksiTelur $produksiTelur)
    {
        return view('produksi_telur.edit', [
            'produksiTelur'   => $produksiTelur,
            'kandangs'        => Kandang::orderBy('id')->get(),
            'populasiKandang' => $this->populasiKandangMap(),
        ]);
    }

    public function update(Request $request, ProduksiTelur $produksiTelur)
    {
        $validated = $request->validate([
            'tanggal'         => 'required|date',
            'kandang_id'      => 'required|exists:kandang,id',
            'jumlah_produksi' => 'required|integer|min:0',
        ]);

        $dup = ProduksiTelur::where('kandang_id', $validated['kandang_id'])
            ->whereDate('tanggal', $validated['tanggal'])
            ->where('id', '!=', $produksiTelur->id)
            ->exists();

        if ($dup) {
            return back()->withInput()->withErrors([
                'tanggal' => 'Produksi tanggal ini untuk kandang tersebut sudah ada.',
            ]);
        }

        $populasi = $this->populasiAcuan((int) $validated['kandang_id'], $validated['tanggal']);

        $validated['sisa_ayam']   = $populasi;
        $validated['presentase']  = $populasi > 0
            ? round($validated['jumlah_produksi'] / $populasi * 100, 2)
            : 0;
        $validated['populasi_id'] = Populasi::where('kandang_id', $validated['kandang_id'])
            ->orderByDesc('tanggal')->first()?->id;

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

    /** Populasi acuan: sisa laporan harian terakhir, fallback tabel populasi */
    private function populasiAcuan(int $kandangId, string $tanggal): int
    {
        $laporan = LaporanHarian::where('kandang_id', $kandangId)
            ->whereDate('tanggal', '<=', $tanggal)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->first();

        if ($laporan) {
            return (int) $laporan->sisa_ayam;
        }

        $pop = Populasi::where('kandang_id', $kandangId)
            ->orderByDesc('tanggal')
            ->first();

        return $pop ? (int) $pop->sisa : 0;
    }

    private function populasiKandangMap(): array
    {
        $map = [];
        foreach (Kandang::orderBy('id')->get() as $kandang) {
            $map[$kandang->id] = $this->populasiAcuan($kandang->id, now()->toDateString());
        }
        return $map;
    }
}
