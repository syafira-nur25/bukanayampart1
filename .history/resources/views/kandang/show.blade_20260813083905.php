@extends('layouts.app')

@section('title', 'Detail Kandang')

@section('content')

<h2 class="mb-3">Detail Kandang</h2>

<div class="card">
    <div class="card-body">

        <table class="table">
            <tr>
                <th width="200">ID</th>
                <td>{{ $kandang->id }}</td>
            </tr>

            <tr>
                <th>Nama</th>
                <td>{{ $kandang->nama }}</td>
            </tr>

            <tr>
                <th>Lokasi</th>
                <td>{{ $kandang->lokasi }}</td>
            </tr>
        </table>

        <a
            href="{{ route('kandang.edit', $kandang) }}"
            class="btn btn-warning"
        >
            Edit
        </a>

        <a
            href="{{ route('kandang.index') }}"
            class="btn btn-secondary"
        >
            Kembali
        </a>

    </div>
</div>

@endsection
