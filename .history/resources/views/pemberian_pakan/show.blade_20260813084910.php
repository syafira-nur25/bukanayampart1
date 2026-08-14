@extends('layouts.app')

@section('title', 'Detail Pemberian Pakan')

@section('content')

<h2>Detail Pemberian Pakan</h2>

<div class="card">
<div class="card-body">

<table class="table">

<tr>
    <th>Bulan</th>
    <td>{{ $pemberianPakan->bulan }}</td>
</tr>

<tr>
    <th>Kandang</th>
    <td>
        {{ $pemberianPakan->populasi->kandang->nama ?? '-' }}
    </td>
</tr>

<tr>
    <th>Jenis Pakan</th>
    <td>{{ $pemberianPakan->jenis_pakan }}</td>
</tr>

<tr>
    <th>Gram</th>
    <td>{{ $pemberianPakan->gr }} gr</td>
</tr>

<tr>
    <th>Kg</th>
    <td>{{ $pemberianPakan->kg }} Kg</td>
</tr>

<tr>
    <th>Total</th>
    <td>{{ $pemberianPakan->total }}</td>
</tr>

<tr>
    <th>Harga</th>
    <td>
        Rp {{ number_format($pemberianPakan->harga, 0, ',', '.') }}
    </td>
</tr>

<tr>
    <th>Pengeluaran</th>
    <td>
        Rp {{ number_format($pemberianPakan->pengeluaran, 0, ',', '.') }}
    </td>
</tr>

</table>

<a
    href="{{ route('pemberian-pakan.edit', $pemberianPakan) }}"
    class="btn btn-warning"
>
    Edit
</a>

<a
    href="{{ route('pemberian-pakan.index') }}"
    class="btn btn-secondary"
>
    Kembali
</a>

</div>
</div>

@endsection
