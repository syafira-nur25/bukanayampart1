@extends('layouts.app')

@section('title', 'Arus Kas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="mb-0">Arus Kas</h2>
        <small class="text-muted">Cluster Ayam Petelur — Desa Tanjung Agung</small>
    </div>
    <div>
        <a href="{{ route('arus-kas.export') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel-fill me-1"></i> Export Excel
        </a>
        <a href="{{ route('arus-kas.create') }}" class="btn btn-primary">+ Catat Transaksi</a>
    </div>
</div>

<!-- RINGKASAN -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Total Penerimaan</div>
                    <div class="stat-value" style="font-size:20px;">Rp {{ number_format($totalPenerimaan, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon icon-green"><i class="bi bi-arrow-down-circle-fill"></i></div>
            </div>
            <div class="stat-description">Termasuk otomatis dari penjualan telur</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Total Pengeluaran</div>
                    <div class="stat-value" style="font-size:20px;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon icon-red"><i class="bi bi-arrow-up-circle-fill"></i></div>
            </div>
            <div class="stat-description">Pakan, listrik, operasional, dll (manual)</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Saldo Akhir</div>
                    <div class="stat-value" style="font-size:20px;">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon icon-blue"><i class="bi bi-wallet2"></i></div>
            </div>
            <div class="stat-description">Penerimaan − Pengeluaran</div>
        </div>
    </div>
</div>

<!-- TABEL -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="text-center">
                    <tr>
                        <th width="45">No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Nomor Bukti</th>
                        <th class="text-end">Penerimaan (Rp)</th>
                        <th class="text-end">Pengeluaran (Rp)</th>
                        <th class="text-end">Saldo</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $i => $r)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>{{ $r['tanggal']->format('d/m/Y') }}</td>
                            <td>
                                {{ $r['keterangan'] }}
                                @if ($r['sumber'] === 'otomatis')
                                    <span class="badge bg-info text-dark ms-1">otomatis</span>
                                @endif
                            </td>
                            <td>{{ $r['nomor_bukti'] ?? '-' }}</td>
                            <td class="text-end">
                                {{ $r['penerimaan'] > 0 ? 'Rp ' . number_format($r['penerimaan'], 0, ',', '.') : '-' }}
                            </td>
                            <td class="text-end">
                                {{ $r['pengeluaran'] > 0 ? 'Rp ' . number_format($r['pengeluaran'], 0, ',', '.') : '-' }}
                            </td>
                            <td class="text-end fw-bold">Rp {{ number_format($r['saldo'], 0, ',', '.') }}</td>
                            <td>
                                @if ($r['sumber'] === 'manual')
                                    <a href="{{ route('arus-kas.edit', $r['ref_id']) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('arus-kas.destroy', $r['ref_id']) }}" method="POST"
                                          class="d-inline" onsubmit="return confirm('Hapus transaksi ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                @else
                                    <a href="{{ route('penjualan-telur.index') }}" class="btn btn-sm btn-light">Lihat penjualan</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Belum ada transaksi arus kas.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($rows->count() > 0)
                <tfoot>
                    <tr class="table-active fw-bold">
                        <td colspan="4" class="text-end">TOTAL</td>
                        <td class="text-end">Rp {{ number_format($totalPenerimaan, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
