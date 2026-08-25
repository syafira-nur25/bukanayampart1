<?php

namespace App\Http\Controllers;

use App\Models\ArusKas;
use App\Models\PenjualanTelur;
use Illuminate\Http\Request;

class ArusKasController extends Controller
{
    public function index()
    {
        $rows = $this->buildRows();

        $totalPenerimaan  = $rows->sum('penerimaan');
        $totalPengeluaran = $rows->sum('pengeluaran');
        $saldoAkhir       = $totalPenerimaan - $totalPengeluaran;

        return view('arus_kas.index', compact(
            'rows', 'totalPenerimaan', 'totalPengeluaran', 'saldoAkhir'
        ));
    }

    public function create()
    {
        return view('arus_kas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'     => 'required|date',
            'keterangan'  => 'required|string|max:255',
            'nomor_bukti' => 'nullable|string|max:100',
            'jenis'       => 'required|in:masuk,keluar',
            'nominal'     => 'required|numeric|min:0',
        ]);

        ArusKas::create([
            'tanggal'     => $validated['tanggal'],
            'keterangan'  => $validated['keterangan'],
            'nomor_bukti' => $validated['nomor_bukti'] ?? null,
            'penerimaan'  => $validated['jenis'] === 'masuk' ? $validated['nominal'] : 0,
            'pengeluaran' => $validated['jenis'] === 'keluar' ? $validated['nominal'] : 0,
        ]);

        return redirect()->route('arus-kas.index')->with('success', 'Transaksi arus kas berhasil dicatat.');
    }

    public function edit(ArusKas $arusKas)
    {
        return view('arus_kas.edit', compact('arusKas'));
    }

    public function update(Request $request, ArusKas $arusKas)
    {
        $validated = $request->validate([
            'tanggal'     => 'required|date',
            'keterangan'  => 'required|string|max:255',
            'nomor_bukti' => 'nullable|string|max:100',
            'jenis'       => 'required|in:masuk,keluar',
            'nominal'     => 'required|numeric|min:0',
        ]);

        $arusKas->update([
            'tanggal'     => $validated['tanggal'],
            'keterangan'  => $validated['keterangan'],
            'nomor_bukti' => $validated['nomor_bukti'] ?? null,
            'penerimaan'  => $validated['jenis'] === 'masuk' ? $validated['nominal'] : 0,
            'pengeluaran' => $validated['jenis'] === 'keluar' ? $validated['nominal'] : 0,
        ]);

        return redirect()->route('arus-kas.index')->with('success', 'Arus kas berhasil diperbarui.');
    }

    public function destroy(ArusKas $arusKas)
    {
        $arusKas->delete();
        return redirect()->route('arus-kas.index')->with('success', 'Arus kas berhasil dihapus.');
    }

    public function exportExcel()
    {
        $rows = $this->buildRows();

        $totalPenerimaan  = $rows->sum('penerimaan');
        $totalPengeluaran = $rows->sum('pengeluaran');
        $saldoAkhir       = $totalPenerimaan - $totalPengeluaran;

        $html = view('arus_kas.export-excel', compact(
            'rows', 'totalPenerimaan', 'totalPengeluaran', 'saldoAkhir'
        ))->render();

        return response($html, 200, [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="arus-kas-' . now()->format('Ymd-His') . '.xls"',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ]);
    }

    /** Gabungkan transaksi manual + penerimaan otomatis dari penjualan telur */
    private function buildRows()
    {
        $rows = collect();

        // 1) Transaksi manual (pengeluaran / pemasukan lain spt modal)
        foreach (ArusKas::orderBy('tanggal')->orderBy('id')->get() as $r) {
            $rows->push([
                'tanggal'     => $r->tanggal,
                'keterangan'  => $r->keterangan,
                'nomor_bukti' => $r->nomor_bukti,
                'penerimaan'  => (float) $r->penerimaan,
                'pengeluaran' => (float) $r->pengeluaran,
                'sumber'      => 'manual',
                'ref_id'      => $r->id,
            ]);
        }

        // 2) Penerimaan OTOMATIS dari total penjualan telur
        foreach (PenjualanTelur::orderBy('tanggal')->orderBy('id')->get() as $p) {
            $rows->push([
                'tanggal'     => $p->tanggal,
                'keterangan'  => 'Penjualan telur — ' . $p->customer . ' (' . number_format($p->jumlah) . ' ikat)',
                'nomor_bukti' => null,
                'penerimaan'  => (float) $p->total,
                'pengeluaran' => 0,
                'sumber'      => 'otomatis',
                'ref_id'      => $p->id,
            ]);
        }

        // urutkan: tanggal → manual dulu → id
        $rows = $rows->sortBy(fn ($r) => [
            $r['tanggal']->toDateString(),
            $r['sumber'] === 'manual' ? 0 : 1,
            $r['ref_id'],
        ])->values();

        // saldo berjalan
        $saldo = 0;
        return $rows->map(function ($r) use (&$saldo) {
            $saldo += $r['penerimaan'] - $r['pengeluaran'];
            $r['saldo'] = $saldo;
            return $r;
        });
    }
}
