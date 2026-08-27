@extends('layouts.app')

@section('title', 'Data Populasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Data Populasi</h2>
    <a href="{{ route('populasi.create') }}" class="btn btn-primary">+ Tambah Populasi</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
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
                            <td>{{ $populasi->kandang->nama ?? '-' }}</td>
                            <td>{{ number_format($populasi->hidup) }}</td>
                            <td class="text-danger">{{ number_format($populasi->mati) }}</td>
                            <td class="text-warning">{{ number_format($populasi->afkir) }}</td>
                            <td class="fw-bold text-success">{{ number_format($populasi->sisa) }}</td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    {{ intdiv((int) $populasi->usia, 7) }} minggu
                                </span>
                                <small class="text-muted d-block">({{ $populasi->usia }} hari)</small>
                            </td>
                            <td>
                                <a href="{{ route('populasi.show', $populasi) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('populasi.edit', $populasi) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('populasi.destroy', $populasi) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Belum ada data populasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ===== KETERANGAN (di bawah tabel) ===== --}}
        <div class="alert alert-light border small mb-0 mt-3">
            <div class="fw-bold mb-1">
                <i class="bi bi-info-circle-fill me-1" style="color: var(--primary);"></i>Keterangan
            </div>
            <ul class="mb-0 ps-3">
                <li><strong>Sisa</strong> = Hidup − Mati &nbsp;(afkir hanya dicatat, tidak mengurangi sisa).</li>
                <li><strong>Usia</strong> ditampilkan dalam minggu = usia (hari) ÷ 7.</li>
                <li>Urutan data: tanggal terbaru paling atas.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
