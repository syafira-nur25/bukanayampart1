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
  --primary: #6d4c41;
  --primary-dark: #5d4037;
  --sidebar: #2d1b16;
  --sidebar-hover: #4e342e;
  --background: #f7f2ea;
  --card: #ffffff;
  --text: #33261f;
  --muted: #8a7a6e;
  --border: #e6dacc;
}
* { box-sizing: border-box; }
body { margin: 0; font-family: 'Inter', sans-serif; background: var(--background); color: var(--text); }

/* SIDEBAR */
.sidebar { width: 260px; height: 100vh; position: fixed; left: 0; top: 0; background: var(--sidebar); color: white; z-index: 1000; transition: 0.3s; overflow-y: auto; }
.brand { height: 75px; display: flex; align-items: center; padding: 0 24px; border-bottom: 1px solid rgba(255,255,255,0.08); }
.brand-icon { width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; background: var(--primary); border-radius: 12px; font-size: 22px; margin-right: 12px; }
.brand-icon i { display: inline-block; animation: wobble 2.6s ease-in-out infinite; }
.brand-title { font-size: 18px; font-weight: 800; }
.brand-subtitle { font-size: 11px; color: #cbb5a8; }
.sidebar-content { padding: 20px 14px; }
.menu-title { font-size: 11px; font-weight: 700; color: #a1887f; text-transform: uppercase; padding: 15px 12px 8px; letter-spacing: 0.8px; }
.sidebar a { color: #e5d8cf; text-decoration: none; display: flex; align-items: center; gap: 12px; padding: 11px 13px; border-radius: 9px; margin-bottom: 3px; font-size: 14px; transition: 0.2s; }
.sidebar a:hover { background: var(--sidebar-hover); color: white; }
.sidebar a.active { background: var(--primary); color: white; }
.sidebar a i { font-size: 17px; }
.sidebar-footer { padding: 14px; border-top: 1px solid rgba(255,255,255,0.08); margin-top: 20px; }

/* MAIN */
.main { margin-left: 260px; min-height: 100vh; }
.topbar { height: 75px; background: white; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 30px; }
.page-title { font-size: 18px; font-weight: 700; }
.page-subtitle { font-size: 12px; color: var(--muted); margin-top: 2px; }
.profile { display: flex; align-items: center; gap: 10px; }
.profile-avatar { width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: #e8d5bd; color: var(--primary-dark); border-radius: 50%; font-weight: 700; }
.btn-logout { background: transparent; border: 1px solid var(--border); color: #ffffff; padding: 6px 12px; border-radius: 8px; font-size: 13px; cursor: pointer; transition: 0.2s; }
.btn-logout:hover { background: #f8d7da; color: #842029; border-color: #f8d7da; }
.content { padding: 30px; }

/* CARDS */
.stat-card { background: white; border: 1px solid var(--border); border-radius: 16px; padding: 20px; height: 100%; transition: 0.2s; }
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.06); }
.stat-top { display: flex; justify-content: space-between; align-items: center; }
.stat-icon { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 20px; }
.icon-green { background: #e8d5bd; color: #5d4037; }
.icon-blue { background: #cfe2ff; color: #084298; }
.icon-yellow { background: #fff3cd; color: #997404; }
.icon-red { background: #f8d7da; color: #842029; }
.stat-label { color: var(--muted); font-size: 13px; margin-top: 16px; }
.stat-value { font-size: 27px; font-weight: 800; margin-top: 4px; }
.stat-description { color: var(--muted); font-size: 11px; margin-top: 4px; }

/* PANEL */
.panel { background: white; border: 1px solid var(--border); border-radius: 16px; padding: 22px; height: 100%; }
.panel-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.panel-title { font-size: 16px; font-weight: 700; }
.panel-link { color: var(--primary); text-decoration: none; font-size: 13px; font-weight: 600; }

/* TABLE */
.table { vertical-align: middle; }
.table thead th { font-size: 12px; color: var(--muted); font-weight: 600; border-bottom: 1px solid var(--border); }
.table tbody td { font-size: 13px; border-color: #f0e9df; }

/* BUTTON & BADGE (hijau → coklat) */
.btn-primary { background: var(--primary); border-color: var(--primary); }
.btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
.btn-success { background: var(--primary); border-color: var(--primary); }
.btn-success:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
.badge.bg-success { background: var(--primary) !important; }

@keyframes wobble { 0%,100% { transform: rotate(0); } 25% { transform: rotate(-10deg); } 75% { transform: rotate(10deg); } }

/* MOBILE */
@media (max-width: 991px) {
  .sidebar { transform: translateX(-100%); }
  .sidebar.show { transform: translateX(0); }
  .main { margin-left: 0; }
  .content { padding: 20px; }
  .topbar { padding: 0 20px; }
}
</style>
@stack('styles')
</head>
<body>
@php
$user = auth()->user();
$isAdmin = $user && ($user->role ?? '') === 'admin';
@endphp

<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="brand-icon"><i class="bi bi-egg-fried"></i></div>
        <div>
            <div class="brand-title">BukanAyam</div>
            <div class="brand-subtitle">Peternakan Ayam</div>
        </div>
    </div>
    <div class="sidebar-content">
        @if ($isAdmin)
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
            <div class="menu-title">Produksi</div>
            <a href="{{ route('produksi-telur.index') }}" class="{{ request()->is('produksi-telur*') ? 'active' : '' }}">
                <i class="bi bi-egg-fill"></i> Produksi Telur
            </a>
            <a href="{{ route('penjualan-telur.index') }}" class="{{ request()->is('penjualan-telur*') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i> Penjualan Telur
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
                <i class="bi bi-pencil-square"></i
