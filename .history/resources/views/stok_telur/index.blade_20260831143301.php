@extends('layouts.app')

@section('title', 'Stok Telur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Stok Penyimpanan Telur</h2>
        <p class="text-muted small mb-0">
            Stok = (Produksi + Stok Manual) − Penjualan − Return ·
            1 ikat = {{ \App\Models\GudangTelur::BUTIR_PER_IKAT }} butir
        </p>
    </div>
    <a href="{{ route('gudang-telur.index') }}" class="btn btn-secondary">
        <i class="bi bi-building me-1"></i> Kelola Gudang
    </a>
</div>

<!-- ===== KARTU STOK PER GUDANG ===== -->
<div class="row g-4 mb-4">
    @forelse ($gudangs as $gudang)
        <div class="col-xl-4 col-md-6">
            <div class="stat-card h-100">
                <div class="stat-top">
                    <div>
                        <div class="stat-label mt-0">{{ $gudang->nama }}</div>
                        <div class="stat-value {{ $gudang->stokButir() < 0 ? 'text-danger' : '' }}">
                            {{ number_format($gudang->stokButir()) }}
                        </div>
                    </div>
                    <div class="stat-icon icon-yellow"><i class="bi bi-box-seam-fill"></i></div>
                </div>
                <div class="stat-description">
                    butir (≈ {{ number_format($gudang->stokButir() / \App\Models\GudangTelur::BUTIR_PER_IKAT, 1) }} ikat)
                    · {{ $gudang->lokasi ?? 'tanpa lokasi' }}
                </div>
                <hr class="my-3">
                <div class="d-flex justify-content-between small fw-semibold">
                    <span class="text-success">Masuk {{ number_format($gudang->totalMasuk()) }}</span>
                    <span class="text-danger">Keluar {{ number_format($gudang->totalKeluarButir()) }}</span>
                    <span class="text-warning">Return {{ number_format($gudang->totalReturn()) }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-light border">
                Belum ada gudang.
                <a href="{{ route('gudang-telur.create') }}" class="fw-bold">+ Tambah gudang</a> dulu.
            </div>
        </div>
    @endforelse
</div>

<!-- ===== ✅ TAMBAH STOK MANUAL (TANPA LEWAT PRODUKSI) ===== -->
<div class="panel mb-4">
    <div class="panel-header">
        <div class="panel-title">Tambah Stok Gudang (tanpa lewat produksi)</div>
    </div>
    <form method="POST" action="{{ route('stok-telur.stok.store') }}">
        @csrf
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label small">Tanggal</label>
                <input type="date" name="tanggal" class="form-control"
                       value="{{ old('tanggal', date('Y-m-d')) }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Gudang</label>
                <select name="gudang_id" class="form-select" required>
                    <option value="">-- Pilih Gudang --</option>
                    @foreach ($gudangs as $g)
                        <option value="{{ $g->id }}" @selected(old('gudang_id') == $g->id)>{{ $g->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Jumlah (butir)</label>
                <input type="number" name="jumlah" class="form-control" min="1"
                       value="{{ old('jumlah') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Keterangan (opsional)</label>
                <input type="text" name="keterangan" class="form-control"
                       value="{{ old('keterangan') }}" placeholder="Misal: stok awal / pindahan gudang">
            </div>
            <div class="col-12">
                <button class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Stok
                </button>
            </div>
        </div>
    </form>
</div>

<!-- ===== MUTASI TERBARU ===== -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="panel h-100">
            <div class="panel-header"><div class="panel-title">Telur Masuk (Produksi + Manual)</div></div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr><th>Tanggal</th><th>Gudang</th><th class="text-end">Jumlah</th><th>Sumber</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse ($masukGabungan as $m)
                            <tr>
                                <td>{{ $m['tanggal']->format('d/m/Y') }}</td>
                                <td>{{ $m['gudang'] }}</td>
                                <td class="text-end fw-semibold text-success">+{{ number_format($m['jumlah']) }}</td>
                                <td>
                                    @if ($m['id'] === null)
                                        <span class="badge bg-info text-dark">Produksi</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $m['sumber'] }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if ($m['id'] !== null)
                                        <form action="{{ route('stok-telur.stok.destroy', $m['id']) }}" method="POST"
                                              onsubmit="return confirm('Hapus catatan stok ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">Belum ada telur masuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel h-100">
            <div class="panel-header"><div class="panel-title">Telur Keluar (Penjualan)</div></div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead><tr><th>Tanggal</th><th>Gudang</th><th class="text-end">Jumlah</th></tr></thead>
                    <tbody>
                        @forelse ($keluarTerbaru as $k)
                            <tr>
                                <td>{{ $k->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $k->gudang->nama ?? '-' }}</td>
                                <td class="text-end fw-semibold text-danger">
                                    −{{ number_format($k->jumlah) }} ikat
                                    <span class="text-muted small d-block">
                                        ({{ number_format($k->jumlah * \App\Models\GudangTelur::BUTIR_PER_IKAT) }} butir)
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Belum ada penjualan dari gudang.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ===== RETURN TELUR ===== -->
<div class="row g-4">
    <div class="col-md-4">
        <div class="panel h-100">
            <div class="panel-header"><div class="panel-title">Catat Return Telur</div></div>
            <form method="POST" action="{{ route('stok-telur.return.store') }}">
                @csrf
                <div class="mb-2">
                    <label class="form-label small">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control"
                           value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>
                <div class="mb-2">
                    <label class="form-label small">Gudang</label>
                    <select name="gudang_id" class="form-select" required>
                        <option value="">-- Pilih Gudang --</option>
                        @foreach ($gudangs as $g)
                            <option value="{{ $g->id }}" @selected(old('gudang_id') == $g->id)>{{ $g->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label small">Jumlah (butir)</label>
                    <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah') }}" min="1" required>
                </div>
                <div class="mb-2">
                    <label class="form-label small">Alasan</label>
                    <select name="alasan" class="form-select" required>
                        <option value="Busuk" @selected(old('alasan') == 'Busuk')>Busuk</option>
                        <option value="Pecah" @selected(old('alasan') == 'Pecah')>Pecah</option>
                        <option value="Retak" @selected(old('alasan') == 'Retak')>Retak</option>
                        <option value="Lainnya" @selected(old('alasan') == 'Lainnya')>Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small">Keterangan (opsional)</label>
                    <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan') }}">
                </div>
                <button class="btn btn-danger w-100">
                    <i class="bi bi-arrow-return-left me-1"></i> Simpan Return
                </button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel h-100">
            <div class="panel-header"><div class="panel-title">Riwayat Return Telur</div></div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th><th>Gudang</th><th class="text-end">Jumlah</th>
                            <th>Alasan</th><th>Keterangan</th><th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($returns as $r)
                            <tr>
                                <td>{{ $r->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $r->gudang->nama ?? '-' }}</td>
                                <td class="text-end fw-semibold text-danger">−{{ number_format($r->jumlah) }}</td>
                                <td><span class="badge bg-warning text-dark">{{ $r->alasan }}</span></td>
                                <td>{{ $r->keterangan ?? '-' }}</td>
                                <td class="text-end">
                                    <form action="{{ route('stok-telur.return.destroy', $r) }}" method="POST"
                                          onsubmit="return confirm('Hapus data return ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">Belum ada return telur.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
