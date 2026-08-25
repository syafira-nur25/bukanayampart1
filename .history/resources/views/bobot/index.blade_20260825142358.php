@extends('layouts.app')

@section('title', 'Bobot Ayam')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Data Bobot Ayam</h2>
    <a href="{{ route('bobot.create') }}" class="btn btn-primary">+ Catat Bobot</a>
</div>

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
            <div class="stat-description">≈ {{ number_format($totalBobot / 1000, 2) }} kg — penjumlahan bobot terbaru tiap kandang</div>
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
            <div class="stat-description">≈ {{ number_format($rataRata / 1000, 2) }} kg per ekor (rata-rata bobot terbaru)</div>
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

<!-- TABEL PIVOT (seperti spreadsheet) -->
<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
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
                            <td>{{ $i + 1 }}</td>
                            <td class="fw-bold">{{ $row['kandang']->nama }}</td>
                            @foreach ($tanggals as $t)
                                @php $b = $row['map']->get($t->tanggal->toDateString()); @endphp
                                <td>{{ $b ? number_format($b->bobot) : '-' }}</td>
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
                    <tr class="table-active fw-bold">
                        <td colspan="2" class="text-end">TOTAL</td>
                        @foreach ($tanggals as $t)
                            <td>{{ number_format($perTanggal[$t->tanggal->toDateString()]['total']) }}</td>
                        @endforeach
                    </tr>
                    <tr class="table-active fw-bold">
                        <td colspan="2" class="text-end">RATA-RATA</td>
                        @foreach ($tanggals as $t)
                            <td>{{ number_format($perTanggal[$t->tanggal->toDateString()]['rata']) }}</td>
                        @endforeach
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

<!-- RIWAYAT (untuk edit / hapus) -->
<div class="card">
    <div class="card-body">
        <div class="panel-title mb-3">Riwayat Input Bobot</div>
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
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data bobot?')">Hapus</button>
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
