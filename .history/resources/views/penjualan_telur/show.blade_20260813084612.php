@extends('layouts.app')

@section('title', 'Detail Penjualan Telur')

@section('content')

<h2>Detail Penjualan Telur</h2>

<div class="card">
<div class="card-body">

<table class="table">

<tr>
    <th>Tanggal</th>
    <td>{{ $penjualanTelur->tanggal->format('d-m-Y') }}</td>
</tr>

<tr>
    <th>Customer</th>
    <td>{{ $penjualanTelur->customer }}</td>
</tr>

<tr>
    <th>Jumlah</th>
    <td>{{ number_format($penjualanTelur->jumlah) }}</td>
</tr>

<tr>
    <th>Harga</th>
    <td>
        Rp {{ number_format($penjualanTelur->harga, 0, ',', '.') }}
    </td>
</tr>

<tr>
    <th>Total</th>
    <td>
        Rp {{ number_format($penjualanTelur->total, 0, ',', '.') }}
    </td>
</tr>

</table>

<a
    href="{{ route('penjualan-telur.edit', $penjualanTelur) }}"
    class="btn btn-warning"
>
    Edit
</a>

<a
    href="{{ route('penjualan-telur.index') }}"
    class="btn btn-secondary"
>
    Kembali
</a>

</div>
</div>

@endsection
