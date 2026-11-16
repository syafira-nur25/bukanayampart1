@extends('layouts.umum')
@section('title', 'Ringkasan Data')
@section('content')
<div class="row g-4 mb-4">
<div class="col-6 col-xl-3"><div class="stat-card"><div class="stat-label">Total Kandang</div><div class="stat-value">{{ $totalKandang }}</div></div></div>
<div class="col-6 col-xl-3"><div class="stat-card"><div class="stat-label">Populasi Ayam</div><div class="stat-value">{{ number_format($totalAyam) }}</div></div></div>
<div class="col-6 col-xl-3"><div class="stat-card"><div class="stat-label">Produksi Telur</div><div class="stat-value">{{ number_format($totalTelur) }}</div></div></div>
<div class="col-6 col-xl-3"><div class="stat-card"><div class="stat-label">Total Penjualan</div><div class="stat-value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div></div></div>
</div>

<div class="row g-4">
<div class="col-lg-6">
<div class="panel">
<div class="panel-title">Produksi Telur Terbaru</div>
<div class="table-responsive">
<table class="table mb-0">
<thead><tr><th>Tanggal</th><th>Kandang</th><th class="text-end">Produksi</th><th class="text-end">Bagus</th><th class="text-end">Reject</th></tr></thead>
<tbody>
@forelse($produksiTerbaru as $p)
<tr><td>{{ $p->tanggal->format('d/m/Y') }}</td><td>{{ $p->kandang->nama ?? '-' }}</td><td class="text-end">{{ number_format($p->jumlah_produksi) }}</td><td class="text-end">{{ number_format($p->telur_bagus) }}</td><td class="text-end">{{ number_format($p->telur_reject) }}</td></tr>
@empty
<tr><td colspan="5" class="text-center text-muted py-3">Belum ada data.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
<div class="col-lg-6">
<div class="panel">
<div class="panel-title">Penjualan Terbaru</div>
<div class="table-responsive">
<table class="table mb-0">
<thead><tr><th>Tanggal</th><th>Customer</th><th class="text-end">Jumlah (ikat)</th><th class="text-end">Total</th></tr></thead>
<tbody>
@forelse($penjualanTerbaru as $j)
<tr><td>{{ $j->tanggal->format('d/m/Y') }}</td><td>{{ $j->customer }}</td><td class="text-end">{{ number_format($j->jumlah) }}</td><td class="text-end">Rp {{ number_format($j->total, 0, ',', '.') }}</td></tr>
@empty
<tr><td colspan="4" class="text-center text-muted py-3">Belum ada data.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
@endsection
