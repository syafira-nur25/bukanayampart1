@extends('layouts.app')

@section('title', 'Pakan Kandang')

@section('content')

<div class="d-flex justify-content-between mb-3">

    <h2>Pakan Kandang</h2>

    <a
        href="{{ route('pakan-kandang.create') }}"
        class="btn btn-primary"
    >
        + Tambah Pakan
    </a>

</div>

<div class="card">
<div class="card-body">

<table class="table table-bordered">

<thead>
<tr>
    <th>Tanggal</th>
    <th>Kandang</th>
    <th>Total Masuk</th>
    <th>Keluar</th>
    <th>Sisa</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($pakans as $pakan)

<tr>

    <td>{{ $pakan->tanggal->format('d-m-Y') }}</td>

    <td>{{ $pakan->kandang->nama ?? '-' }}</td>

    <td>{{ $pakan->total_masuk }} Kg</td>

    <td>{{ $pakan->keluar }} Kg</td>

    <td>{{ $pakan->sisa }} Kg</td>

    <td>

        <a
            href="{{ route('pakan-kandang.show', $pakan) }}"
            class="btn btn-sm btn-info"
        >
            Detail
        </a>

        <a
            href="{{ route('pakan-kandang.edit', $pakan) }}"
            class="btn btn-sm btn-warning"
        >
            Edit
        </a>

        <form
            action="{{ route('pakan-kandang.destroy', $pakan) }}"
            method="POST"
            class="d-inline"
        >
            @csrf
            @method('DELETE')

            <button
                class="btn btn-sm btn-danger"
                onclick="return confirm('Hapus data pakan?')"
            >
                Hapus
            </button>
        </form>

    </td>

</tr>

@empty

<tr>
    <td colspan="6" class="text-center">
        Belum ada data pakan.
    </td>
</tr>

@endforelse

</tbody>

</table>

</div>
</div>

@endsection
