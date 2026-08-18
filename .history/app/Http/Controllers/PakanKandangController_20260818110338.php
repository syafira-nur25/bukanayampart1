<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\PakanKandang;
use Illuminate\Http\Request;

class PakanKandangController extends Controller
{
    public function index()
    {
        return view('pakan_kandang.index', [
            'pakans' => PakanKandang::with('kandang')->latest('tanggal')->orderBy('id')->get(),
            'stokKg' => PakanKandang::stokKg(),
        ]);
    }

    public function create()
    {
        return view('pakan_kandang.create', [
            'kandangs' => Kandang::orderBy('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $jenis = $request->input('jenis', 'keluar');

        if ($jenis === 'masuk') {
            $data = $request->validate([
                'tanggal'     => 'required|date',
                'total_masuk' => 'required|numeric|min:0.01',
            ]);
            $data['kandang_id'] = null;
            $data['keluar']     = 0;
        } else {
            $data = $request->validate([
                'tanggal'    => 'required|date',
                'kandang_id' => 'required|exists:kandang,id',
                'keluar'     => 'required|numeric|min:0.01',
            ]);

            if ((float) $data['keluar'] > PakanKandang::stokKg()) {
                return back()->withInput()->withErrors([
                    'keluar' => 'Pengambilan melebihi stok gudang (sisa ' . number_format(PakanKandang::stokKg(), 0) . ' Kg).',
                ]);
            }
            $data['total_masuk'] = 0;
        }

        PakanKandang::create($data);

        return redirect()->route('pakan-kandang.index')->with('success', 'Catatan pakan berhasil ditambahkan.');
    }

    public function show(PakanKandang $pakanKandang)
    {
        return view('pakan_kandang.show', [
            'pakanKandang' => $pakanKandang->load('kandang'),
            'stokKg'       => PakanKandang::stokKg(),
        ]);
    }

    public function edit(PakanKandang $pakanKandang)
    {
        return view('pakan_kandang.edit', [
            'pakanKandang' => $pakanKandang,
            'kandangs'     => Kandang::orderBy('id')->get(),
        ]);
    }

    public function update(Request $request, PakanKandang $pakanKandang)
    {
        $jenis = $request->input('jenis', 'keluar');

        if ($jenis === 'masuk') {
            $data = $request->validate([
                'tanggal'     => 'required|date',
                'total_masuk' => 'required|numeric|min:0.01',
            ]);
            $data['kandang_id'] = null;
            $data['keluar']     = 0;
        } else {
            $data = $request->validate([
                'tanggal'    => 'required|date',
                'kandang_id' => 'required|exists:kandang,id',
                'keluar'     => 'required|numeric|min:0.01',
            ]);

            $stokTanpaBarisIni = PakanKandang::stokKg() - $pakanKandang->kontribusiKg();

            if ((float) $data['keluar'] > $stokTanpaBarisIni) {
                return back()->withInput()->withErrors([
                    'keluar' => 'Pengambilan melebihi stok gudang (sisa ' . number_format($stokTanpaBarisIni, 0) . ' Kg).',
                ]);
            }
            $data['total_masuk'] = 0;
        }

        $pakanKandang->update($data);

        return redirect()->route('pakan-kandang.index')->with('success', 'Data pakan berhasil diperbarui.');
    }

    public function destroy(PakanKandang $pakanKandang)
    {
        $pakanKandang->delete();

        return redirect()->route('pakan-kandang.index')->with('success', 'Data pakan berhasil dihapus.');
    }

    /** Laporan sesuai layout: No | Tanggal | Total Masuk (zak) | Keluar per kandang | Sisa */
       /** Halaman laporan pakan */
    public function laporan()
    {
        [$laporan, $kandangs] = $this->dataLaporan();

        return view('pakan_kandang.laporan', compact('laporan', 'kandangs'));
    }

    /** BARU: export laporan pakan ke Excel (.xls) */
    public function exportExcel()
    {
        [$laporan, $kandangs] = $this->dataLaporan();

        $html = view('pakan_kandang.export-excel', compact('laporan', 'kandangs'))->render();

        return response($html, 200, [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="laporan-pakan-' . now()->format('Ymd-His') . '.xls"',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ]);
    }

    /** BARU: menyusun data laporan (dipakai halaman laporan & export) */
    private function dataLaporan(): array
    {
        $kandangs   = Kandang::orderBy('id')->get();
        $perTanggal = PakanKandang::orderBy('tanggal')->orderBy('id')->get()
            ->groupBy(fn ($r) => $r->tanggal->toDateString());

        $laporan = [];
        $saldoKg = 0;

        foreach ($perTanggal as $tanggal => $items) {
            $masukZak = (float) $items->sum('total_masuk');
            $saldoKg += $masukZak * PakanKandang::ZAK_KE_KG;

            $keluarPerKandang = [];
            foreach ($items->whereNotNull('kandang_id') as $item) {
                $keluarPerKandang[$item->kandang_id] =
                    ($keluarPerKandang[$item->kandang_id] ?? 0) + (float) $item->keluar;
            }

            $saldoKg -= array_sum($keluarPerKandang);

            $laporan[] = [
                'tanggal'     => $tanggal,
                'total_masuk' => $masukZak,
                'keluar'      => $keluarPerKandang,
                'sisa_kg'     => $saldoKg,
                'sisa_zak'    => $saldoKg / PakanKandang::ZAK_KE_KG,
            ];
        }

        return [$laporan, $kandangs];
    }
}
