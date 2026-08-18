@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1">Dashboard Peternakan</h3>
    <p class="text-muted mb-0">Pantau kondisi peternakan, produksi telur, kematian, dan penggunaan pakan.</p>
</div>

<!-- STATISTICS -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Total Kandang</div>
                    <div class="stat-value">{{ $totalKandang ?? 0 }}</div>
                </div>
                <div class="stat-icon icon-green"><i class="bi bi-house-door-fill"></i></div>
            </div>
            <div class="stat-description">Kandang aktif</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Populasi Ayam</div>
                    <div class="stat-value">{{ number_format($totalAyam ?? 0) }}</div>
                </div>
                <div class="stat-icon icon-blue"><i class="bi bi-people-fill"></i></div>
            </div>
            <div class="stat-description">Ayam hidup saat ini</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Produksi Telur</div>
                    <div class="stat-value">{{ number_format($totalTelur ?? 0) }}</div>
                </div>
                <div class="stat-icon icon-yellow"><i class="bi bi-egg-fill"></i></div>
            </div>
            <div class="stat-description">Total produksi</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Penjualan</div>
                    <div class="stat-value">Rp {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon icon-green"><i class="bi bi-cash-stack"></i></div>
            </div>
            <div class="stat-description">Total penjualan telur</div>
        </div>
    </div>
</div>

<!-- RESUME KEMATIAN -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Total Kematian</div>
                    <div class="stat-value">{{ number_format($totalMati ?? 0) }}</div>
                </div>
                <div class="stat-icon icon-red"><i class="bi bi-x-octagon-fill"></i></div>
            </div>
            <div class="stat-description">Akumulasi ayam mati</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Total Afkir</div>
                    <div class="stat-value">{{ number_format($totalAfkir ?? 0) }}</div>
                </div>
                <div class="stat-icon icon-yellow"><i class="bi bi-recycle"></i></div>
            </div>
            <div class="stat-description">Akumulasi ayam afkir</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Mortality Rate</div>
                    <div class="stat-value">{{ $mortalityRate ?? 0 }}%</div>
                </div>
                <div class="stat-icon icon-red"><i class="bi bi-graph-down-arrow"></i></div>
            </div>
            <div class="stat-description">Persentase kematian terhadap populasi</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Sumber Data</div>
                    <div class="stat-value" style="font-size:15px;line-height:1.3;margin-top:10px;">{{ $sumberKematian ?? '-' }}</div>
                </div>
                <div class="stat-icon icon-blue"><i class="bi bi-database-fill"></i></div>
            </div>
            <div class="stat-description">Sumber resume & grafik kematian</div>
        </div>
    </div>
</div>

<!-- CHART + QUICK MENU -->
<div class="row g-4 mb-4">
    <div class="col-xl-8">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Produksi Telur</div>
                    <div class="text-muted small">Perkembangan produksi telur</div>
                </div>
                <a href="{{ route('produksi-telur.index') }}" class="panel-link">Lihat semua</a>
            </div>
            <canvas id="productionChart" height="110"></canvas>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">Akses Cepat</div>
            </div>
            <div class="d-grid gap-2">
                <a href="{{ route('kandang.create') }}" class="btn btn-light text-start p-3">
                    <i class="bi bi-house-add-fill text-success me-2"></i> Tambah Kandang
                    <i class="bi bi-chevron-right float-end"></i>
                </a>
                <a href="{{ route('populasi.create') }}" class="btn btn-light text-start p-3">
                    <i class="bi bi-plus-circle-fill text-primary me-2"></i> Input Populasi
                    <i class="bi bi-chevron-right float-end"></i>
                </a>
                <a href="{{ route('produksi-telur.create') }}" class="btn btn-light text-start p-3">
                    <i class="bi bi-egg-fill text-warning me-2"></i> Input Produksi Telur
                    <i class="bi bi-chevron-right float-end"></i>
                </a>
                <a href="{{ route('penjualan-telur.create') }}" class="btn btn-light text-start p-3">
                    <i class="bi bi-cart-plus-fill text-success me-2"></i> Catat Penjualan
                    <i class="bi bi-chevron-right float-end"></i>
                </a>
                <a href="{{ route('pemberian-pakan.create') }}" class="btn btn-light text-start p-3">
                    <i class="bi bi-basket-fill text-danger me-2"></i> Input Pemberian Pakan
                    <i class="bi bi-chevron-right float-end"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- GRAFIK KEMATIAN -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Grafik Kematian Ayam</div>
                    <div class="text-muted small">
                        Mati & afkir per tanggal — sumber: {{ $sumberKematian ?? '-' }} (7 catatan terakhir)
                    </div>
                </div>
            </div>
            <canvas id="mortalityChart" height="90"></canvas>
        </div>
    </div>
</div>

<!-- TABLE -->
<div class="row g-4">
    <div class="col-12">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Produksi Terbaru</div>
                    <div class="text-muted small">Data produksi telur terakhir</div>
                </div>
                <a href="{{ route('produksi-telur.index') }}" class="panel-link">Lihat semua</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kandang</th>
                            <th>Produksi</th>
                            <th>Telur Bagus</th>
                            <th>Reject</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produksiTerbaru ?? [] as $produksi)
                        <tr>
                            <td>{{ $produksi->tanggal->format('d M Y') }}</td>
                            <td>{{ $produksi->kandang->nama ?? '-' }}</td>
                            <td class="fw-semibold">{{ number_format($
