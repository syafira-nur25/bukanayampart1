@extends('layouts.app')

@section('title', 'Stok Pakan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <small class="text-muted">
            Stok gudang saat ini:
            <strong>{{ number_format($stokKg, 0) }} Kg</strong>
            ({{ number_format($stokKg / \App\Models\PakanKandang::ZAK_KE_KG, 1) }} zak)
        </small>
    </div>
    <div>
        <a href="{{ route('pakan.laporan') }}" class="btn btn-success">Laporan Pakan</a>
        <a href="{{ route('pakan-kandang.create') }}" class="btn btn-primary">+ Catat Pakan</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Kandang</th>
                    <th>Masuk (zak)</th>
                    <th>Keluar (Kg)</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pakans as $pakan)
                    <tr>
                        <td>{{ $pakan->tanggal->format('d-m-Y') }}</td>
                        <td>
                            @if ($pakan->kandang_id === null)
                                <span class="badge bg-success">Masuk gudang</span>
                            @else
                                <span class="badge bg-warning text-dark">Pengambilan</span>
                            @endif
                        </td>
                        <td>{{ $pakan->kandang->nama ?? '-' }}</td>
                        <td>{{ $pakan->kandang_id === null ? $pakan->total_masuk + 0 : '-' }}</td>
                        <td>{{ $pakan->kandang_id !== null ? $pakan->keluar + 0 : '-' }}</td>
                        <td>
                            <a href="{{ route('pakan-kandang.show', $pakan) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('pakan-kandang.edit', $pakan) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('pakan-kandang.destroy', $pakan) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data pakan?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3">Belum ada data pakan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
