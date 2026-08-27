@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4 d-flex flex-wrap justify-content-between align-items-end gap-3">
    <div>
        <h3 class="fw-bold mb-1">Dashboard Peternakan</h3>
        <p class="text-muted mb-0">Pantau kondisi peternakan, produksi telur, dan penggunaan pakan.</p>
    </div>
    {{-- ===== FILTER BULAN (berlaku untuk semua grafik) ===== --}}
    <form method="GET" class="d-flex align-items-center gap-2">
        <label class="small text-muted mb-0" for="bulan">Filter bulan:</label>
        <select name="bulan" id="bulan" class="form-select w-auto" onchange="this.form.submit()">
            @foreach ($daftarBulan as $b)
                <option value="{{ $b }}" @selected($b === $bulan)>
                    {{ $namaBulan[(int) substr($b, 5, 2)] }} {{ substr($b, 0, 4) }}
                </option>
            @endforeach
        </select>
    </form>
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
            <div class="stat-description">Jumlah sisa terbaru tiap kandang</div>
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
            <div class="stat-description">Total produksi keseluruhan</div>
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

<!-- GRAFIK PRODUKSI + AKSES CEPAT -->
<div class="row g-4 mb-4">
    <div class="col-xl-8">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Produksi Telur</div>
                    <div class="text-muted small">Harian — {{ $labelBulan }}</div>
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

<!-- GRAFIK PENJUALAN -->
<div class="row g-4 mb-4">
    <div class="col-xl-8">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Pendapatan Penjualan</div>
                    <div class="text-muted small">Harian — {{ $labelBulan }} (Rp)</div>
                </div>
                <a href="{{ route('penjualan-telur.index') }}" class="panel-link">Lihat semua</a>
            </div>
            <canvas id="salesChart" height="110"></canvas>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="stat-card h-100 d-flex flex-column justify-content-center">
            <div class="stat-top">
                <div>
                    <div class="stat-label mt-0">Rata-rata / hari</div>
                    <div class="stat-value">Rp {{ number_format($avgSales, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon icon-green"><i class="bi bi-graph-up-arrow"></i></div>
            </div>
            <div class="stat-description mt-3">
                Total {{ $labelBulan }}: <strong>Rp {{ number_format($sumSales, 0, ',', '.') }}</strong>
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
                        Mati & afkir harian — sumber: Data Populasi (input admin) — {{ $labelBulan }}
                    </div>
                </div>
            </div>
            <canvas id="mortalityChart" height="90"></canvas>
        </div>
    </div>
</div>

<!-- TABEL PRODUKSI TERBARU -->
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
                            <td class="fw-semibold">{{ number_format($produksi->jumlah_produksi) }}</td>
                            <td>{{ number_format($produksi->telur_bagus) }}</td>
                            <td>{{ number_format($produksi->telur_reject) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada data produksi telur.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const LABELS = {!! json_encode($chartLabels) !!};

    new Chart(document.getElementById('productionChart'), {
        type: 'line',
        data: {
            labels: LABELS,
            datasets: [{
                label: 'Produksi Telur',
                data: {!! json_encode($chartData) !!},
                tension: 0.4,
                fill: true,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });

    new Chart(document.getElementById('salesChart'), {
        type: 'bar',
        data: {
            labels: LABELS,
            datasets: [{
                label: 'Penjualan (Rp)',
                data: {!! json_encode($penjualanData) !!},
                backgroundColor: 'rgba(109, 76, 65, 0.8)',
                borderColor: '#5d4037',
                borderWidth: 1,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + Number(ctx.parsed.y).toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: v => 'Rp ' + (v / 1000).toLocaleString('id-ID') + 'rb' }
                }
            }
        }
    });

    new Chart(document.getElementById('mortalityChart'), {
        type: 'bar',
        data: {
            labels: LABELS,
            datasets: [
                {
                    label: 'Mati',
                    data: {!! json_encode($kematianMati) !!},
                    backgroundColor: 'rgba(220, 53, 69, 0.75)',
                    borderRadius: 6
                },
                {
                    label: 'Afkir',
                    data: {!! json_encode($kematianAfkir) !!},
                    backgroundColor: 'rgba(255, 193, 7, 0.75)',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });
</script>
@endpush
