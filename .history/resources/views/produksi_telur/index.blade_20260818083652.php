@extends('layouts.app')

@section('title', 'Produksi Telur')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('produksi-telur.create') }}" class="btn btn-primary">
        + Tambah Produksi
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kandang</th>
                    <th>Populasi</th>
                    <th>Produksi</th>
                    <th>Persentase</th>
                    <th>Mati</th>
                    <th>Afkir</th>
                    <th>Telur Bagus</th>
                    <th>Reject</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produksis as $produksi)
                <tr>
                    <td>{{ $produksi->tanggal->format('d-m-Y') }}</td>
                    <td>{{ $produksi->kandang->nama ?? '-' }}</td>
                    <td>
                        @if($produksi->populasi)
                            {{ number_format($produksi->populasi->sisa) }} ekor
                            <div class="text-muted small">per {{ $produksi->populasi->tanggal->format('d-m-Y') }}</div>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ number_format($produksi->jumlah_produksi) }}</td>
                    <td>{{ $produksi->presentase }}%</td>
                    <td>{{ $produksi->mati }}</td>
                    <td>{{ $produksi->afkir }}</td>
                    <td>{{ $produksi->telur_bagus }}</td>
                    <td>{{ $produksi->telur_reject }}</td>
                    <td>
                        <a href="{{ route('produksi-telur.show', $produksi) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('produksi-telur.edit', $produksi) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('produksi-telur.destroy', $produksi) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data produksi?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">Belum ada produksi telur.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
