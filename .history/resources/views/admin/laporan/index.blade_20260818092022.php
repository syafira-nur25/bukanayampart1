@extends('layouts.app')

@section('title', 'Laporan Man Power')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1">Laporan Harian Man Power</h3>
    <p class="text-muted mb-0">Data laporan yang dimasukkan oleh seluruh man power.</p>
</div>

<!-- FILTER -->
<div class="panel mb-4">
    <form method="GET">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Kandang</label>
                <select name="kandang_id" class="form-select">
                    <option value="">Semua Kandang</option>
                    @foreach($kandangs as $kandang)
                        <option value="{{ $kandang->id }}" {{ request('kandang_id') == $kandang->id ? 'selected' : '' }}>
                            {{ $kandang->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-light">Reset</a>
            </div>
        </div>
    </form>
</div>

<!-- TABLE -->
<div class="panel">
    <div class="panel-header">
        <div>
            <div class="panel-title">Data Laporan</div>
            <div class="text-muted small">Total {{ $laporan->total() }} laporan</div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kandang</th>
                    <th>Umur</th>
                    <th>Hidup</th>
                    <th>Mati</th>
                    <th>Afkir</th>
                    <th>Sisa</th>
                    <th>Pakan (kg)</th>
                    <th>Produksi</th>
                    <th>Pecah</th>
                    <th>Catatan</th>
                    <th>Man Power</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $data)
                <tr>
                    <td>{{ $data->tanggal->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge bg-success">{{ $data->kandang->nama ?? '-' }}</span>
                    </td>
                    <td>{{ $data->umur_minggu }} minggu</td>
                    <td>{{ number_format($data->hidup) }}</td>
                    <td>{{ number_format($data->mati) }}</td>
                    <td>{{ number_format($data->afkir) }}</td>
                    <td class="fw-bold">{{ number_format($data->sisa_ayam) }}</td>
                    <td>{{ number_format($data->total_pakan, 2) }}</td>
                    <td class="fw-bold">{{ number_format($data->produksi_telur) }}</td>
                    <td>{{ number_format($data->telur_pecah) }}</td>
                    <td>
                        @if($data->column_10)
                            <span title="{{ $data->column_10 }}">
                                {{ \Illuminate\Support\Str::limit($data->column_10, 25) }}
                            </span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $data->user->name ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        Belum ada laporan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $laporan->links() }}
    </div>
</div>
@endsection
