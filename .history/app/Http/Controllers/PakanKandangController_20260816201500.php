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
            'pakans' => PakanKandang::with('kandang')->orderByDesc('tanggal')->orderBy('id')->get(),
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
            $data['id_kandang'] = null;
            $data['keluar']     = 0;
        } else {
            $data = $request->validate([
                'tanggal'    => 'required|date',
                'id_kandang' => 'required|exists:kandang,id',
                'keluar'     => 'required|numeric|min:0.01',
            ]);

            if ((float) $data['keluar'] > PakanKandang::stokKg()) {
                return back()->withInput()->withErrors([
                    'keluar' => 'Melebihi stok gudang (sisa ' . number_format(PakanKandang::stokKg(), 0) . ' kg).',
                ]);
            }
            $data['total_masuk'] = 0;
        }

        PakanKandang::create($data);

        return redirect()->route('pakan-kandang.index')->with('success', 'Catatan pakan tersimpan.');
    }

    public function show(PakanKandang $pakanKandang)
    {
        return view('pakan_kandang.show', [
            'pakan'  => $pakanKandang->load('kandang'),
            'stokKg' => PakanKandang::stokKg(),
        ]);
    }

    public function edit(PakanKandang $pakanKandang)
    {
        return view('pakan_kandang.edit', [
            'pakan'    => $pakanKandang,
            'kandangs' => Kandang::orderBy('id')->get(),
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
            $data['id_kandang'] = null;
            $data['keluar']     = 0;
        } else {
            $data = $request->validate([
                'tanggal'    => 'required|date',
                'id_kandang' => 'required|exists:kandang,id',
                'keluar'     => 'required|numeric|min:0.01',
            ]);

            // stok gudang TANPA menghitung baris yang sedang diedit
            $stokTanpaBarisIni = PakanKandang::stokKg() - $pakanKandang->kontribusiKg();

            if ((float) $data['keluar'] > $stokTanpaBarisIni) {
                return back()->withInput()->withErrors([
                    'keluar' => 'Melebihi stok gudang (sisa ' . number_format($stokTanpaBarisIni, 0) . ' kg).',
                ]);
            }
            $data['total_masuk'] = 0;
        }

        $pakanKandang->update($data);

        return redirect()->route('pakan-kandang.index')->with('success', 'Catatan pakan diperbarui.');
    }

    public function destroy(PakanKandang $pakanKandang)
    {
        $pakanKandang->delete();
        return redirect()->route('pakan-kandang.index')->with('success', 'Catatan pakan dihapus.');
    }

    /** Laporan: No | Tanggal | Total Masuk (zak) | Keluar per kandang | Sisa */
    public function laporan()
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
            foreach ($items->whereNotNull('id_kandang') as $item) {
                $keluarPerKandang[$item->id_kandang] =
                    ($keluarPerKandang[$item->id_kandang] ?? 0) + (float) $item->keluar;
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

        return view('pakan_kandang.laporan', compact('laporan', 'kandangs'));
    }
}
