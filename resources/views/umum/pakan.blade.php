@extends('layouts.umum')
@section('title', 'Stok Pakan')
@section('content')
<div class="row g-4 mb-4">
<div class="col-md-4">
<div class="stat-card">
<div class="stat-label">Stok Gudang Saat Ini</div>
<div class="stat-value">{{ number_format($stokKg, 0) }} Kg</div>
<div class="stat-label mt-1">≈ {{ number_format($stokKg / \App\Models\PakanKandang::ZAK_KE_KG, 1) }} zak</div>
</div>
</div>
</div>
<div class="panel">
<div class="panel-title">Riwayat Pakan (Masuk / Keluar)</div>
<div class="table-responsive">
<table class="table table-hover mb-0">
<thead><tr><th>Tanggal</th><th>Jenis</th><th>Kandang</th><th class="text-end">Masuk (zak)</th><th class="text-end">Keluar (Kg)</th></tr></thead>
<tbody>
@forelse($pakans as $p)
<tr>
<td>{{ $p->tanggal->format('d/m/Y') }}</td>
<td>
@if($p->kandang_id === null)<span class="badge bg-success">Masuk gudang</span>
@else<span class="badge bg-warning text-dark">Pengambilan</span>@endif
</td>
<td>{{ $p->kandang->nama ?? '-' }}</td>
<td class="text-end">{{ $p->kandang_id === null ? number_format($p->total_masuk, 1) : '-' }}</td>
<td class="text-end">{{ $p->kandang_id !== null ? number_format($p->keluar, 1) : '-' }}</td>
</tr>
@empty
<tr><td colspan="5" class="text-center text-muted py-4">Belum ada data pakan.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
