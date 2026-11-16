@extends('layouts.umum')
@section('title', 'Penjualan Telur')
@section('content')
<div class="panel">
<div class="panel-title">Data Penjualan Telur</div>
<div class="table-responsive">
<table class="table table-hover mb-0">
<thead><tr><th>Tanggal</th><th>Customer</th><th class="text-end">Jumlah (ikat)</th><th class="text-end">Harga</th><th class="text-end">Total</th></tr></thead>
<tbody>
@forelse($penjualans as $j)
<tr>
<td>{{ $j->tanggal->format('d/m/Y') }}</td>
<td>{{ $j->customer }}</td>
<td class="text-end">{{ number_format($j->jumlah) }}</td>
<td class="text-end">Rp {{ number_format($j->harga, 0, ',', '.') }}</td>
<td class="text-end fw-bold">Rp {{ number_format($j->total, 0, ',', '.') }}</td>
</tr>
@empty
<tr><td colspan="5" class="text-center text-muted py-4">Belum ada data penjualan.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
