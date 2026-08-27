<?php

namespace App\Http\Controllers;

use App\Models\BobotAyam;
use App\Models\Kandang;
use Illuminate\Http\Request;

class BobotAyamController extends Controller
{
public function index()
    {
        $kandangs = Kandang::orderBy('id')->get();
        $tanggals = BobotAyam::select('tanggal')->distinct()->orderBy('tanggal')->get();

        // ✅ orderBy('id') + values() → key di-reset jadi 0,1,2...
        //    sehingga nomor sampel berurutan #1, #2, #3
        $grouped = BobotAyam::orderBy('tanggal')->orderBy('id')->get()
            ->groupBy('kandang_id')
            ->map(fn ($items) => $items
                ->groupBy(fn ($b) => $b->tanggal->toDateString())
                ->map(fn ($grup) => $grup->values()));

        $rows = [];
        foreach ($kandangs as $kandang) {
            $map = $grouped->get($kandang->id, collect());

            $tanggalTerbaru = $map->keys()->sort()->last();
            $sampelTerbaru  = $tanggalTerbaru ? $map->get($tanggalTerbaru) : collect();

            $rows[] = [
                'kandang'       => $kandang,
                'map'           => $map,
                'sampelTerbaru' => $sampelTerbaru,
                'rataTerbaru'   => $sampelTerbaru->count()
                    ? round($sampelTerbaru->avg('bobot'))
                    : null,
            ];
        }

        // Resume: total & rata-rata dari sampel terbaru tiap kandang
        $latestAvgs = collect($rows)
            ->filter(fn ($r) => $r['rataTerbaru'] !== null)
            ->pluck('rataTerbaru');
        $totalBobot = $latestAvgs->sum();
        $rataRata   = $latestAvgs->count() ? round($latestAvgs->avg()) : 0;

        // Per-tanggal: total & rata-rata per kolom
        $perTanggal = [];
        foreach ($tanggals as $t) {
            $key = $t->tanggal->toDateString();
            $rataPerKandang = collect($rows)
                ->map(function ($r) use ($key) {
                    $list = $r['map']->get($key);
                    return $list ? round($list->avg('bobot')) : null;
                })
                ->filter(fn ($v) => $v !== null);

            $perTanggal[$key] = [
                'total' => $rataPerKandang->sum(),
                'rata'  => $rataPerKandang->count() ? round($rataPerKandang->avg()) : 0,
            ];
        }

        $riwayat = BobotAyam::with('kandang')->latest('tanggal')->latest('id')->get();

        return view('bobot.index', compact(
            'kandangs', 'tanggals', 'rows', 'perTanggal',
            'totalBobot', 'rataRata', 'riwayat'
        ));
    }

    public function create()
    {
        return view('bobot.create', [
            'kandangs' => Kandang::orderBy('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kandang_id' => 'required|exists:kandang,id',
            'tanggal'    => 'required|date',
            'bobot'      => 'required|integer|min:0',
        ]);

        // create biasa — boleh banyak sampel per kandang+tanggal
        BobotAyam::create($validated);

        return redirect()->route('bobot.index')->with('success', 'Sampel bobot berhasil disimpan.');
    }

    public function edit(BobotAyam $bobot)
    {
        return view('bobot.edit', [
            'bobot'    => $bobot,
            'kandangs' => Kandang::orderBy('id')->get(),
        ]);
    }

    public function update(Request $request, BobotAyam $bobot)
    {
        $validated = $request->validate([
            'kandang_id' => 'required|exists:kandang,id',
            'tanggal'    => 'required|date',
            'bobot'      => 'required|integer|min:0',
        ]);

        $bobot->update($validated);

        return redirect()->route('bobot.index')->with('success', 'Data bobot berhasil diperbarui.');
    }

    public function destroy(BobotAyam $bobot)
    {
        $bobot->delete();
        return redirect()->route('bobot.index')->with('success', 'Sampel bobot berhasil dihapus.');
    }
}
