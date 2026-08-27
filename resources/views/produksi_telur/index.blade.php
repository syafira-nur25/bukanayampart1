@extends('layouts.app')

@section('title', 'Produksi Telur')

@section('content')
@php
// Warna badge persentase (HDP) sesuai capaian
$kelasPersen = function ($p) {
    if ($p >= 70) return 'text-bg-success';
    if ($p >= 50) return 'text-bg-info';
    if ($p >= 30) return 'text-bg-warning';
    return 'text-bg-danger';
};
@endphp
<style>
.month-icon { width: 38px; height: 38px; border-radius: 10px; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
.prod-num { font-size: 14px; }
.prod-sub { font-size: 10.5px; color: var(--muted); }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Laporan Produksi Telur</h2>
        <p class="text-muted small mb-0">Dikelompokkan per bulan — persentase (HDP) berwarna sesuai capaian.</p>
    </div>
    <a href="{{ route('produksi-telur.create') }}" class="btn btn-primary">+ Tambah Produksi</a>
</div>

<!-- ===== RINGKASAN ===== -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Total Produksi</div>
                    <div class="stat-value">{{ number_format($totalProduksi) }}</div>
                </div>
                <div class="stat-icon icon-yellow"><i class="bi bi-egg-fill"></i></div>
            </div>
            <div class="stat-description">butir (seluruh periode)</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Rata-rata HDP</div>
                    <div class="stat-value">{{ number_format($rataHdp, 1) }}%</div>
                </div>
                <div class="stat-icon icon-blue"><i class="bi bi-percent"></i></div>
            </div>
            <div class="stat-description">produksi ÷ populasi × 100</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Telur Bagus</div>
                    <div class="stat-value">{{ number_format($totalBagus) }}</div>
                </div>
                <div class="stat-icon icon-green"><i class="bi bi-check-circle-fill"></i></div>
            </div>
            <div class="stat-description">butir layak jual</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Reject / Pecah</div>
                    <div class="stat-value">{{ number_format($totalReject) }}</div>
                </div>
                <div class="stat-icon icon-red"><i class="bi bi-x-circle-fill"></i></div>
            </div>
            <div class="stat-description">butir tidak layak jual</div>
        </div>
    </div>
</div>

<!-- ===== TABEL PER BULAN ===== -->
@forelse ($perBulan as $bulan => $data)
    @php [$tahun, $bln] = explode('-', $bulan); @endphp
    <div class="mb-4">
        <div class="d-flex align-items-center gap-2 mb-2">
            <div class="month-icon"><i class="bi bi-calendar3"></i></div>
            <div>
                <h6 class="mb-0 fw-bold">{{ $namaBulan[(int) $bln] ?? $bln }} {{ $tahun }}</h6>
                <small class="text-muted">Total produksi: {{ number_format($data['total']) }} butir</small>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead>
                            <tr>
                                <th class="text-start ps-3">Tanggal</th>
                                @foreach ($kandangs as $kandang)
                                    <th>{{ strtoupper($kandang->nama) }}<br><small class="text-muted fw-normal">produksi · HDP</small></th>
                                @endforeach
                                <th>Total<br><small class="text-muted fw-normal">produksi · HDP</small></th>
                                <th class="text-end pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['rows'] as $row)
                                <tr>
                                    <td class="text-start ps-3 fw-semibold">
                                        {{ \Illuminate\Support\Carbon::parse($row['tanggal'])->format('d M Y') }}
                                    </td>
                                    @foreach ($kandangs as $kandang)
                                        @php $c = $row['perKandang'][$kandang->id]; @endphp
                                        <td>
                                            @if ($c['item'])
                                                <div class="fw-bold prod-num">{{ number_format($c['produksi']) }}</div>
                                                <div class="prod-sub">B {{ number_format($c['telurBagus']) }} · R {{ number_format($c['telurReject']) }}</div>
                                                @if ($c['populasi'] > 0)
                                                    <span class="badge {{ $kelasPersen($c['persentase']) }}">{{ number_format($c['persentase'], 1) }}%</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td>
                                        <div class="fw-bold prod-num">{{ number_format($row['totalProduksi']) }}</div>
                                        @if ($row['totalPopulasi'] > 0)
                                            <span class="badge {{ $kelasPersen($row['totalPersentase']) }}">{{ number_format($row['totalPersentase'], 1) }}%</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-3">
                                        @foreach ($row['items'] as $item)
                                            <div class="d-inline-flex gap-1 mb-1">
                                                <a href="{{ route('produksi-telur.edit', $item) }}" class="btn btn-sm btn-warning"
                                                   title="Edit {{ $item->kandang->nama ?? '' }}">
                                                    <i class="bi bi-pencil"></i> {{ $item->kandang->nama ?? '' }}
                                                </a>
                                                <form action="{{ route('produksi-telur.destroy', $item) }}" method="POST"
                                                      onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-active fw-bold">
                                <td class="text-start ps-3">TOTAL {{ strtoupper($namaBulan[(int) $bln] ?? $bln) }}</td>
                                @foreach ($kandangs as $kandang)
                                    <td>{{ number_format($data['rows']->sum(fn ($r) => $r['perKandang'][$kandang->id]['produksi'])) }}</td>
                                @endforeach
                                <td>{{ number_format($data['total']) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="card">
        <div class="card-body text-center text-muted py-5">
            <i class="bi bi-egg fs-1 d-block mb-2"></i>
            Belum ada data produksi telur.
            <div class="mt-3">
                <a href="{{ route('produksi-telur.create') }}" class="btn btn-primary">+ Tambah Produksi</a>
            </div>
        </div>
    </div>
@endforelse
@endsection
