@extends('layouts.app')

@section('title', 'Penjualan Telur')

@section('content')

<div class="d-flex justify-content-between mb-3">

    <a
        href="{{ route('penjualan-telur.create') }}"
        class="btn btn-primary"
    >
        + Tambah Penjualan
    </a>

</div>

<div class="card">
<div class="card-body">

<table class="table table-bordered table-striped">

<thead>
<tr>
    <th>Tanggal</th>
    <th>Customer</th>
    <th>Jumlah</th>
    <th>Harga</th>
    <th>Total</th>
    <th>Produksi</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($penjualans as $penjualan)

<tr>

    <td>{{ $penjualan->tanggal->format('d-m-Y') }}</td>

    <td>{{ $penjualan->customer }}</td>

    <td>{{ number_format($penjualan->jumlah) }}</td>

    <td>
        Rp {{ number_format($penjualan->harga, 0, ',', '.') }}
    </td>

    <td>
        Rp {{ number_format($penjualan->total, 0, ',', '.') }}
    </td>

    <td>
        {{ $penjualan->produksiTelur->tanggal->format('d-m-Y') ?? '-' }}
    </td>

    <td>

        <a
            href="{{ route('penjualan-telur.show', $penjualan) }}"
            class="btn btn-sm btn-info"
        >
            Detail
        </a>

        <a
            href="{{ route('penjualan-telur.edit', $penjualan) }}"
            class="btn btn-sm btn-warning"
        >
            Edit
        </a>

        <form
            action="{{ route('penjualan-telur.destroy', $penjualan) }}"
            method="POST"
            class="d-inline"
        >
            @csrf
            @method('DELETE')

            <button
                class="btn btn-sm btn-danger"
                onclick="return confirm('Hapus penjualan?')"
            >
                Hapus
            </button>
        </form>

    </td>

</tr>

@empty

<tr>
    <td colspan="7" class="text-center">
        Belum ada penjualan.
    </td>
</tr>

@endforelse

</tbody>

</table>

</div>
</div>

@endsection
