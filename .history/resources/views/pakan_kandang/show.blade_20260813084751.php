@extends('layouts.app')

@section('title', 'Detail Pakan Kandang')

@section('content')

<h2>Detail Pakan Kandang</h2>

<div class="card">
<div class="card-body">

<table class="table">

<tr>
    <th>Tanggal</th>
    <td>{{ $pakanKandang->tanggal->format('d-m-Y') }}</td>
</tr>

<tr>
    <th>Kandang</th>
    <td>{{ $pakanKandang->kandang->nama ?? '-' }}</td>
</tr>

<tr>
    <th>Total Masuk</th>
    <td>{{ $pakanKandang->total_masuk }} Kg</td>
</tr>

<tr>
    <th>Keluar</th>
    <td>{{ $pakanKandang->keluar }} Kg</td>
</tr>

<tr>
    <th>Sisa</th>
    <td>{{ $pakanKandang->sisa }} Kg</td>
</tr>

</table>

<a
    href="{{ route('pakan-kandang.edit', $pakanKandang) }}"
    class="btn btn-warning"
>
    Edit
</a>

<a
    href="{{ route('pakan-kandang.index') }}"
    class="btn btn-secondary"
>
    Kembali
</a>

</div>
</div>

@endsection
