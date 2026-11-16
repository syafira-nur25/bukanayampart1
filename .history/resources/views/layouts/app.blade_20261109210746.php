<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Farm Management')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
    --primary: #1e3a5f;
    --primary-dark: #152a45;
    --primary-light: #2c5282;
    --accent: #3b82f6;
    --accent-light: #60a5fa;
    --sidebar: #1e3a5f;
    --sidebar-hover: #2c5282;
    --background: #f0f4f8;
    --card: #ffffff;
    --text: #1a202c;
    --text-muted: #718096;
    --border: #e2e8f0;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #3b82f6;
    --drawer-width: 380px;
    --sidebar-width: 260px;
    --topbar-height: 70px;
}
* { box-sizing: border-box; }
body { margin: 0; font-family: 'Inter', sans-serif; background: var(--background); color: var(--text); }

/* ===== SIDEBAR ===== */
.sidebar {
    width: var(--sidebar-width);
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    z-index: 1000;
    transition: transform .3s ease;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}
.brand {
    height: 80px;
    display: flex;
    align-items: center;
    padding: 0 24px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    background: rgba(0,0,0,0.1);
}
.brand-logo-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
}
.brand-icon {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.15);
    border-radius: 10px;
    font-size: 20px;
    flex-shrink: 0;
}
.brand-icon i { display: inline-block; }
.brand-text {
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 0.5px;
}
.brand-sub {
    font-size: 10px;
    color: rgba(255,255,255,0.6);
    font-weight: 500;
}
.sidebar-content { padding: 20px 14px; flex: 1; }
.menu-title {
    font-size: 10px;
    font-weight: 700;
    color: rgba(255,255,255,0.5);
    text-transform: uppercase;
    padding: 15px 12px 8px;
    letter-spacing: 1px;
}
.sidebar a {
    color: rgba(255,255,255,0.75);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 11px 13px;
    border-radius: 10px;
    margin-bottom: 3px;
    font-size: 13.5px;
    font-weight: 500;
    transition: 0.2s;
}
.sidebar a:hover {
    background: var(--sidebar-hover);
    color: white;
}
.sidebar a.active {
    background: rgba(255,255,255,0.15);
    color: white;
    border-left: 3px solid var(--accent-light);
}
.sidebar a i { font-size: 17px; width: 20px; text-align: center; }
.sidebar-footer {
    padding: 14px;
    border-top: 1px solid rgba(255,255,255,0.1);
    margin-top: auto;
}
.btn-logout {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    color: white;
    padding: 10px 14px;
    border-radius: 10px;
    font-size: 13px;
    cursor: pointer;
    width: 100%;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: 0.2s;
    font-weight: 500;
}
.btn-logout:hover {
    background: rgba(239, 68, 68, 0.2);
    border-color: rgba(239, 68, 68, 0.4);
    color: #fca5a5;
}

/* ===== MAIN AREA ===== */
.main {
    margin-left: var(--sidebar-width);
    min-height: 100vh;
    transition: margin-left .3s ease;
}

/* ===== TOPBAR ===== */
.topbar {
    height: var(--topbar-height);
    background: white;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 30px;
    gap: 12px;
    position: sticky;
    top: 0;
    z-index: 900;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.topbar-left {
    display: flex;
    align-items: center;
    gap: 16px;
}
.topbar-brand {
    font-size: 18px;
    font-weight: 800;
    color: var(--primary);
    letter-spacing: 0.5px;
}
.topbar-right {
    display: flex;
    align-items: center;
    gap: 16px;
}
.topbar-icon {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--background);
    border-radius: 10px;
    color: var(--text-muted);
    font-size: 18px;
    cursor: pointer;
    transition: 0.2s;
    border: none;
}
.topbar-icon:hover {
    background: var(--primary);
    color: white;
}
.profile-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 6px 12px 6px 6px;
    background: var(--background);
    border-radius: 30px;
    cursor: pointer;
}
.profile-avatar {
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--accent), var(--primary-light));
    color: white;
    border-radius: 50%;
    font-weight: 700;
    font-size: 13px;
    flex-shrink: 0;
}
.profile-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
}
.profile-role {
    font-size: 10px;
    color: var(--text-muted);
}

/* ===== CONTENT ===== */
.content { padding: 30px; }

/* ===== PAGE HEADER ===== */
.page-header {
    margin-bottom: 28px;
}
.page-title {
    font-size: 26px;
    font-weight: 800;
    color: var(--text);
    margin-bottom: 6px;
}
.page-subtitle {
    font-size: 13px;
    color: var(--text-muted);
}

