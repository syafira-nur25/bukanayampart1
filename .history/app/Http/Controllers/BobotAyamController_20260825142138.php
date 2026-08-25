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

        $semua = BobotAyam::all()->groupBy('kandang_id');

        $rows = [];
        foreach ($kandangs as $kandang) {
            $punya = $semua->get($kandang->id, collect());
            $rows[] = [
                'kandang' => $kandang,
                'map'     => $punya->keyBy(fn ($b) => $b->tanggal->toDateString()),
                'terbaru' => $punya->sortBy('tanggal')->last(),
            ];
        }

        // ===== RESUME: total & rata-rata dari bobot terbaru tiap kandang =====
        $latest = collect($rows)
            ->filter(fn ($r) => $r['terbaru'] !== null)
            ->map(fn ($r) => (int) $r['terbaru']->bobot);

        $totalBobot = $latest->sum();
        $rataRata   = $latest->count() ? round($latest->avg(), 0) : 0;

        // ===== Total & rata-rata per kolom tanggal (untuk footer tabel) =====
        $perTanggal = [];
        foreach ($tanggals as $t) {
            $key = $t->tanggal->toDateString();
            $values = collect($rows)
                ->map(fn ($r) => optional($r['map']->get($key))->bobot)
                ->filter(fn ($v) => $v !== null);
            $perTanggal[$key] = [
                'total' => $values->sum(),
                'rata'  => $values->count() ? round($values->avg(), 0) : 0,
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

        // 1 kandang 1 tanggal → kalau sudah ada, di-update
        BobotAyam::updateOrCreate(
            ['kandang_id' => $validated['kandang_id'], 'tanggal' => $validated['tanggal']],
            ['bobot' => $validated['bobot']]
        );

        return redirect()->route('bobot.index')->with('success', 'Data bobot berhasil disimpan.');
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
        return redirect()->route('bobot.index')->with('success', 'Data bobot berhasil dihapus.');
    }
}
