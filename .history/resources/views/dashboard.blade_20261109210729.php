@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<style>
#chart-produksi, #chart-penjualan, #chart-kematian {
    scroll-margin-top: 95px;
}
.welcome-banner {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    border-radius: 20px;
    padding: 32px;
    color: white;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
}
.welcome-banner::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
}
.welcome-banner::after {
    content: '';
    position: absolute;
    bottom: -30%;
    right: 10%;
    width: 250px;
    height: 250px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}
.welcome-title {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 8px;
    position: relative;
    z-index: 1;
}
.welcome-subtitle {
    font-size: 14px;
    opacity: 0.9;
    position: relative;
    z-index: 1;
}
.quick-action-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 18px;
    transition: 0.25s;
    cursor: pointer;
    text-decoration: none;
    color: var(--text);
    display: block;
    height: 100%;
}
.quick-action-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 24px rgba(30, 58, 95, 0.12);
    border-color: var(--accent-light);
}
.quick-action-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-bottom: 12px;
}
.quick-action-title {
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 4px;
}
.quick-action-desc {
    font-size: 11px;
    color: var(--text-muted);
}
.chart-container {
    position: relative;
    height: 280px;
}
</style>

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="welcome-title">Selamat Datang di FARM2025</div>
            <div class="welcome-subtitle">
                Pantau kondisi peternakan Anda secara real-time. Kelola kandang, produksi telur, dan keuangan dengan mudah.
            </div>
        </div>
        <div class="col-md-4 text-end d-none d-md-block">
            <i class="bi bi-egg-fried" style="font-size: 80px; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Total Kandang</div>
                    <div class="stat-value">{{ $totalKandang ?? 0 }}</div>
                </div>
                <div class="stat-icon icon-blue"><i class="bi bi-house-door-fill"></i></div>
            </div>
            <div class="stat-description">Kandang aktif terdaftar</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Populasi Ayam</div>
                    <div class="stat-value">{{ number_format($totalAyam ?? 0) }}</div>
                </div>
                <div class="stat-icon icon-green"><i class="bi bi-people-fill"></i></div>
            </div>
            <div class="stat-description">Jumlah sisa terbaru tiap kandang</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Produksi Telur</div>
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
                    <div class="stat-label">Total Penjualan</div>
                    <div class="stat-value" style="font-size: 22px;">Rp {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon icon-purple"><i class="bi bi-cash-stack"></i></div>
            </div>
            <div class="stat-description">Total pendapatan penjualan</div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4" id="chart-produksi">
    <div class="col-xl-8">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Produksi Telur</div>
                    <div class="text-muted small">Harian — {{ $labelBulanProduksi }}</div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <form method="GET" class="m-0" action="#chart-produksi">
                        <input type="hidden" name="bulan_penjualan" value="{{ $bulanPenjualan }}">
                        <input type="hidden" name="bulan_kematian" value="{{ $bulanKematian }}">
                        <select name="bulan_produksi" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                            <option value="all" @selected($bulanProduksi === 'all')>Semua Bulan</option>
                            @foreach ($daftarBulanProduksi as $b)
                                <option value="{{ $b }}" @selected($b === $bulanProduksi)>
                                    {{ $namaBulan[(int) substr($b, 5, 2)] }} {{ substr($b, 0, 4) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    <a href="{{ route('produksi-telur.index') }}" class="panel-link">Lihat semua <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="productionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-xl-4 admin-only">
        <div class="panel h-100">
            <div class="panel-header">
                <div class="panel-title">Akses Cepat</div>
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <a href="{{ route('kandang.create') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-blue"><i class="bi bi-house-add-fill"></i></div>
                        <div class="quick-action-title">Tambah Kandang</div>
                        <div class="quick-action-desc">Daftarkan kandang baru</div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('populasi.create') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-green"><i class="bi bi-plus-circle-fill"></i></div>
                        <div class="quick-action-title">Input Populasi</div>
                        <div class="quick-action-desc">Catat populasi ayam</div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('produksi-telur.create') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-yellow"><i class="bi bi-egg-fill"></i></div>
                        <div class="quick-action-title">Produksi Telur</div>
                        <div class="quick-action-desc">Input hasil produksi</div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('penjualan-telur.create') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-purple"><i class="bi bi-cart-plus-fill"></i></div>
                        <div class="quick-action-title">Catat Penjualan</div>
                        <div class="quick-action-desc">Input transaksi jual</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales Chart -->
<div class="row g-4 mb-4" id="chart-penjualan">
    <div class="col-xl-8">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Pendapatan Penjualan</div>
                    <div class="text-muted small">Harian — {{ $labelBulanPenjualan }} (Rp)</div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <form method="GET" class="m-0" action="#chart-penjualan">
                        <input type="hidden" name="bulan_produksi" value="{{ $bulanProduksi }}">
                        <input type="hidden" name="bulan_kematian" value="{{ $bulanKematian }}">
                        <select name="bulan_penjualan" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                            <option value="all" @selected($bulanPenjualan === 'all')>Semua Bulan</option>
                            @foreach ($daftarBulanPenjualan as $b)
                                <option value="{{ $b }}" @selected($b === $bulanPenjualan)>
                                    {{ $namaBulan[(int) substr($b, 5, 2)] }} {{ substr($b, 0, 4) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    <a href="{{ route('penjualan-telur.index') }}" class="panel-link">Lihat semua <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="stat-card h-100 d-flex flex-column justify-content-center">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Rata-rata / {{ $bulanPenjualan === 'all' ? 'bulan' : 'hari' }}</div>
                    <div class="stat-value" style="font-size: 22px;">Rp {{ number_format($avgSales, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon icon-green"><i class="bi bi-graph-up-arrow"></i></div>
            </div>
            <div class="stat-description mt-3">
                Total {{ $labelBulanPenjualan }}: <strong>Rp {{ number_format($sumSales, 0, ',', '.') }}</strong>
            </div>
            <hr class="my-3">
            <div class="small">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Target Bulanan</span>
                    <span class="fw-bold">75%</span>
                </div>
                <div class="progress" style="height: 8px; border-radius: 4px;">
                    <div class="progress-bar bg-success" style="width: 75%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mortality Chart -->
<div class="row g-4 mb-4" id="chart-kematian">
    <div class="col-12">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Grafik Kematian Ayam</div>
                    <div class="text-muted small">
                        Mati & afkir harian — sumber: Data Populasi (input admin) — {{ $labelBulanKematian }}
                    </div>
                </div>
                <form method="GET" class="m-0" action="#chart-kematian">
                    <input type="hidden" name="bulan_produksi" value="{{ $bulanProduksi }}">
                    <input type="hidden" name="bulan_penjualan" value="{{ $bulanPenjualan }}">
                    <select name="bulan_kematian" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                        <option value="all" @selected($bulanKematian === 'all')>Semua Bulan</option>
                        @foreach ($daftarBulanKematian as $b)
                            <option value="{{ $b }}" @selected($b === $bulanKematian)>
                                {{ $namaBulan[(int) substr($b, 5, 2)] }} {{ substr($b, 0, 4) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="chart-container">
                <canvas id="mortalityChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Latest Production Table -->
<div class="row g-4">
    <div class="col-12">
        <div class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Produksi Terbaru</div>
                    <div class="text-muted small">Data produksi telur terakhir</div>
                </div>
                <a href="{{ route('produksi-telur.index') }}" class="panel-link">Lihat semua <i class="bi bi-arrow-right"></i></a>
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
                                <td><span class="badge bg-primary">{{ $produksi->kandang->nama ?? '-' }}</span></td>
                                <td class="fw-bold">{{ number_format($produksi->jumlah_produksi) }}</td>
                                <td><span class="text-success fw-bold">{{ number_format($produksi->telur_bagus) }}</span></td>
                                <td><span class="text-danger">{{ number_format($produksi->telur_reject) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
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
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color = '#718096';

/* Production Chart */
new Chart(document.getElementById('productionChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabelsProduksi) !!},
        datasets: [{
            label: 'Produksi Telur',
            data: {!! json_encode($chartDataProduksi) !!},
            tension: 0.4,
            fill: true,
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            borderColor: '#3b82f6',
            borderWidth: 3,
            pointBackgroundColor: '#3b82f6',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(0,0,0,0.05)' } },
            x: { grid: { display: false } }
        }
    }
});

/* Sales Chart */
new Chart(document.getElementById('salesChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartLabelsPenjualan) !!},
        datasets: [{
            label: 'Penjualan (Rp)',
            data: {!! json_encode($chartDataPenjualan) !!},
            backgroundColor: 'rgba(139, 92, 246, 0.8)',
            borderColor: '#8b5cf6',
            borderWidth: 0,
            borderRadius: 8,
            barPercentage: 0.6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
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
                ticks: { callback: v => 'Rp ' + (v / 1000).toLocaleString('id-ID') + 'rb' },
                grid: { color: 'rgba(0,0,0,0.05)' }
            },
            x: { grid: { display: false } }
        }
    }
});

/* Mortality Chart */
new Chart(document.getElementById('mortalityChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartLabelsKematian) !!},
        datasets: [
            {
                label: 'Mati',
                data: {!! json_encode($kematianMati) !!},
                backgroundColor: 'rgba(239, 68, 68, 0.8)',
                borderRadius: 6,
                barPercentage: 0.5
            },
            {
                label: 'Afkir',
                data: {!! json_encode($kematianAfkir) !!},
                backgroundColor: 'rgba(245, 158, 11, 0.8)',
                borderRadius: 6,
                barPercentage: 0.5
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(0,0,0,0.05)' } },
            x: { grid: { display: false } }
        }
    }
});

(function () {
    if (window.location.hash) {
        var el = document.querySelector(window.location.hash);
        if (el) {
            setTimeout(function () {
                el.scrollIntoView({ behavior: 'auto', block: 'start' });
            }, 60);
        }
    }
})();
</script>
@endpush
