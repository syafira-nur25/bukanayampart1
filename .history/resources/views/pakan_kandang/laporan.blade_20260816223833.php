@extends('layouts.app')

@section('title', 'Laporan Pakan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('pakan-kandang.index') }}" class="btn btn-secondary">Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Tanggal</th>
                        <th rowspan="2">Total Masuk (zak)</th>
                        <th colspan="{{ max($kandangs->count(), 1) }}">Keluar</th>
                        <th rowspan="2">Sisa pakan zak/Kg</th>
                    </tr>
                    <tr>
                        @foreach ($kandangs as $kandang)
                            <th>{{ $kandang->nama }} (Kg)</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporan as $i => $row)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ \Illuminate\Support\Carbon::parse($row['tanggal'])->format('d-m-Y') }}</td>
                            <td>{{ $row['total_masuk'] + 0 }}</td>
                            @foreach ($kandangs as $kandang)
                                <td>{{ ($row['keluar'][$kandang->id] ?? 0) + 0 }}</td>
                            @endforeach
                            <td>{{ number_format($row['sisa_zak'], 1) }} zak / {{ number_format($row['sisa_kg'], 0) }} Kg</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 5 + $kandangs->count() }}" class="text-center py-3">Belum ada data pakan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
