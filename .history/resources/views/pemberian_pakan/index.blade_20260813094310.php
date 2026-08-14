@extends('layouts.app')

@section('title', 'Pemberian Pakan')

@section('content')

<div class="d-flex justify-content-between mb-3">

    <a
        href="{{ route('pemberian-pakan.create') }}"
        class="btn btn-primary"
    >
        + Tambah Pemberian
    </a>

</div>

<div class="card">
<div class="card-body">

<table class="table table-bordered">

<thead>
<tr>
    <th>Bulan</th>
    <th>Kandang</th>
    <th>Jenis Pakan</th>
    <th>Gram</th>
    <th>Kg</th>
    <th>Total</th>
    <th>Harga</th>
    <th>Pengeluaran</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($pemberians as $pemberian)

<tr>

    <td>{{ $pemberian->bulan }}</td>

    <td>
        {{ $pemberian->populasi->kandang->nama ?? '-' }}
    </td>

    <td>{{ $pemberian->jenis_pakan }}</td>

    <td>{{ $pemberian->gr }} gr</td>

    <td>{{ $pemberian->kg }} Kg</td>

    <td>{{ $pemberian->total }}</td>

    <td>
        Rp {{ number_format($pemberian->harga, 0, ',', '.') }}
    </td>

    <td>
        Rp {{ number_format($pemberian->pengeluaran, 0, ',', '.') }}
    </td>

    <td>

        <a
            href="{{ route('pemberian-pakan.show', $pemberian) }}"
            class="btn btn-sm btn-info"
        >
            Detail
        </a>

        <a
            href="{{ route('pemberian-pakan.edit', $pemberian) }}"
            class="btn btn-sm btn-warning"
        >
            Edit
        </a>

        <form
            action="{{ route('pemberian-pakan.destroy', $pemberian) }}"
            method="POST"
            class="d-inline"
        >
            @csrf
            @method('DELETE')

            <button
                class="btn btn-sm btn-danger"
                onclick="return confirm('Hapus data?')"
            >
                Hapus
            </button>
        </form>

    </td>

</tr>

@empty

<tr>
    <td colspan="9" class="text-center">
        Belum ada data pemberian pakan.
    </td>
</tr>

@endforelse

</tbody>

</table>

</div>
</div>

@endsection
