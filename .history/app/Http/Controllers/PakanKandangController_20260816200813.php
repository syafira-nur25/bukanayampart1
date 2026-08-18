<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\PakanKandang;
use Illuminate\Http\Request;

class PakanKandangController extends Controller
{
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
            // Pakan masuk gudang → id_kandang NULL, isi total_masuk (zak)
            $data = $request->validate([
                'tanggal'     => 'required|date',
                'total_masuk' => 'required|numeric|min:0.01',
            ]);
            $data['id_kandang'] = null;
            $data['keluar']     = 0;
        } else {
            // Kandang ambil pakan → isi keluar (kg)
            $data = $request->validate([
                'tanggal'    => 'required|date',
                'id_kandang' => 'required|exists:kandang,id',
                'keluar'     => 'required|numeric|min:0.01',
            ]);

            // Cegah ambil melebihi stok gudang
            if ((float) $data['keluar'] > PakanKandang::stokKg()) {
                return back()->withInput()->withErrors([
                    'keluar' => 'Melebihi stok gudang (sisa ' . PakanKandang::stokKg() . ' kg).',
                ]);
            }
            $data['total_masuk'] = 0;
        }

        PakanKandang::create($data);

        return redirect()->route('pakan-kandang.create')->with('success', 'Catatan pakan tersimpan.');
    }

    /** Laporan: No | Tanggal | Total Masuk (zak) | Keluar per kandang | Sisa */
    public function laporan()
    {
        $kandangs   = Kandang::orderBy('id')->get();
        $perTanggal = PakanKandang::orderBy('tanggal')->get()
            ->groupBy(fn ($r) => $r->tanggal->toDateString());

        $laporan = [];
        $saldoKg = 0;

        foreach ($perTanggal as $tanggal => $items) {
            // 1) Total masuk hari ini (zak) → tambah saldo gudang
            $masukZak = (float) $items->sum('total_masuk');
            $saldoKg += $masukZak * PakanKandang::ZAK_KE_KG;

            // 2) Pivot keluar per kandang (kolom kandang 1, kandang 2, ...)
            $keluarPerKandang = [];
            foreach ($items->whereNotNull('id_kandang') as $item) {
                $keluarPerKandang[$item->id_kandang] =
                    ($keluarPerKandang[$item->id_kandang] ?? 0) + (float) $item->keluar;
            }

            // 3) Kurangi saldo gudang dengan total keluar hari ini
            $saldoKg -= array_sum($keluarPerKandang);

            $laporan[] = [
                'tanggal'     => $tanggal,
                'total_masuk' => $masukZak,
                'keluar'      => $keluarPerKandang,
                'sisa_kg'     => $saldoKg,
                'sisa_zak'    => $saldoKg / PakanKandang::ZAK_KE_KG,
            ];
        }

        return view('pakan_kandang.laporan', compact('laporan', 'kandangs'));
    }
}