/* ===== STAT CARDS ===== */
.stat-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 22px;
    height: 100%;
    transition: 0.25s;
    position: relative;
    overflow: hidden;
}
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(30, 58, 95, 0.12);
    border-color: var(--accent-light);
}
.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--accent), var(--primary-light));
}
.stat-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
}
.stat-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 22px;
    flex-shrink: 0;
}
.icon-blue { background: rgba(59, 130, 246, 0.12); color: var(--accent); }
.icon-green { background: rgba(16, 185, 129, 0.12); color: var(--success); }
.icon-yellow { background: rgba(245, 158, 11, 0.12); color: var(--warning); }
.icon-red { background: rgba(239, 68, 68, 0.12); color: var(--danger); }
.icon-purple { background: rgba(139, 92, 246, 0.12); color: #8b5cf6; }
.stat-label {
    color: var(--text-muted);
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}
.stat-value {
    font-size: 28px;
    font-weight: 800;
    color: var(--text);
    line-height: 1.1;
}
.stat-description {
    color: var(--text-muted);
    font-size: 11.5px;
    margin-top: 8px;
}

/* ===== PANELS ===== */
.panel {
    background: white;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    height: 100%;
}
.panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
}
.panel-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--text);
}
.panel-link {
    color: var(--accent);
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
}
.panel-link:hover { color: var(--primary); }

/* ===== TABLES ===== */
.table { vertical-align: middle; }
.table thead th {
    font-size: 11px;
    color: var(--text-muted);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--border);
    padding: 12px 16px;
}
.table tbody td {
    font-size: 13px;
    border-color: var(--border);
    padding: 14px 16px;
}
.table tbody tr:hover { background: rgba(59, 130, 246, 0.03); }

/* ===== BUTTONS ===== */
.btn-primary {
    background: linear-gradient(135deg, var(--accent), var(--primary-light));
    border-color: var(--accent);
    font-weight: 600;
    border-radius: 10px;
    padding: 9px 18px;
}
.btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-light), var(--primary));
    border-color: var(--primary);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}
.btn-success {
    background: linear-gradient(135deg, var(--success), #059669);
    border-color: var(--success);
    font-weight: 600;
    border-radius: 10px;
}
.btn-warning {
    background: linear-gradient(135deg, var(--warning), #d97706);
    border-color: var(--warning);
    font-weight: 600;
    border-radius: 10px;
    color: white;
}
.btn-danger {
    background: linear-gradient(135deg, var(--danger), #dc2626);
    border-color: var(--danger);
    font-weight: 600;
    border-radius: 10px;
}
.btn-info {
    background: linear-gradient(135deg, var(--info), var(--primary-light));
    border-color: var(--info);
    font-weight: 600;
    border-radius: 10px;
    color: white;
}
.btn-secondary {
    background: white;
    border: 1px solid var(--border);
    color: var(--text);
    font-weight: 600;
    border-radius: 10px;
}
.btn-secondary:hover {
    background: var(--background);
    border-color: var(--text-muted);
}

/* ===== BADGES ===== */
.badge {
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 11px;
}
.badge.bg-success { background: rgba(16, 185, 129, 0.15) !important; color: var(--success); }
.badge.bg-warning { background: rgba(245, 158, 11, 0.15) !important; color: var(--warning); }
.badge.bg-danger { background: rgba(239, 68, 68, 0.15) !important; color: var(--danger); }
.badge.bg-info { background: rgba(59, 130, 246, 0.15) !important; color: var(--info); }
.badge.bg-primary { background: rgba(59, 130, 246, 0.15) !important; color: var(--accent); }

/* ===== ALERTS ===== */
.alert {
    border-radius: 12px;
    border: none;
    padding: 14px 18px;
    font-size: 13px;
}
.alert-success {
    background: rgba(16, 185, 129, 0.1);
    color: #065f46;
    border-left: 4px solid var(--success);
}
.alert-danger {
    background: rgba(239, 68, 68, 0.1);
    color: #991b1b;
    border-left: 4px solid var(--danger);
}

/* ===== FORMS ===== */
.form-control, .form-select {
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
    transition: 0.2s;
}
.form-control:focus, .form-select:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
.form-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 6px;
}

/* ===== FLOATING BUTTON ===== */
.btn-float-laporan {
    position: fixed;
    right: 24px;
    bottom: 24px;
    z-index: 1040;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--accent), var(--primary-light));
    color: white;
    border: none;
    font-size: 22px;
    box-shadow: 0 8px 24px rgba(59, 130, 246, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform .2s ease;
}
.btn-float-laporan:hover {
    transform: translateY(-3px) scale(1.05);
}
.btn-float-laporan .badge-count {
    position: absolute;
    top: -4px;
    right: -4px;
    background: var(--danger);
    color: white;
    font-size: 10px;
    font-weight: 700;
    border-radius: 999px;
    padding: 3px 7px;
    border: 2px solid white;
}

/* ===== DRAWER ===== */
#laporanDrawer {
    --bs-offcanvas-width: 380px;
    box-shadow: -8px 0 24px rgba(0,0,0,0.15);
}
.laporan-item {
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 12px;
    margin-bottom: 10px;
    background: white;
    transition: 0.2s;
}
.laporan-item:hover {
    border-color: var(--accent-light);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}
