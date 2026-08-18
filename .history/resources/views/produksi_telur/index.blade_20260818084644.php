@extends('layouts.app')

@section('title', 'Produksi Telur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Laporan Produksi Telur</h2>
    <a href="{{ route('produksi-telur.create') }}" class="btn btn-primary">+ Tambah Produksi</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th rowspan="2">Tanggal</th>
                        @foreach ($kandangs as $kandang)
                            <th colspan="3">{{ strtoupper($kandang->nama) }}</th>
                        @endforeach
                        <th rowspan="2">Total Populasi</th>
                        <th colspan="2">KANDANG 1&{{ $kandangs->count() }}</th>
                        <th rowspan="2">Aksi</th>
                    </tr>
                    <tr>
                        @foreach ($kandangs as $kandang)
                            <th>Populasi</th>
                            <th>Jumlah produksi</th>
                            <th>Persentase</th>
                        @endforeach
                        <th>Jumlah produksi</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporan as $row)
                        <tr>
                            <td>{{ \Illuminate\Support\Carbon::parse($row['tanggal'])->format('d/m/Y') }}</td>

                            @foreach ($kandangs as $kandang)
                                @php $c = $row['perKandang'][$kandang->id]; @endphp
                                <td>{{ $c['populasi'] > 0 ? number_format($c['populasi']) : '-' }}</td>
                                <td>{{ $c['produksi'] > 0 ? number_format($c['produksi']) : '-' }}</td>
                                <td>{{ $c['populasi'] > 0 ? number_format($c['persentase'], 2) . '%' : '-' }}</td>
                            @endforeach

                            <td class="fw-bold">{{ number_format($row['totalPopulasi']) }}</td>
                            <td class="fw-bold">{{ number_format($row['totalProduksi']) }}</td>
                            <td class="fw-bold">{{ number_format($row['totalPersentase'], 2) }}%</td>

                            <td>
                                @foreach ($row['items'] as $item)
                                    <div class="d-flex gap-1 justify-content-center mb-1">
                                        <a href="{{ route('produksi-telur.edit', $item) }}"
                                           class="btn btn-sm btn-warning">
                                            Edit {{ $item->kandang->nama ?? '' }}
                                        </a>
                                        <form action="{{ route('produksi-telur.destroy', $item) }}" method="POST"
                                              onsubmit="return confirm('Hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 5 + ($kandangs->count() * 3) }}" class="text-center py-4">
                                Belum ada data produksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
