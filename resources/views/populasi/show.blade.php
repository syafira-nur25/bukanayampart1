@extends('layouts.app')
@section('title', 'Detail Populasi')
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table">
            <tr><th>Tanggal</th><td>{{ $populasi->tanggal->format('d-m-Y') }}</td></tr>
            <tr><th>Kandang</th><td>{{ $populasi->kandang->nama ?? '-' }}</td></tr>
            <tr><th>Hidup</th><td>{{ $populasi->hidup }} ekor</td></tr>
            <tr><th>Mati</th><td>{{ $populasi->mati }} ekor</td></tr>
            <tr><th>Afkir</th><td>{{ $populasi->afkir }} ekor</td></tr>
            <tr><th>Sisa</th><td class="fw-bold text-success">{{ $populasi->sisa }} ekor</td></tr>
            <tr>
                <th>Usia</th>
                <td>
                    <span class="badge bg-warning text-dark fs-6">
                        {{ intdiv((int)$populasi->usia, 7) }} minggu
                    </span>
                    <small class="text-muted ms-2">({{ $populasi->usia }} hari)</small>
                </td>
            </tr>
        </table>
        <a href="{{ route('populasi.edit', $populasi) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('populasi.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
