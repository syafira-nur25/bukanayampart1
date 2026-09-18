@extends('layouts.app')

@section('title', 'Penjualan Telur')

@section('content')
@php
$namaBulanW = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
$bulanWidget = request('bulan', now()->format('Y-m'));
$daftarBulanWidget = collect($penjualans)->map(fn($p)=>$p->tanggal->format('Y-m'))->push(now()->format('Y-m'))->unique()->sortDesc()->values();
$jBulan = collect($penjualans)->filter(fn($p)=>$p->tanggal->format('Y-m') === $bulanWidget);
$wTotal = $jBulan->sum('total');
$wIkat  = $jBulan->sum('jumlah');
$wTrx   = $jBulan->count();
$wAvg   = $wTrx ? round($wTotal / $wTrx) : 0;
@endphp
<style>.widget-card { border-left: 4px solid var(--primary); }</style>

{{-- ===== WIDGET BULAN ===== --}}
<div class="card border-0 shadow-sm mb-4 widget-card">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="fw-bold"><i class="bi bi-calendar-month me-1"></i> Widget Bulan — Penjualan</div>
            <form method="GET" class="d-flex align-items-center gap-2">
                <select name="bulan" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                    @foreach($daftarBulanWidget as $b)
                        @php [$tW,$mW]=explode('-',$b); @endphp
                        <option value="{{ $b }}" @selected($b === $bulanWidget)>{{ $namaBulanW[(int)$mW] ?? $mW }} {{ $tW }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="row g-3 text-center">
            <div class="col-6 col-md-3"><div class="border rounded-3 p-2"><div class="fs-5 fw-bold text-success">Rp {{ number_format($wTotal,0,',','.') }}</div><div class="small text-muted">Omzet</div></div></div>
            <div class="col-6 col-md-3"><div class="border rounded-3 p-2"><div class="fs-5 fw-bold">{{ number_format($wIkat) }}</div><div class="small text-muted">Terjual (ikat)</div></div></div>
            <div class="col-6 col-md-3"><div class="border rounded-3 p-2"><div class="fs-5 fw-bold">{{ number_format($wTrx) }}</div><div class="small text-muted">Transaksi</div></div></div>
            <div class="col-6 col-md-3"><div class="border rounded-3 p-2"><div class="fs-5 fw-bold">Rp {{ number_format($wAvg,0,',','.') }}</div><div class="small text-muted">Rata-rata / Transaksi</div></div></div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('penjualan-telur.create') }}" class="btn btn-primary">+ Tambah Penjualan</a>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th><th>Customer</th><th>Jumlah</th><th>Harga</th><th>Total</th><th>Produksi</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penjualans as $penjualan)
                <tr>
                    <td>{{ $penjualan->tanggal->format('d-m-Y') }}</td>
                    <td>{{ $penjualan->customer }}</td>
                    <td>{{ number_format($penjualan->jumlah) }}</td>
                    <td>Rp {{ number_format($penjualan->harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                    <td>{{ $penjualan->produksiTelur->tanggal->format('d-m-Y') ?? '-' }}</td>
                    <td>
                        <a href="{{ route('penjualan-telur.show', $penjualan) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('penjualan-telur.edit', $penjualan) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('penjualan-telur.destroy', $penjualan) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus penjualan?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">Belum ada penjualan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