.laporan-item .head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 8px;
}
.laporan-item .grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 4px;
    text-align: center;
}
.laporan-item .grid .v { font-weight: 700; font-size: 13px; }
.laporan-item .grid .l { font-size: 10px; color: var(--text-muted); }

/* ===== RESPONSIVE ===== */
@media (max-width: 991px) {
    .sidebar { transform: translateX(-100%); }
    body.sidebar-open .sidebar { transform: translateX(0); box-shadow: 0 0 40px rgba(0,0,0,0.35); }
    .main { margin-left: 0; width: 100% !important; }
    .content { padding: 16px; }
    .topbar { padding: 0 16px; }
    .page-title { font-size: 20px; }
    .stat-value { font-size: 22px; }
    .brand { height: 64px; }
}
@media (max-width: 480px) {
    #laporanDrawer { --bs-offcanvas-width: min(380px, 92vw); }
    .content { padding: 12px; }
}

/* ===== ROLE UMUM ===== */
body.role-umum .admin-only,
body.role-umum a.btn[href$="/create"],
body.role-umum a.btn[href*="/edit"],
body.role-umum form[method="POST"]:not([action*="logout"]) button.btn-danger,
body.role-umum form[method="POST"]:not([action*="logout"]) button.btn-warning {
    display: none !important;
}
</style>
@stack('styles')
</head>
<body class="{{ auth()->user()?->role === 'umum' ? 'role-umum' : '' }}">
@php
$user = auth()->user();
$isAdmin = $user && ($user->role ?? '') === 'admin';
@endphp

<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="brand-logo-wrap">
            <div class="brand-icon"><i class="bi bi-egg-fried"></i></div>
            <div>
                <div class="brand-text">FARM2025</div>
                <div class="brand-sub">Peternakan Ayam</div>
            </div>
        </div>
    </div>

    <div class="sidebar-content">
        @if ($isAdmin || ($user->role ?? '') === 'umum')
            <div class="menu-title">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>

            <div class="menu-title">Data Peternakan</div>
            <a href="{{ route('kandang.index') }}" class="{{ request()->is('kandang*') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill"></i> Kandang
            </a>
            <a href="{{ route('populasi.index') }}" class="{{ request()->is('populasi*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Populasi Ayam
            </a>
            <a href="{{ route('bobot.index') }}" class="{{ request()->is('bobot*') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Bobot Ayam
            </a>

            <div class="menu-title">Produksi</div>
            <a href="{{ route('produksi-telur.index') }}" class="{{ request()->is('produksi-telur*') ? 'active' : '' }}">
                <i class="bi bi-egg-fill"></i> Produksi Telur
            </a>
            <a href="{{ route('penjualan-telur.index') }}" class="{{ request()->is('penjualan-telur*') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i> Penjualan Telur
            </a>
            <a href="{{ route('stok-telur.index') }}" class="{{ request()->is('stok-telur*') ? 'active' : '' }}">
                <i class="bi bi-boxes"></i> Stok Telur
            </a>
            <a href="{{ route('gudang-telur.index') }}" class="{{ request()->is('gudang-telur*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> Gudang Telur
            </a>

            <div class="menu-title">Keuangan</div>
            <a href="{{ route('arus-kas.index') }}" class="{{ request()->is('arus-kas*') ? 'active' : '' }}">
                <i class="bi bi-cash-coin"></i> Arus Kas
            </a>

            <div class="menu-title">Pakan</div>
            <a href="{{ route('pakan-kandang.index') }}" class="{{ request()->is('pakan-kandang*') ? 'active' : '' }}">
                <i class="bi bi-box-seam-fill"></i> Stok Pakan
            </a>
            <a href="{{ route('pemberian-pakan.index') }}" class="{{ request()->is('pemberian-pakan*') ? 'active' : '' }}">
                <i class="bi bi-basket-fill"></i> Pemberian Pakan
            </a>
            <a href="{{ route('pakan.laporan') }}" class="{{ request()->is('laporan-pakan*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-fill"></i> Laporan Pakan
            </a>

            <div class="menu-title">Man Power</div>
            <a href="{{ route('admin.laporan.index') }}" class="{{ request()->is('admin/laporan*') ? 'active' : '' }}">
                <i class="bi bi-clipboard2-data-fill"></i> Laporan Harian
            </a>
        @else
            <div class="menu-title">Menu</div>
            <a href="{{ route('manpower.laporan.create') }}" class="{{ request()->routeIs('manpower.laporan.*') ? 'active' : '' }}">
                <i class="bi bi-pencil-square"></i> Input Laporan Harian
            </a>
        @endif
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}" class="mb-0">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </button>
        </form>
    </div>
