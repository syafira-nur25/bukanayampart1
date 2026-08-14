@extends('layouts.app')

@section('title', 'Data Populasi')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h2>Data Populasi</h2>

    <a href="{{ route('populasi.create') }}" class="btn btn-primary">
        + Tambah Populasi
    </a>
</div>

<div class="card">
    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kandang</th>
                    <th>Hidup</th>
                    <th>Mati</th>
                    <th>Afkir</th>
                    <th>Sisa</th>
                    <th>Usia</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($populasis as $populasi)

                    <tr>
                        <td>{{ $populasi->tanggal->format('d-m-Y') }}</td>

                        <td>
                            {{ $populasi->kandang->nama ?? '-' }}
                        </td>

                        <td>{{ $populasi->hidup }}</td>
                        <td>{{ $populasi->mati }}</td>
                        <td>{{ $populasi->afkir }}</td>
                        <td>{{ $populasi->sisa }}</td>
                        <td>{{ $populasi->usia }} hari</td>

                        <td>
                            <a
                                href="{{ route('populasi.show', $populasi) }}"
                                class="btn btn-sm btn-info"
                            >
                                Detail
                            </a>

                            <a
                                href="{{ route('populasi.edit', $populasi) }}"
                                class="btn btn-sm btn-warning"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('populasi.destroy', $populasi) }}"
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
                        <td colspan="8" class="text-center">
                            Belum ada data populasi.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>
</div>

@endsection
