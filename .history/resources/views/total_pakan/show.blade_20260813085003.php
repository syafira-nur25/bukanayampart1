@extends('layouts.app')

@section('title', 'Detail Total Pakan')

@section('content')

<h2>Detail Total Pakan</h2>

<div class="card">
<div class="card-body">

<table class="table">

<tr>
    <th>Tanggal</th>
    <td>
        {{ $totalPakan->pakanKandang->tanggal->format('d-m-Y') ?? '-' }}
    </td>
</tr>

<tr>
    <th>Kandang</th>
    <td>
        {{ $totalPakan->pakanKandang->kandang->nama ?? '-' }}
    </td>
</tr>

<tr>
    <th>Total</th>
    <td>{{ $totalPakan->total }} Kg</td>
</tr>

</table>

<a
    href="{{ route('total-pakan.edit', $totalPakan) }}"
    class="btn btn-warning"
>
    Edit
</a>

<a
    href="{{ route('total-pakan.index') }}"
    class="btn btn-secondary"
>
    Kembali
</a>

</div>
</div>

@endsection
