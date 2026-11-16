@extends('layouts.umum')
@section('title', 'Laporan Harian')
@section('content')
<div class="panel">
<div class="panel-title">Laporan Harian Man Power</div>
<div class="table-responsive">
<table class="table table-hover mb-0">
<thead><tr><th>Tanggal</th><th>Kandang</th><th>Petugas</th><th class="text-end">Hidup</th><th class="text-end">Mati</th><th class="text-end">Afkir</th><th class="text-end">Sisa</th><th class="text-end">Pakan (kg)</th><th class="text-end">Telur</th></tr></thead>
<tbody>
@forelse($laporans as $l)
<tr>
<td>{{ $l->tanggal->format('d/m/Y') }}</td>
<td>{{ $l->kandang->nama ?? '-' }}</td>
<td>{{ $l->user->name ?? '-' }}</td>
<td class="text-end">{{ number_format($l->hidup) }}</td>
<td class="text-end text-danger">{{ number_format($l->mati) }}</td>
<td class="text-end text-warning">{{ number_format($l->afkir) }}</td>
<td class="text-end fw-bold text-success">{{ number_format($l->sisa_ayam) }}</td>
<td class="text-end">{{ number_format($l->total_pakan, 1) }}</td>
<td class="text-end">{{ number_format($l->produksi_telur) }}</td>
</tr>
@empty
<tr><td colspan="9" class="text-center text-muted py-4">Belum ada laporan harian.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
