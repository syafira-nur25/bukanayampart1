<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Farm Management')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
--drive-blue: #1a73e8;
--drive-blue-dark: #1557b0;
--drive-blue-light: #e8f0fe;
--drive-bg: #f8f9fa;
--drawer-width: 380px;
--sidebar-width: 280px;
}
* { box-sizing: border-box; }
body { margin: 0; font-family: 'Google Sans', 'Inter', sans-serif; background: var(--drive-bg); color: #202124; }

/* ===== SIDEBAR GOOGLE DRIVE STYLE ===== */
.sidebar {
width: var(--sidebar-width);
height: 100vh;
position: fixed;
left: 16px;
top: 16px;
bottom: 16px;
background: var(--drive-blue);
color: white;
z-index: 1000;
transition: transform .3s ease;
overflow-y: auto;
display: flex;
flex-direction: column;
padding: 20px 16px;
border-radius: 24px;
box-shadow: 0 4px 20px rgba(26, 115, 232, 0.3);
}
.sidebar::-webkit-scrollbar { width: 4px; }
.sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 4px; }

/* Brand */
.brand {
display: flex;
align-items: center;
gap: 12px;
padding: 8px 12px 20px;
border-bottom: 1px solid rgba(255,255,255,0.15);
margin-bottom: 20px;
}
.brand-logo-wrap { display: flex; align-items: center; gap: 12px; }
.brand-icon {
width: 40px;
height: 40px;
display: flex;
align-items: center;
justify-content: center;
flex-shrink: 0;
}
.brand-icon svg { width: 32px; height: 32px; }
.brand-text {
font-size: 20px;
font-weight: 700;
color: white;
letter-spacing: -0.3px;
}
.brand-text span { color: #a8c7fa; }
.brand-logo { height: 32px; width: auto; object-fit: contain; display: none; }

/* Upload Button */
.upload-btn {
display: flex;
align-items: center;
justify-content: center;
gap: 10px;
background: white;
color: var(--drive-blue);
border: none;
border-radius: 24px;
padding: 16px 24px;
margin: 0 4px 24px;
font-size: 15px;
font-weight: 600;
cursor: pointer;
transition: all .2s;
box-shadow: 0 2px 8px rgba(0,0,0,0.15);
text-decoration: none;
}
.upload-btn:hover {
background: #f1f3f4;
transform: translateY(-2px);
box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.upload-btn i {
font-size: 20px;
color: var(--drive-blue);
}

/* Menu */
.sidebar-content { flex: 1; padding: 0 4px; }
.menu-title {
font-size: 11px;
font-weight: 600;
color: rgba(255,255,255,0.7);
text-transform: uppercase;
letter-spacing: 1px;
padding: 16px 12px 8px;
}
.sidebar a {
color: rgba(255,255,255,0.9);
text-decoration: none;
display: flex;
align-items: center;
gap: 16px;
padding: 12px 16px;
border-radius: 24px;
margin-bottom: 4px;
font-size: 14px;
font-weight: 500;
transition: background .15s;
}
.sidebar a:hover {
background: rgba(255,255,255,0.15);
color: white;
}
.sidebar a.active {
background: rgba(255,255,255,0.2);
color: white;
font-weight: 600;
}
.sidebar a i {
font-size: 20px;
width: 24px;
text-align: center;
color: rgba(255,255,255,0.9);
}
.sidebar a.active i {
color: white;
}

/* Storage */
.storage-section {
padding: 20px 12px 8px;
border-top: 1px solid rgba(255,255,255,0.15);
margin-top: 16px;
}
.storage-label {
font-size: 11px;
font-weight: 600;
color: rgba(255,255,255,0.7);
text-transform: uppercase;
letter-spacing: 0.8px;
margin-bottom: 12px;
display: flex;
align-items: center;
gap: 6px;
}
.storage-label i { font-size: 14px; }
.storage-bar {
height: 6px;
background: rgba(255,255,255,0.2);
border-radius: 6px;
overflow: hidden;
margin-bottom: 10px;
}
.storage-bar-fill {
height: 100%;
background: white;
border-radius: 6px;
width: 35%;
transition: width .3s;
}
.storage-info {
font-size: 12px;
color: rgba(255,255,255,0.8);
margin-bottom: 12px;
}
.storage-info strong { color: white; font-weight: 600; }
.upgrade-link {
display: flex;
align-items: center;
gap: 6px;
font-size: 13px;
color: white;
text-decoration: none;
font-weight: 600;
padding: 8px 12px;
border-radius: 12px;
transition: background .15s;
}
.upgrade-link:hover { background: rgba(255,255,255,0.15); }

/* Logout */
.logout-btn {
display: flex;
align-items: center;
gap: 16px;
padding: 12px 16px;
border-radius: 24px;
margin: 4px;
font-size: 14px;
color: rgba(255,255,255,0.9);
cursor: pointer;
border: none;
background: transparent;
width: 100%;
text-align: left;
transition: background .15s;
font-weight: 500;
}
.logout-btn:hover { background: rgba(255,255,255,0.15); color: white; }
.logout-btn i { font-size: 20px; }

/* ===== MAIN AREA ===== */
.main {
margin-left: calc(var(--sidebar-width) + 32px);
min-height: 100vh;
transition: margin-left .3s ease, width .35s ease;
width: calc(100% - var(--sidebar-width) - 32px);
}
.main.drawer-open { width: calc(100% - var(--sidebar-width) - var(--drawer-width) - 32px); }

/* Topbar */
.topbar {
height: 64px;
background: white;
border-bottom: 1px solid #e8eaed;
display: flex;
align-items: center;
justify-content: space-between;
padding: 0 24px;
gap: 12px;
position: sticky;
top: 0;
z-index: 900;
}
.topbar-left { display: flex; align-items: center; gap: 12px; min-width: 0; }
.page-title { font-size: 18px; font-weight: 400; color: #202124; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.page-subtitle { font-size: 12px; color: #5f6368; margin-top: 2px; }
.profile { display: flex; align-items: center; gap: 10px; }
.profile-avatar {
width: 34px; height: 34px;
display: flex; align-items: center; justify-content: center;
background: var(--drive-blue);
color: white;
border-radius: 50%;
font-weight: 500;
font-size: 14px;
flex-shrink: 0;
}
.content { padding: 24px; }

/* Buttons */
.btn-toggle-sidebar {
width: 40px; height: 40px; flex-shrink: 0;
display: none; align-items: center; justify-content: center;
background: #fff; border: 1px solid #dadce0; border-radius: 50%;
font-size: 18px; color: #5f6368; cursor: pointer; transition: .2s;
}
.btn-toggle-sidebar:hover { background: #f1f3f4; }

/* Stat & Panel */
.stat-card { background: white; border: 1px solid #e8eaed; border-radius: 16px; padding: 20px; height: 100%; transition: 0.2s; }
.stat-card:hover { box-shadow: 0 1px 3px rgba(60,64,67,.2); }
.stat-top { display: flex; justify-content: space-between; align-items: center; }
.stat-icon { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 20px; flex-shrink: 0; }
.icon-green { background: #e6f4ea; color: #137333; }
.icon-blue { background: #e8f0fe; color: var(--drive-blue); }
.icon-yellow { background: #fef7e0; color: #b06000; }
.icon-red { background: #fce8e6; color: #c5221f; }
.stat-label { color: #5f6368; font-size: 13px; margin-top: 16px; }
.stat-value { font-size: 27px; font-weight: 500; margin-top: 4px; color: #202124; }
.stat-description { color: #5f6368; font-size: 11px; margin-top: 4px; }
.panel { background: white; border: 1px solid #e8eaed; border-radius: 16px; padding: 22px; height: 100%; }
.panel-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.panel-title { font-size: 16px; font-weight: 500; color: #202124; }
.panel-link { color: var(--drive-blue); text-decoration: none; font-size: 13px; font-weight: 500; }
.table { vertical-align: middle; }
.table thead th { font-size: 12px; color: #5f6368; font-weight: 500; border-bottom: 1px solid #e8eaed; }
.table tbody td { font-size: 13px; border-color: #e8eaed; }
.btn-primary { background: var(--drive-blue); border-color: var(--drive-blue); font-weight: 500; border-radius: 24px; padding: 8px 20px; }
.btn-primary:hover { background: var(--drive-blue-dark); border-color: var(--drive-blue-dark); box-shadow: 0 1px 2px rgba(60,64,67,.3); }
.btn-success { background: #137333; border-color: #137333; font-weight: 500; border-radius: 24px; }
.badge.bg-success { background: #137333 !important; }
.badge.bg-primary { background: var(--drive-blue) !important; }

/* Floating Button */
.btn-float-laporan {
position: fixed; right: 22px; bottom: 22px; z-index: 1040;
width: 56px; height: 56px; border-radius: 16px;
background: var(--drive-blue); color: #fff; border: none; font-size: 22px;
box-shadow: 0 1px 3px rgba(60,64,67,.3), 0 4px 8px 3px rgba(60,64,67,.15);
display: flex; align-items: center; justify-content: center;
transition: transform .2s ease, background .2s ease, right .35s ease;
}
.btn-float-laporan:hover { background: var(--drive-blue-dark); transform: translateY(-2px); }
.btn-float-laporan .badge-count {
position: absolute; top: -4px; right: -4px;
background: #ea4335; color: #fff; font-size: 10px; font-weight: 700;
border-radius: 999px; padding: 3px 6px; border: 2px solid white;
}
body.drawer-open .btn-float-laporan { right: calc(var(--drawer-width) + 22px); }
#laporanDrawer { --bs-offcanvas-width: var(--drawer-width); box-shadow: -8px 0 24px rgba(0,0,0,.18); border-left: 1px solid #e8eaed; }
.laporan-item { border: 1px solid #e8eaed; border-radius: 12px; padding: 10px 12px; margin-bottom: 10px; background: #fff; }
.laporan-item .head { display: flex; justify-content: space-between; align-items: center; font-size: 12px; font-weight: 500; margin-bottom: 6px; }
.laporan-item .grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 4px; text-align: center; }
.laporan-item .grid .v { font-weight: 500; font-size: 13px; }
.laporan-item .grid .l { font-size: 10px; color: #5f6368; }

/* Responsive */
@media (min-width: 992px) {
.btn-toggle-sidebar { display: flex; }
body.sidebar-collapsed .sidebar { transform: translateX(calc(-100% - 32px)); }
body.sidebar-collapsed .main { margin-left: 16px; width: calc(100% - 32px); }
body.sidebar-collapsed .main.drawer-open { width: calc(100% - var(--drawer-width) - 32px); }
}
@media (max-width: 991px) {
.btn-toggle-sidebar { display: flex; }
.sidebar { left: 0; top: 0; bottom: 0; border-radius: 0; transform: translateX(-100%); }
body.sidebar-open .sidebar { transform: translateX(0); box-shadow: 0 0 40px rgba(0,0,0,.35); }
.main { margin-left: 0; width: 100% !important; }
.main.drawer-open { width: 100% !important; }
body.drawer-open .btn-float-laporan { right: 22px; }
.content { padding: 16px; }
.topbar { padding: 0 16px; height: 64px; }
.page-title { font-size: 16px; }
.stat-value { font-size: 22px; }
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
background: #fef7e0; border: 1px solid #fde293; color: #b06000;
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
<div class="brand-logo-wrap">
<div class="brand-icon">
<svg viewBox="0 0 87.3 78" xmlns="http://www.w3.org/2000/svg">
<path d="m6.6 66.85 3.85 6.65c.8 1.4 1.95 2.5 3.3 3.3l13.75-23.8h-27.5c0 1.55.4 3.1 1.2 4.5z" fill="#0066da"/>
<path d="m43.65 25-13.75-23.8c-1.35.8-2.5 1.9-3.3 3.3l-25.4 44c-.8 1.4-1.2 2.95-1.2 4.5h27.5z" fill="#00ac47"/>
<path d="m73.55 76.8c1.35-.8 2.5-1.9 3.3-3.3l1.6-2.75 7.65-13.25c.8-1.4 1.2-2.95 1.2-4.5h-27.5l5.85 10.1z" fill="#ea4335"/>
<path d="m43.65 25 13.75-23.8c-1.35-.8-2.9-1.2-4.5-1.2h-18.5c-1.6 0-3.15.45-4.5 1.2z" fill="#00832d"/>
<path d="m59.8 53h-32.3l-13.75 23.8c1.35.8 2.9 1.2 4.5 1.2h50.8c1.6 0 3.15-.45 4.5-1.2z" fill="#2684fc"/>
<path d="m73.4 26.5-13.75-23.8-16.15 27.3 16.15 23h27.45c0-1.55-.4-3.1-1.2-4.5z" fill="#ffba00"/>
</svg>
</div>
<div class="brand-text">FARM<span>2025</span></div>
</div>
</div>

<a href="{{ route('dashboard') }}" class="upload-btn {{ request()->routeIs('dashboard') ? 'active-upload' : '' }}">
<i class="bi bi-plus-lg"></i>
<span>Dashboard</span>
</a>

<div class="sidebar-content">
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

<div class="menu-title">Keuangan & Pakan</div>
<a href="{{ route('arus-kas.index') }}" class="{{ request()->is('arus-kas*') ? 'active' : '' }}">
<i class="bi bi-cash-coin"></i> Arus Kas
</a>
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
</div>

<div class="storage-section">
<div class="storage-label"><i class="bi bi-cloud-fill"></i> Storage</div>
<div class="storage-bar"><div class="storage-bar-fill"></div></div>
<div class="storage-info"><strong>5.2 GB</strong> of 15 GB used</div>
<a href="#" class="upgrade-link">Upgrade Storage <i class="bi bi-arrow-right"></i></a>
</div>

<div class="sidebar-footer">
<form method="POST" action="{{ route('logout') }}" class="mb-0">
@csrf
<button type="submit" class="logout-btn">
<i class="bi bi-box-arrow-right"></i> Keluar
</button>
</form>
</div>
</aside>

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
<div style="font-size:13px;font-weight:500;color:#202124;">{{ $user->name ?? 'User' }}</div>
<div style="font-size:11px;color:#5f6368;">{{ ucfirst($user->role ?? 'user') }}</div>
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
var sidebar = document.getElementById('sidebar');
function isMobile() { return window.innerWidth < 992; }
if (btn) btn.addEventListener('click', function () {
if (isMobile()) document.body.classList.toggle('sidebar-open');
else            document.body.classList.toggle('sidebar-collapsed');
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
<div class="offcanvas-header" style="background: var(--drive-blue); color:#fff;">
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
<span class="badge" style="background:var(--drive-blue);color:#fff;">
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
