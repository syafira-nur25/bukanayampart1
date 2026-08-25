<?php

namespace App\Http\Controllers;

use App\Models\ArusKas;
use App\Models\PenjualanTelur;
use Illuminate\Http\Request;

class ArusKasController extends Controller
{
    public function index()
    {
        [$rows, $totalPenerimaan, $totalPengeluaran] = $this->buildRows();

        return view('arus_kas.index', compact('rows', 'totalPenerimaan', 'totalPengeluaran'));
    }

    public function create()
    {
        return view('arus_kas.create');
    }

    public function store(Request $request)
    {
        ArusKas::create($this->normalize($request));

        return redirect()->route('arus-kas.index')->with('success', 'Transaksi arus kas berhasil dicatat.');
    }

    public function edit(ArusKas $arusKas)
    {
        return view('arus_kas.edit', compact('arusKas'));
    }

    public function update(Request $request, ArusKas $arusKas)
    {
        $arusKas->update($this->normalize($request));

        return redirect()->route('arus-kas.index')->with('success', 'Transaksi arus kas berhasil diperbarui.');
    }

    public function destroy(ArusKas $arusKas)
    {
        $arusKas->delete();

        return redirect()->route('arus-kas.index')->with('success', 'Transaksi arus kas berhasil dihapus.');
    }

    public function exportExcel()
    {
        [$rows, $totalPenerimaan, $totalPengeluaran] = $this->buildRows();

        $html = view('arus_kas.export-excel', compact('rows', 'totalPenerimaan', 'totalPengeluaran'))->render();

        return response($html, 200, [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="arus-kas-' . now()->format('Ymd-His') . '.xls"',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ]);
    }

    /** Terima dua gaya form: jenis+nominal ATAU penerimaan+pengeluaran langsung */
    private function normalize(Request $request): array
    {
        $validated = $request->validate([
            'tanggal'     => 'required|date',
            'keterangan'  => 'required|string|max:255',
            'nomor_bukti' => 'nullable|string|max:100',
            'jenis'       => 'nullable|in:masuk,keluar',
            'nominal'     => 'nullable|numeric|min:0',
            'penerimaan'  => 'nullable|numeric|min:0',
            'pengeluaran' => 'nullable|numeric|min:0',
        ]);

        if (!empty($validated['jenis'])) {
            $penerimaan  = $validated['jenis'] === 'masuk'  ? (float) ($validated['nominal'] ?? 0) : 0;
            $pengeluaran = $validated['jenis'] === 'keluar' ? (float) ($validated['nominal'] ?? 0) : 0;
        } else {
            $penerimaan  = (float) ($validated['penerimaan'] ?? 0);
            $pengeluaran = (float) ($validated['pengeluaran'] ?? 0);
        }

        return [
            'tanggal'     => $validated['tanggal'],
            'keterangan'  => $validated['keterangan'],
            'nomor_bukti' => $validated['nomor_bukti'] ?? null,
            'penerimaan'  => $penerimaan,
            'pengeluaran' => $pengeluaran,
        ];
    }

    /** Gabungkan transaksi manual + penerimaan otomatis dari penjualan telur */
    private function buildRows(): array
    {
        $rows = collect();

        foreach (ArusKas::orderBy('tanggal')->orderBy('id')->get() as $r) {
            $rows->push([
                'id'          => $r->id,               // selalu ada
                'tanggal'     => $r->tanggal,
                'keterangan'  => $r->keterangan,
                'nomor_bukti' => $r->nomor_bukti,
                'penerimaan'  => (float) $r->penerimaan,
                'pengeluaran' => (float) $r->pengeluaran,
                'sumber'      => 'manual',
            ]);
        }

        foreach (PenjualanTelur::orderBy('tanggal')->orderBy('id')->get() as $p) {
            $rows->push([
                'id'          => null,                 // otomatis → tidak bisa diedit di sini
                'tanggal'     => $p->tanggal,
                'keterangan'  => 'Penjualan telur — ' . $p->customer,
                'nomor_bukti' => null,
                'penerimaan'  => (float) $p->total,
                'pengeluaran' => 0,
                'sumber'      => 'penjualan',
            ]);
        }

        $rows = $rows->sortBy(fn ($r) => $r['tanggal']->toDateString() . '|' . $r['sumber'])->values();

        $saldo = 0;
        $rows = $rows->map(function ($r) use (&$saldo) {
            $saldo += $r['penerimaan'] - $r['pengeluaran'];
            $r['saldo'] = $saldo;
            return $r;
        });

        return [$rows, $rows->sum('penerimaan'), $rows->sum('pengeluaran')];
    }
}
