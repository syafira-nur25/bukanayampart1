@extends('layouts.app')

@section('title', 'Bobot Ayam')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Data Bobot Ayam</h2>
    <a href="{{ route('bobot.create') }}" class="btn btn-primary">+ Catat Bobot</a>
</div>

<style>
    .sample-cell { min-width: 110px; font-size: 12px; }
    .sample-item {
        display: flex; justify-content: space-between; align-items: center;
        padding: 2px 6px; margin-bottom: 2px;
        background: #fff8ef; border-radius: 6px; border: 1px solid var(--border);
    }
    .sample-item .idx { font-weight: 700; color: var(--primary); }
    .sample-avg {
        font-weight: 700; color: var(--primary-dark);
        padding: 4px 6px; margin-top: 3px; border-top: 1px dashed var(--border);
        font-size: 12px;
    }
    .sample-empty { color: #b9a797; font-style: italic; }
</style>

<!-- RESUME -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Total Bobot (terbaru)</div>
                    <div class="stat-value">{{ number_format($totalBobot) }} g</div>
                </div>
                <div class="stat-icon icon-green"><i class="bi bi-speedometer2"></i></div>
            </div>
            <div class="stat-description">
                ≈ {{ number_format($totalBobot / 1000, 2) }} kg — jumlah rata-rata bobot terbaru tiap kandang
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Rata-rata Bobot</div>
                    <div class="stat-value">{{ number_format($rataRata) }} g</div>
                </div>
                <div class="stat-icon icon-blue"><i class="bi bi-graph-up"></i></div>
            </div>
            <div class="stat-description">
                ≈ {{ number_format($rataRata / 1000, 2) }} kg per ekor (rata-rata dari rata-rata kandang)
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Kandang Terdata</div>
                    <div class="stat-value">{{ $kandangs->count() }}</div>
                </div>
                <div class="stat-icon icon-yellow"><i class="bi bi-house-door-fill"></i></div>
            </div>
            <div class="stat-description">{{ $tanggals->count() }} tanggal penimbangan tercatat</div>
        </div>
    </div>
</div>

<!-- TABEL PIVOT -->
<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Kandang</th>
                        @foreach ($tanggals as $t)
                            <th>{{ $t->tanggal->format('d M Y') }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $i => $row)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td class="fw-bold">{{ $row['kandang']->nama }}</td>
                            @foreach ($tanggals as $t)
                                @php $list = $row['map']->get($t->tanggal->toDateString()); @endphp
                                <td class="sample-cell">
                                    @if ($list && $list->count())
                                        @foreach ($list as $idx => $b)
                                            <div class="sample-item">
                                                <span class="idx">#{{ $idx + 1 }}</span>
                                                <span>{{ number_format($b->bobot) }} g</span>
                                            </div>
                                        @endforeach
                                        <div class="sample-avg">
                                            Rata: {{ number_format(round($list->avg('bobot'))) }} g
                                        </div>
                                    @else
                                        <span class="sample-empty">-</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 2 + $tanggals->count() }}" class="text-center py-4">
                                Belum ada data bobot.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($tanggals->count() > 0)
                <tfoot>
                    <tr class="table-active fw-bold text-center">
                        <td colspan="2" class="text-end">TOTAL</td>
                        @foreach ($tanggals as $t)
                            <td>{{ number_format($perTanggal[$t->tanggal->toDateString()]['total']) }} g</td>
                        @endforeach
                    </tr>
                    <tr class="table-active fw-bold text-center">
                        <td colspan="2" class="text-end">RATA-RATA</td>
                        @foreach ($tanggals as $t)
                            <td>{{ number_format($perTanggal[$t->tanggal->toDateString()]['rata']) }} g</td>
                        @endforeach
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

<!-- RIWAYAT -->
<div class="card">
    <div class="card-body">
        <div class="panel-title mb-3">Riwayat Sampel Bobot</div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kandang</th>
                        <th>Bobot (gram)</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayat as $r)
                        <tr>
                            <td>{{ $r->tanggal->format('d-m-Y') }}</td>
                            <td>{{ $r->kandang->nama ?? '-' }}</td>
                            <td class="fw-bold">{{ number_format($r->bobot) }} g</td>
                            <td>
                                <a href="{{ route('bobot.edit', $r) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('bobot.destroy', $r) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus sampel bobot ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">Belum ada riwayat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
