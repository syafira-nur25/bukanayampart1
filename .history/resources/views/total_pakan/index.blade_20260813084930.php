@extends('layouts.app')

@section('title', 'Total Pakan')

@section('content')

<div class="d-flex justify-content-between mb-3">

    <h2>Total Pakan</h2>

    <a
        href="{{ route('total-pakan.create') }}"
        class="btn btn-primary"
    >
        + Tambah Total Pakan
    </a>

</div>

<div class="card">
<div class="card-body">

<table class="table table-bordered">

<thead>
<tr>
    <th>Tanggal</th>
    <th>Kandang</th>
    <th>Total Pakan</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($totals as $total)

<tr>

    <td>
        {{ $total->pakanKandang->tanggal->format('d-m-Y') ?? '-' }}
    </td>

    <td>
        {{ $total->pakanKandang->kandang->nama ?? '-' }}
    </td>

    <td>
        {{ $total->total }} Kg
    </td>

    <td>

        <a
            href="{{ route('total-pakan.show', $total) }}"
            class="btn btn-sm btn-info"
        >
            Detail
        </a>

        <a
            href="{{ route('total-pakan.edit', $total) }}"
            class="btn btn-sm btn-warning"
        >
            Edit
        </a>

        <form
            action="{{ route('total-pakan.destroy', $total) }}"
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
    <td colspan="4" class="text-center">
        Belum ada data total pakan.
    </td>
</tr>

@endforelse

</tbody>

</table>

</div>
</div>

@endsection
