@extends('layouts.app')

@section('title', 'Stok Pakan')

@section('content')
@php
$namaBulanW = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
$bulanWidget = request('bulan', now()->format('Y-m'));
$daftarBulanWidget = collect($pakans)->map(fn($p)=>$p->tanggal->format('Y-m'))->push(now()->format('Y-m'))->unique()->sortDesc()->values();
$pBulan    = collect($pakans)->filter(fn($p)=>$p->tanggal->format('Y-m') === $bulanWidget);
$wMasukZak = $pBulan->whereNull('kandang_id')->sum('total_masuk');
$wKeluarKg = $pBulan->whereNotNull('kandang_id')->sum('keluar');
$wTrx      = $pBulan->count();
@endphp
<style>.widget-card { border-left: 4px solid var(--primary); }</style>

{{-- ===== WIDGET BULAN ===== --}}
<div class="card border-0 shadow-sm mb-4 widget-card">
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="fw-bold"><i class="bi bi-calendar-month me-1"></i> Widget Bulan — Pakan</div>
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
            <div class="col-6 col-md-3"><div class="border rounded-3 p-2"><div class="fs-5 fw-bold text-success">{{ number_format($wMasukZak,1) }}</div><div class="small text-muted">Masuk (zak)</div></div></div>
            <div class="col-6 col-md-3"><div class="border rounded-3 p-2"><div class="fs-5 fw-bold text-success">{{ number_format($wMasukZak * \App\Models\PakanKandang::ZAK_KE_KG,0) }}</div><div class="small text-muted">Masuk (Kg)</div></div></div>
            <div class="col-6 col-md-3"><div class="border rounded-3 p-2"><div class="fs-5 fw-bold text-danger">{{ number_format($wKeluarKg,0) }}</div><div class="small text-muted">Keluar (Kg)</div></div></div>
            <div class="col-6 col-md-3"><div class="border rounded-3 p-2"><div class="fs-5 fw-bold">{{ number_format($stokKg,0) }}</div><div class="small text-muted">Stok Gudang (Kg)</div></div></div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <small class="text-muted">
            Stok gudang saat ini:
            <strong>{{ number_format($stokKg, 0) }} Kg</strong>
            ({{ number_format($stokKg / \App\Models\PakanKandang::ZAK_KE_KG, 1) }} zak)
        </small>
    </div>
    <div>
        <a href="{{ route('pakan.laporan') }}" class="btn btn-success">Laporan Pakan</a>
        <a href="{{ route('pakan-kandang.create') }}" class="btn btn-primary">+ Catat Pakan</a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Tanggal</th><th>Jenis</th><th>Kandang</th><th>Masuk (zak)</th><th>Keluar (Kg)</th><th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pakans as $pakan)
                <tr>
                    <td>{{ $pakan->tanggal->format('d-m-Y') }}</td>
                    <td>
                        @if ($pakan->kandang_id === null)
                            <span class="badge bg-success">Masuk gudang</span>
                        @else
                            <span class="badge bg-warning text-dark">Pengambilan</span>
                        @endif
                    </td>
                    <td>{{ $pakan->kandang->nama ?? '-' }}</td>
                    <td>{{ $pakan->kandang_id === null ? $pakan->total_masuk + 0 : '-' }}</td>
                    <td>{{ $pakan->kandang_id !== null ? $pakan->keluar + 0 : '-' }}</td>
                    <td>
                        <a href="{{ route('pakan-kandang.show', $pakan) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('pakan-kandang.edit', $pakan) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pakan-kandang.destroy', $pakan) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data pakan?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-3">Belum ada data pakan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
