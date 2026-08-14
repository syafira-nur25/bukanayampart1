@extends('layouts.app')

@section('title', 'Detail Populasi')

@section('content')

<div class="card">
    <div class="card-body">

        <table class="table">

            <tr>
                <th>Tanggal</th>
                <td>{{ $populasi->tanggal->format('d-m-Y') }}</td>
            </tr>

            <tr>
                <th>Kandang</th>
                <td>{{ $populasi->kandang->nama ?? '-' }}</td>
            </tr>

            <tr>
                <th>Hidup</th>
                <td>{{ $populasi->hidup }}</td>
            </tr>

            <tr>
                <th>Mati</th>
                <td>{{ $populasi->mati }}</td>
            </tr>

            <tr>
                <th>Afkir</th>
                <td>{{ $populasi->afkir }}</td>
            </tr>

            <tr>
                <th>Sisa</th>
                <td>{{ $populasi->sisa }}</td>
            </tr>

            <tr>
                <th>Usia</th>
                <td>{{ $populasi->usia }} hari</td>
            </tr>

        </table>

        <a
            href="{{ route('populasi.edit', $populasi) }}"
            class="btn btn-warning"
        >
            Edit
        </a>

        <a
            href="{{ route('populasi.index') }}"
            class="btn btn-secondary"
        >
            Kembali
        </a>

    </div>
</div>

@endsection
