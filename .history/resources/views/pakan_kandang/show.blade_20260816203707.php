@extends('layouts.app')

@section('title', 'Detail Pakan')

@section('content')
<h2>Detail Pakan</h2>

<div class="card">
    <div class="card-body">
        <table class="table">
            <tr><th width="220">Tanggal</th><td>{{ $pakanKandang->tanggal->format('d-m-Y') }}</td></tr>
            <tr><th>Jenis</th><td>{{ $pakanKandang->kandang_id === null ? 'Pakan masuk gudang' : 'Pengambilan kandang' }}</td></tr>
            <tr><th>Kandang</th><td>{{ $pakanKandang->kandang->nama ?? '-' }}</td></tr>
            <tr><th>Total Masuk</th><td>{{ $pakanKandang->kandang_id === null ? ($pakanKandang->total_masuk + 0) . ' zak' : '-' }}</td></tr>
            <tr><th>Keluar</th><td>{{ $pakanKandang->kandang_id !== null ? ($pakanKandang->keluar + 0) . ' Kg' : '-' }}</td></tr>
            <tr><th>Stok gudang sekarang</th><td>{{ number_format($stokKg, 0) }} Kg</td></tr>
        </table>
        <a href="{{ route('pakan-kandang.edit', $pakanKandang) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('pakan-kandang.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