</aside>

<div class="main" id="mainArea">
    <header class="topbar">
        <div class="topbar-left">
            <button class="btn btn-secondary d-lg-none" id="btnToggleSidebar" type="button" style="padding: 8px 12px;">
                <i class="bi bi-list"></i>
            </button>
            <div class="topbar-brand">FARM2025</div>
        </div>
        <div class="topbar-right">
            <button class="topbar-icon" title="Notifikasi">
                <i class="bi bi-bell"></i>
            </button>
            <button class="topbar-icon" title="Bantuan">
                <i class="bi bi-question-circle"></i>
            </button>
            <div class="profile-wrap">
                <div class="profile-avatar">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>
                <div class="d-none d-md-block">
                    <div class="profile-name">{{ $user->name ?? 'User' }}</div>
                    <div class="profile-role">{{ ucfirst($user->role ?? 'user') }}</div>
                </div>
            </div>
        </div>
    </header>

    <main class="content">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <strong><i class="bi bi-exclamation-triangle-fill me-1"></i> Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

<script>
(function () {
    var btn = document.getElementById('btnToggleSidebar');
    if (btn) btn.addEventListener('click', function () {
        document.body.classList.toggle('sidebar-open');
    });
})();
</script>

@if ($isAdmin)
@php
$laporanFloating = \App\Models\LaporanHarian::with('kandang')
    ->latest('tanggal')->latest('id')->limit(12)->get();
$laporanHariIni = \App\Models\LaporanHarian::whereDate('tanggal', today())->count();
@endphp
<button class="btn-float-laporan" type="button" data-bs-toggle="offcanvas"
    data-bs-target="#laporanDrawer" aria-controls="laporanDrawer"
    title="Lihat laporan harian terbaru">
    <i class="bi bi-clipboard2-data-fill"></i>
    @if($laporanHariIni > 0)
        <span class="badge-count">{{ $laporanHariIni }}</span>
    @endif
</button>

<div class="offcanvas offcanvas-end" tabindex="-1" id="laporanDrawer"
    aria-labelledby="laporanDrawerLabel"
    data-bs-backdrop="false"
    data-bs-scroll="true">
    <div class="offcanvas-header" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color:white;">
        <h5 class="offcanvas-title fw-bold" id="laporanDrawerLabel">
            <i class="bi bi-clipboard2-data-fill me-2"></i>Laporan Harian Terbaru
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" style="background: var(--background);">
        @forelse($laporanFloating as $lap)
            <div class="laporan-item">
                <div class="head">
                    <span>{{ $lap->tanggal->format('d/m/Y') }}</span>
                    <span class="badge bg-primary">{{ $lap->kandang->nama ?? '-' }}</span>
                </div>
                <div class="grid">
                    <div><div class="v">{{ number_format($lap->hidup) }}</div><div class="l">Hidup</div></div>
                    <div><div class="v text-danger">{{ number_format($lap->mati) }}</div><div class="l">Mati</div></div>
                    <div><div class="v text-warning">{{ number_format($lap->afkir) }}</div><div class="l">Afkir</div></div>
                    <div><div class="v text-success">{{ number_format($lap->sisa_ayam) }}</div><div class="l">Sisa</div></div>
                </div>
                <div class="grid mt-2">
                    <div><div class="v">{{ number_format($lap->total_pakan, 0) }}</div><div class="l">Pakan (kg)</div></div>
                    <div><div class="v">{{ number_format($lap->produksi_telur) }}</div><div class="l">Telur</div></div>
                    <div><div class="v">{{ number_format($lap->telur_pecah) }}</div><div class="l">Pecah</div></div>
                    <div><div class="v">{{ $lap->umur_minggu }}</div><div class="l">Minggu</div></div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted small py-4">
                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                Belum ada laporan harian.
            </div>
        @endforelse
        <a href="{{ route('admin.laporan.index') }}" class="btn btn-primary w-100 mt-2">
            Lihat Semua Laporan
        </a>
    </div>
</div>
@endif
</body>
</html>
