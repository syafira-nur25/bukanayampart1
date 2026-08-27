@extends('layouts.app')

@section('title', 'Data Populasi')

@section('content')
<style>
.month-header { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
.month-icon {
    width: 40px; height: 40px; border-radius: 12px;
    background: var(--primary); color: #fff;
    display: flex; align-items: center; justify-content: center; font-size: 18px;
}
.kandang-card { border: 1px solid var(--border); border-radius: 14px; overflow: hidden; }
.kandang-head {
    background: linear-gradient(135deg, #efe6d9, #f7f2ea);
    padding: 12px 16px; border-bottom: 1px solid var(--border);
    display: flex; justify-content: space-between; align-items: center;
    flex-wrap: wrap; gap: 8px;
}
.chip { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; }
.chip-sisa  { background: #e8d5bd; color: #5d4037; }
.chip-mati  { background: #f8d7da; color: #842029; }
.chip-afkir { background: #fff3cd; color: #997404; }
.chip-usia  { background: #cfe2ff; color: #084298; }
.pop-table th { font-size: 11px; }
.pop-table td { font-size: 12.5px; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Data Populasi</h2>
        <p class="text-muted small mb-0">Dikelompokkan per bulan & per kandang.</p>
    </div>
    <a href="{{ route('populasi.create') }}" class="btn btn-primary">+ Tambah Populasi</a>
</div>

@forelse ($perBulan as $bulan => $perKandang)
    @php
        [$tahun, $bln] = explode('-', $bulan);
        $labelBulan = ($namaBulan[(int) $bln] ?? $bln) . ' ' . $tahun;
        $totalCatatan = $perKandang->sum(fn ($i) => $i->count());
    @endphp

    <div class="mb-4">
        {{-- ===== HEADER BULAN ===== --}}
        <div class="month-header">
            <div class="month-icon"><i class="bi bi-calendar3"></i></div>
            <div>
                <h5 class="mb-0 fw-bold">{{ $labelBulan }}</h5>
                <small class="text-muted">{{ $totalCatatan }} catatan · {{ $perKandang->count() }} kandang</small>
            </div>
        </div>

        {{-- ===== KARTU PER KANDANG ===== --}}
        <div class="row g-3">
            @foreach ($perKandang as $kandangId => $items)
                @php
                    $latest     = $items->first(); // record terbaru bulan ini
                    $totalMati  = $items->sum('mati');
                    $totalAfkir = $items->sum('afkir');
                @endphp
                <div class="col-12 col-xl-6">
                    <div class="kandang-card h-100 bg-white">
                        <div class="kandang-head">
                            <div class="fw-bold">
                                <i class="bi bi-house-door-fill me-1" style="color:var(--primary)"></i>
                                {{ $latest->kandang->nama ?? 'Kandang #' . $kandangId }}
                            </div>
                            <div>
                                <span class="chip chip-sisa">Sisa {{ number_format($latest->sisa) }}</span>
                                <span class="chip chip-mati">Mati {{ number_format($totalMati) }}</span>
                                <span class="chip chip-afkir">Afkir {{ number_format($totalAfkir) }}</span>
                                <span class="chip chip-usia">{{ intdiv((int) $latest->usia, 7) }} mgg</span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover pop-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Hidup</th>
                                        <th>Mati</th>
                                        <th>Afkir</th>
                                        <th>Sisa</th>
                                        <th>Usia</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $p)
                                        <tr>
                                            <td>{{ $p->tanggal->format('d M Y') }}</td>
                                            <td>{{ number_format($p->hidup) }}</td>
                                            <td class="text-danger">{{ number_format($p->mati) }}</td>
                                            <td class="text-warning">{{ number_format($p->afkir) }}</td>
                                            <td class="fw-bold text-success">{{ number_format($p->sisa) }}</td>
                                            <td><span class="badge bg-warning text-dark">{{ intdiv((int) $p->usia, 7) }} mgg</span></td>
                                            <td class="text-end">
                                                <a href="{{ route('populasi.show', $p) }}" class="btn btn-sm btn-info" title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('populasi.edit', $p) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('populasi.destroy', $p) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@empty
    <div class="card">
        <div class="card-body text-center text-muted py-5">
            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
            Belum ada data populasi.
            <div class="mt-3">
                <a href="{{ route('populasi.create') }}" class="btn btn-primary">+ Tambah Populasi</a>
            </div>
        </div>
    </div>
@endforelse
@endsection
