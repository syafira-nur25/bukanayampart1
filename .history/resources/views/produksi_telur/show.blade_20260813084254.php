@extends('layouts.app')

@section('title', 'Detail Produksi Telur')

@section('content')

<h2>Detail Produksi Telur</h2>

<div class="card">
<div class="card-body">

<table class="table">

<tr>
    <th>Tanggal</th>
    <td>{{ $produksiTelur->tanggal->format('d-m-Y') }}</td>
</tr>

<tr>
    <th>Kandang</th>
    <td>{{ $produksiTelur->kandang->nama ?? '-' }}</td>
</tr>

<tr>
    <th>Jumlah Produksi</th>
    <td>{{ $produksiTelur->jumlah_produksi }}</td>
</tr>

<tr>
    <th>Persentase</th>
    <td>{{ $produksiTelur->presentase }}%</td>
</tr>

<tr>
    <th>Mati</th>
    <td>{{ $produksiTelur->mati }}</td>
</tr>

<tr>
    <th>Afkir</th>
    <td>{{ $produksiTelur->afkir }}</td>
</tr>

<tr>
    <th>Sisa Ayam</th>
    <td>{{ $produksiTelur->sisa_ayam }}</td>
</tr>

<tr>
    <th>Telur Bagus</th>
    <td>{{ $produksiTelur->telur_bagus }}</td>
</tr>

<tr>
    <th>Telur Reject</th>
    <td>{{ $produksiTelur->telur_reject }}</td>
</tr>

</table>

<a
    href="{{ route('produksi-telur.edit', $produksiTelur) }}"
    class="btn btn-warning"
>
    Edit
</a>

<a
    href="{{ route('produksi-telur.index') }}"
    class="btn btn-secondary"
>
    Kembali
</a>

</div>
</div>

@endsection
