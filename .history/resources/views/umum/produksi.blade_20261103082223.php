@extends('layouts.umum')
@section('title', 'Produksi Telur')
@section('content')
<div class="panel">
<div class="panel-title">Data Produksi Telur</div>
<div class="table-responsive">
<table class="table table-hover mb-0">
<thead><tr><th>Tanggal</th><th>Kandang</th><th class="text-end">Produksi</th><th class="text-end">Telur Bagus</th><th class="text-end">Reject</th><th class="text-end">HDP</th></tr></thead>
<tbody>
@forelse($produksis as $p)
<tr>
<td>{{ $p->tanggal->format('d/m/Y') }}</td>
<td>{{ $p->kandang->nama ?? '-' }}</td>
<td class="text-end">{{ number_format($p->jumlah_produksi) }}</td>
<td class="text-end">{{ number_format($p->telur_bagus) }}</td>
<td class="text-end">{{ number_format($p->telur_reject) }}</td>
<td class="text-end">{{ number_format((float) $p->presentase, 1) }}%</td>
</tr>
@empty
<tr><td colspan="6" class="text-center text-muted py-4">Belum ada data produksi.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
