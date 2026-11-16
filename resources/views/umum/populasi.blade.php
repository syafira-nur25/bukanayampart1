@extends('layouts.umum')
@section('title', 'Populasi Ayam')
@section('content')
<div class="panel">
<div class="panel-title">Data Populasi per Kandang</div>
<div class="table-responsive">
<table class="table table-hover mb-0">
<thead><tr><th>Tanggal</th><th>Kandang</th><th class="text-end">Hidup</th><th class="text-end">Mati</th><th class="text-end">Afkir</th><th class="text-end">Sisa</th><th class="text-end">Usia</th></tr></thead>
<tbody>
@forelse($populasis as $p)
<tr>
<td>{{ $p->tanggal->format('d/m/Y') }}</td>
<td>{{ $p->kandang->nama ?? '-' }}</td>
<td class="text-end">{{ number_format($p->hidup) }}</td>
<td class="text-end text-danger">{{ number_format($p->mati) }}</td>
<td class="text-end text-warning">{{ number_format($p->afkir) }}</td>
<td class="text-end fw-bold text-success">{{ number_format($p->sisa) }}</td>
<td class="text-end">{{ intdiv((int) $p->usia, 7) }} mgg</td>
</tr>
@empty
<tr><td colspan="7" class="text-center text-muted py-4">Belum ada data populasi.</td></tr>
@endforelse
</tbody>
</table>
</div>
</div>
@endsection
