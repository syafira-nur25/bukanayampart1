@extends('layouts.app')

@section('title', 'Data Kandang')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Data Kandang</h2>

    <a href="{{ route('kandang.create') }}" class="btn btn-primary">
        + Tambah Kandang
    </a>
</div>

<div class="card">
    <div class="card-body">

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="60">ID</th>
                    <th>Nama</th>
                    <th>Lokasi</th>
                    <th width="220">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($kandangs as $kandang)
                    <tr>
                        <td>{{ $kandang->id }}</td>
                        <td>{{ $kandang->nama }}</td>
                        <td>{{ $kandang->lokasi }}</td>
                        <td>
                            <a
                                href="{{ route('kandang.show', $kandang) }}"
                                class="btn btn-sm btn-info"
                            >
                                Detail
                            </a>

                            <a
                                href="{{ route('kandang.edit', $kandang) }}"
                                class="btn btn-sm btn-warning"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('kandang.destroy', $kandang) }}"
                                method="POST"
                                class="d-inline"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Hapus kandang ini?')"
                                >
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada data kandang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection
