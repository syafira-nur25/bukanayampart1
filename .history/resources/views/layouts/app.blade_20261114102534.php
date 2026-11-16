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
--sidebar: #1e3a5f;
--sidebar-hover: #2c5282;
--background: #f0f4f8;
--card: #ffffff;
--text: #1a202c;
--muted: #718096;
--border: #e2e8f0;
--drawer-width: 380px;
--sidebar-width: 260px;
}
* { box-sizing: border-box; }
body { margin: 0; font-family: 'Inter', sans-serif; background: var(--background); color: var(--text); }
.sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; left: 0; top: 0; background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%); color: white; z-index: 1000; transition: transform .3s ease; overflow-y: auto; }
.brand { height: 75px; display: flex; align-items: center; justify-content: center; padding: 0 24px; border-bottom: 1px solid rgba(255,255,255,0.1); }
.brand-logo { height: 46px; width: auto; object-fit: contain; display: block; }
.brand-icon { width: 42px; height: 42px; display: none; align-items: center; justify-content: center; background: rgba(255,255,255,0.15); border-radius: 12px; font-size: 22px; flex-shrink: 0; }
.brand-icon i { display: inline-block; animation: wobble 2.6s ease-in-out infinite; }
.sidebar-content { padding: 20px 14px; }
.menu-title { font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.5); text-transform: uppercase; padding: 15px 12px 8px; letter-spacing: 0.8px; }
.sidebar a { color: rgba(255,255,255,0.75); text-decoration: none; display: flex; align-items: center; gap: 12px; padding: 11px 13px; border-radius: 9px; margin-bottom: 3px; font-size: 14px; transition: 0.2s; }
.sidebar a:hover { background: var(--sidebar-hover); color: white; }
.sidebar a.active { background: rgba(255,255,255,0.15); color: white; border-left: 3px solid var(--accent); }
.sidebar a i { font-size: 17px; }
.sidebar-footer { padding: 14px; border-top: 1px solid rgba(255,255,255,0.1); margin-top: 20px; }
.sidebar-overlay { position: fixed; inset: 0; background: rgba(20,10,5,.5); z-index: 999; opacity: 0; visibility: hidden; transition: opacity .25s ease, visibility .25s ease; }
.main { margin-left: var(--sidebar-width); min-height: 100vh; transition: margin-left .3s ease, width .35s ease; width: calc(100% - var(--sidebar-width)); }
.main.drawer-open { width: calc(100% - var(--sidebar-width) - var(--drawer-width)); }
.topbar { height: 75px; background: white; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 30px; gap: 12px; position: sticky; top: 0; z-index: 900; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
.topbar-left { display: flex; align-items: center; gap: 12px; min-width: 0; }
.page-title { font-size: 18px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.page-subtitle { font-size: 12px; color: var(--muted); margin-top: 2px; }
.profile { display: flex; align-items: center; gap: 10px; }
.profile-avatar { width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #3b82f6, #2c5282); color: white; border-radius: 50%; font-weight: 700; flex-shrink: 0; }
.btn-logout { background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #ffffff; padding: 6px 12px; border-radius: 8px; font-size: 13px; cursor: pointer; transition: 0.2s; }
.btn-logout:hover { background: rgba(239, 68, 68, 0.2); color: #fca5a5; border-color: rgba(239, 68, 68, 0.4); }
.content { padding: 30px; }
.btn-toggle-sidebar {
width: 40px; height: 40px; flex-shrink: 0;
display: none; align-items: center; justify-content: center;
background: #fff; border: 1px solid var(--border); border-radius: 10px;
font-size: 18px; color: var(--text); cursor: pointer; transition: .2s;
}
.btn-toggle-sidebar:hover { background: var(--background); }
.stat-card { background: white; border: 1px solid var(--border); border-radius: 16px; padding: 20px; height: 100%; transition: 0.2s; position: relative; overflow: hidden; }
.stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #3b82f6, #2c5282); }
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(30,58,95,0.1); }
.stat-top { display: flex; justify-content: space-between; align-items: center; }
.stat-icon { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 20px; flex-shrink: 0; }
.icon-green { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.icon-blue { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
.icon-yellow { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
.icon-red { background: rgba(239, 68, 68, 0.12); color: #ef4444; }
.stat-label { color: var(--muted); font-size: 13px; margin-top: 16px; }
.stat-value { font-size: 27px; font-weight: 800; margin-top: 4px; }
.stat-description { color: var(--muted); font-size: 11px; margin-top: 4px; }
.panel { background: white; border: 1px solid var(--border); border-radius: 16px; padding: 22px; height: 100%; }
.panel-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.panel-title { font-size: 16px; font-weight: 700; }
.panel-link { color: #3b82f6; text-decoration: none; font-size: 13px; font-weight: 600; }
.table { vertical-align: middle; }
.table thead th { font-size: 12px; color: var(--muted); font-weight: 600; border-bottom: 1px solid var(--border); }
.table tbody td { font-size: 13px; border-color: var(--border); }
.btn-primary { background: #3b82f6; border-color: #3b82f6; }
.btn-primary:hover { background: #2c5282; border-color: #2c5282; }
.btn-success { background: #10b981; border-color: #10b981; }
.btn-success:hover { background: #059669; border-color: #059669; }
.badge.bg-success { background: #10b981 !important; }
@keyframes wobble { 0%,100% { transform: rotate(0); } 25% { transform: rotate(-10deg); } 75% { transform: rotate(10deg); } }
.btn-float-laporan {
position: fixed; right: 22px; bottom: 22px; z-index: 1040;
width: 56px; height: 56px; border-radius: 50%;
background: #3b82f6; color: #fff; border: none; font-size: 22px;
box-shadow: 0 8px 20px rgba(59,130,246,.35);
display: flex; align-items: center; justify-content: center;
transition: transform .2s ease, background .2s ease, right .35s ease;
}
.btn-float-laporan:hover { transform: translateY(-3px); background: #2c5282; }
.btn-float-laporan .badge-count {
position: absolute; top: -4px; right: -4px;
background: #ef4444; color: #fff; font-size: 10px; font-weight: 700;
border-radius: 999px; padding: 3px 6px;
}
body.drawer-open .btn-float-laporan { right: calc(var(--drawer-width) + 22px); }
#laporanDrawer {
--bs-offcanvas-width: var(--drawer-width);
box-shadow: -8px 0 24px rgba(0,0,0,.18);
border-left: 1px solid var(--border);
}
.laporan-item { border: 1px solid var(--border); border-radius: 12px; padding: 10px 12px; margin-bottom: 10px; background: #fff; }
.laporan-item .head { display: flex; justify-content: space-between; align-items: center; font-size: 12px; font-weight: 700; margin-bottom: 6px; }
.laporan-item .grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 4px; text-align: center; }
.laporan-item .grid .v { font-weight: 700; font-size: 13px; }
.laporan-item .grid .l { font-size: 10px; color: var(--muted); }
@media (min-width: 992px) {
.btn-toggle-sidebar { display: flex; }
body.sidebar-collapsed .sidebar { transform: translateX(-100%); }
body.sidebar-collapsed .main { margin-left: 0; width: 100%; }
body.sidebar-collapsed .main.drawer-open { width: calc(100% - var(--drawer-width)); }
}
@media (max-width: 991px) {
.btn-toggle-sidebar { display: flex; }
.sidebar { transform: translateX(-100%); }
body.sidebar-open .sidebar { transform: translateX(0); box-shadow: 0 0 40px rgba(0,0,0,.35); }
body.sidebar-open .sidebar-overlay { opacity: 1; visibility: visible; }
.main { margin-left: 0; width: 100% !important; }
.main.drawer-open { width: 100% !important; }
body.drawer-open .btn-float-laporan { right: 22px; }
.content { padding: 16px; }
.topbar { padding: 0 16px; height: 64px; }
.page-title { font-size: 16px; }
.page-subtitle { font-size: 11px; }
.stat-value { font-size: 22px; }
.brand { height: 64px; }
}
@media (max-width: 480px) {
#laporanDrawer { --bs-offcanvas-width: min(var(--drawer-width), 92vw); }
.content { padding: 12px; }
}
body.role-umum .admin-only,
body.role-umum a.btn[href$="/create"],
body.role-umum a.btn[href*="/edit"],
body.role-umum form[method="POST"]:not([action*="logout"]) button.btn-danger,
body.role-umum form[method="POST"]:not([action*="logout"]) button.btn-warning {
display: none !important;
}
body.role-umum .readonly-banner {
background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); color: #1e40af;
border-radius: 12px; padding: 10px 14px; font-size: 13px; margin-bottom: 18px;
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
<img src="{{ asset('logo.png') }}" alt="Logo" class="brand-logo"
onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
<div class="brand-icon"><i class="bi bi-egg-fried"></i></div>
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
<button type="submit" class="btn-logout w-100 text-start d-flex align-items-center gap-2">
<i class="bi bi-box-arrow-right"></i> Keluar
</button>
</form>
</div>
</aside>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<div class="main" id="mainArea">
<header class="topbar">
<div class="topbar-left">
<button class="btn-toggle-sidebar" id="btnToggleSidebar" type="button" title="Buka / tutup menu">
<i class="bi bi-list"></i>
</button>
<div>
<div class="page-title">@yield('title', 'Dashboard')</div>
<div class="page-subtitle">Sistem Manajemen Peternakan Ayam</div>
</div>
</div>
<div class="profile">
@auth
<div class="profile-avatar">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>
<div class="d-none d-md-block">
<div style="font-size:13px;font-weight:600;">{{ $user->name ?? 'User' }}</div>
<div style="font-size:11px;color:#718096;">{{ ucfirst($user->role ?? 'user') }}</div>
</div>
@else
<div class="profile-avatar">?</div>
@endauth
</div>
</header>
<main class="content">
@if(session('success'))
<div class="alert alert-success border-0 shadow-sm">
<i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif
@if($errors->any())
<div class="alert alert-danger border-0 shadow-sm">
<strong>Terjadi kesalahan:</strong>
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
var btn     = document.getElementById('btnToggleSidebar');
var overlay = document.getElementById('sidebarOverlay');
var sidebar = document.getElementById('sidebar');
function isMobile() { return window.innerWidth < 992; }
if (btn) btn.addEventListener('click', function () {
if (isMobile()) document.body.classList.toggle('sidebar-open');
else            document.body.classList.toggle('sidebar-collapsed');
});
if (overlay) overlay.addEventListener('click', function () {
document.body.classList.remove('sidebar-open');
});
if (sidebar) sidebar.querySelectorAll('a').forEach(function (a) {
a.addEventListener('click', function () {
if (isMobile()) document.body.classList.remove('sidebar-open');
});
});
window.addEventListener('resize', function () {
if (!isMobile()) document.body.classList.remove('sidebar-open');
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
<div class="offcanvas-header" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color:#fff;">
<h5 class="offcanvas-title fw-bold" id="laporanDrawerLabel">
<i class="bi bi-clipboard2-data-fill me-2"></i>Laporan Harian Terbaru
</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
@forelse($laporanFloating as $lap)
<div class="laporan-item">
<div class="head">
<span>{{ $lap->tanggal->format('d/m/Y') }}</span>
<span class="badge" style="background:#3b82f6;color:#fff;">
{{ $lap->kandang->nama ?? '-' }}
</span>
</div>
<div class="grid">
<div><div class="v">{{ number_format($lap->hidup) }}</div><div class="l">Hidup</div></div>
<div><div class="v text-danger">{{ number_format($lap->mati) }}</div><div class="l">Mati</div></div>
<div><div class="v text-warning">{{ number_format($lap->afkir) }}</div><div class="l">Afkir</div></div>
<div><div class="v text-success">{{ number_format($lap->sisa_ayam) }}</div><div class="l">Sisa</div></div>
</div>
<div class="grid mt-1">
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
<a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-primary w-100">
Lihat Semua Laporan
</a>
</div>
</div>
<script>
(function () {
var drawer   = document.getElementById('laporanDrawer');
var mainArea = document.getElementById('mainArea');
var btnFloat = document.querySelector('.btn-float-laporan');
if (!drawer || !mainArea) return;
function buka()  { mainArea.classList.add('drawer-open');    document.body.classList.add('drawer-open'); }
function tutup() { mainArea.classList.remove('drawer-open'); document.body.classList.remove('drawer-open'); }
drawer.addEventListener('show.bs.offcanvas', buka);
drawer.addEventListener('hide.bs.offcanvas', tutup);
drawer.addEventListener('shown.bs.offcanvas', buka);
drawer.addEventListener('hidden.bs.offcanvas', tutup);
if (btnFloat) btnFloat.addEventListener('click', function () {
setTimeout(function () {
drawer.classList.contains('show') ? buka() : tutup();
}, 50);
});
var btnClose = drawer.querySelector('[data-bs-dismiss="offcanvas"]');
if (btnClose) btnClose.addEventListener('click', tutup);
})();
</script>
@endif
</body>
</html>
p