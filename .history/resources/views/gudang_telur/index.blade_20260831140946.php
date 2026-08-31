@extends('layouts.app')

@section('title', 'Gudang Telur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="mb-0">Gudang Telur</h2>
        <small class="text-muted">Kelola lokasi penyimpanan telur — seperti kelola kandang.</small>
    </div>
    <a href="{{ route('gudang-telur.create') }}" class="btn btn-primary">+ Tambah Gudang</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th width="60">ID</th>
                    <th>Nama Gudang</th>
                    <th>Lokasi</th>
                    <th>Stok Saat Ini</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gudangs as $gudang)
                    <tr>
                        <td>{{ $gudang->id }}</td>
                        <td class="fw-bold">{{ $gudang->nama }}</td>
                        <td>{{ $gudang->lokasi ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $gudang->stokButir() < 0 ? 'text-bg-danger' : 'text-bg-success' }}">
                                {{ number_format($gudang->stokButir()) }} butir
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('gudang-telur.edit', $gudang) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('gudang-telur.destroy', $gudang) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus gudang ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            Belum ada gudang. Klik "+ Tambah Gudang" (mis. Gudang A, Gudang B).
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
