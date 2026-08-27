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
  --primary-light: #8d6e63;
  --sidebar: #2d1b16;
  --sidebar-hover: #4e342e;
  --background: #f7f2ea;
  --card: #ffffff;
  --text: #33261f;
  --muted: #8a7a6e;
  --border: #e6dacc;
  --drawer-width: 400px;
  --sidebar-width: 260px;
  --smooth-ease: cubic-bezier(0.4, 0, 0.2, 1);
  --bounce-ease: cubic-bezier(0.68, -0.55, 0.265, 1.55);
}
* { box-sizing: border-box; }
body { margin: 0; font-family: 'Inter', sans-serif; background: var(--background); color: var(--text); }

/* ===== SIDEBAR ===== */
.sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; left: 0; top: 0; background: var(--sidebar); color: white; z-index: 1000; transition: transform .3s ease; overflow-y: auto; }
.brand { height: 75px; display: flex; align-items: center; padding: 0 24px; border-bottom: 1px solid rgba(255,255,255,0.08); }
.brand-icon { width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; background: var(--primary); border-radius: 12px; font-size: 22px; margin-right: 12px; flex-shrink: 0; }
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

.sidebar-overlay { position: fixed; inset: 0; background: rgba(20,10,5,.5); z-index: 999; opacity: 0; visibility: hidden; transition: opacity .25s ease, visibility .25s ease; }

/* ===== MAIN ===== */
.main { margin-left: var(--sidebar-width); min-height: 100vh; transition: margin-left .4s var(--smooth-ease), width .5s var(--smooth-ease); width: calc(100% - var(--sidebar-width)); }

/* ✅ EFEK BELAH LAYAR */
.main.drawer-open { width: calc(100% - var(--sidebar-width) - var(--drawer-width)); }

.topbar { height: 75px; background: white; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 30px; gap: 12px; position: sticky; top: 0; z-index: 900; }
.topbar-left { display: flex; align-items: center; gap: 12px; min-width: 0; }
.page-title { font-size: 18px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.page-subtitle { font-size: 12px; color: var(--muted); margin-top: 2px; }
.profile { display: flex; align-items: center; gap: 10px; }
.profile-avatar { width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: #e8d5bd; color: var(--primary-dark); border-radius: 50%; font-weight: 700; flex-shrink: 0; }
.btn-logout { background: transparent; border: 1px solid var(--border); color: #ffffff; padding: 6px 12px; border-radius: 8px; font-size: 13px; cursor: pointer; transition: 0.2s; }
.btn-logout:hover { background: #f8d7da; color: #842029; border-color: #f8d7da; }
.content { padding: 30px; }

.btn-toggle-sidebar {
  width: 40px; height: 40px; flex-shrink: 0;
  display: none; align-items: center; justify-content: center;
  background: #fff; border: 1px solid var(--border); border-radius: 10px;
  font-size: 18px; color: var(--text); cursor: pointer; transition: .2s;
}
.btn-toggle-sidebar:hover { background: var(--background); }

/* ===== CARDS & PANELS ===== */
.stat-card { background: white; border: 1px solid var(--border); border-radius: 16px; padding: 20px; height: 100%; transition: 0.2s; }
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.06); }
.stat-top { display: flex; justify-content: space-between; align-items: center; }
.stat-icon { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 20px; flex-shrink: 0; }
.icon-green { background: #e8d5bd; color: #5d4037; }
.icon-blue { background: #cfe2ff; color: #084298; }
.icon-yellow { background: #fff3cd; color: #997404; }
.icon-red { background: #f8d7da; color: #842029; }
.stat-label { color: var(--muted); font-size: 13px; margin-top: 16px; }
.stat-value { font-size: 27px; font-weight: 800; margin-top: 4px; }
.stat-description { color: var(--muted); font-size: 11px; margin-top: 4px; }

.panel { background: white; border: 1px solid var(--border); border-radius: 16px; padding: 22px; height: 100%; }
.panel-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
.panel-title { font-size: 16px; font-weight: 700; }
.panel-link { color: var(--primary); text-decoration: none; font-size: 13px; font-weight: 600; }

.table { vertical-align: middle; }
.table thead th { font-size: 12px; color: var(--muted); font-weight: 600; border-bottom: 1px solid var(--border); }
.table tbody td { font-size: 13px; border-color: #f0e9df; }

.btn-primary { background: var(--primary); border-color: var(--primary); }
.btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
.btn-success { background: var(--primary); border-color: var(--primary); }
.btn-success:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
.badge.bg-success { background: var(--primary) !important; }

@keyframes wobble { 0%,100% { transform: rotate(0); } 25% { transform: rotate(-10deg); } 75% { transform: rotate(10deg); } }

/* ============================================ */
/* ===== FLOATING BUTTON - PREMIUM EDITION ===== */
/* ============================================ */
.btn-float-laporan {
  position: fixed;
  right: 24px;
  bottom: 24px;
  z-index: 1040;
  width: 62px;
  height: 62px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  color: #fff;
  border: none;
  font-size: 24px;
  box-shadow:
    0 10px 25px rgba(93, 64, 55, 0.35),
    0 4px 10px rgba(45, 27, 22, 0.25),
    inset 0 1px 0 rgba(255,255,255,0.15);
  display: flex;
  align-items: center;
  justify-content: center;
  transition:
    transform .3s var(--bounce-ease),
    box-shadow .3s ease,
    right .5s var(--smooth-ease);
  cursor: pointer;
  overflow: hidden;
}

/* Pulse ring di belakang tombol */
.btn-float-laporan::before {
  content: '';
  position: absolute;
  inset: 0;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(109,76,65,0.4) 0%, transparent 70%);
  animation: pulseRing 2.5s ease-out infinite;
  z-index: -1;
}

/* Ripple effect saat klik */
.btn-float-laporan::after {
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: rgba(255,255,255,0.4);
  transform: scale(0);
  opacity: 0;
  transition: transform .6s ease, opacity .6s ease;
}
.btn-float-laporan:active::after {
  transform: scale(2);
  opacity: 0;
}

.btn-float-laporan:hover {
  transform: translateY(-5px) scale(1.08) rotate(-8deg);
  box-shadow:
    0 15px 35px rgba(93, 64, 55, 0.45),
    0 8px 15px rgba(45, 27, 22, 0.3),
    inset 0 1px 0 rgba(255,255,255,0.25);
}

.btn-float-laporan:active {
  transform: translateY(-2px) scale(1);
}

.btn-float-laporan i {
  position: relative;
  z-index: 2;
  filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
  transition: transform .3s var(--bounce-ease);
}
.btn-float-laporan:hover i {
  transform: scale(1.1);
}

/* Badge count dengan animasi bouncy */
.btn-float-laporan .badge-count {
  position: absolute;
  top: -4px;
  right: -4px;
  background: linear-gradient(135deg, #ff4757 0%, #c0392b 100%);
  color: #fff;
  font-size: 11px;
  font-weight: 800;
  border-radius: 999px;
  padding: 4px 8px;
  min-width: 22px;
  height: 22px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 2px 6px rgba(255, 71, 87, 0.5);
  border: 2px solid #fff;
  animation: badgeBounce 2s ease-in-out infinite;
  z-index: 3;
}

@keyframes pulseRing {
  0% { transform: scale(0.9); opacity: 1; }
  100% { transform: scale(1.6); opacity: 0; }
}

@keyframes badgeBounce {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.15); }
}

body.drawer-open .btn-float-laporan {
  right: calc(var(--drawer-width) + 24px);
  transform: rotate(180deg);
}
body.drawer-open .btn-float-laporan:hover {
  transform: rotate(180deg) translateY(-5px) scale(1.08);
}

/* ============================================ */
/* ===== DRAWER - PREMIUM EDITION ===== */
/* ============================================ */
#laporanDrawer {
  --bs-offcanvas-width: var(--drawer-width);
  background: linear-gradient(180deg, #fdfaf6 0%, #f7f2ea 100%);
  border-left: 1px solid var(--border);
  box-shadow:
    -15px 0 40px rgba(45, 27, 22, 0.15),
    -5px 0 15px rgba(45, 27, 22, 0.08);
  transition: transform .5s var(--smooth-ease);
}

#laporanDrawer.show {
  animation: drawerSlideIn .5s var(--smooth-ease);
}

@keyframes drawerSlideIn {
  from { transform: translateX(100%); }
  to { transform: translateX(0); }
}

#laporanDrawer .offcanvas-header {
  background: linear-gradient(135deg, var(--sidebar) 0%, var(--primary-dark) 100%);
  color: #fff;
  padding: 22px 24px;
  border-bottom: 3px solid var(--primary);
  position: relative;
  overflow: hidden;
}

#laporanDrawer .offcanvas-header::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -20%;
  width: 200px;
  height: 200px;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
  border-radius: 50%;
}

#laporanDrawer .offcanvas-title {
  font-size: 17px;
  font-weight: 800;
  letter-spacing: 0.3px;
  position: relative;
  z-index: 2;
}

#laporanDrawer .offcanvas-title i {
  display: inline-block;
  animation: iconFloat 2s ease-in-out infinite;
}

@keyframes iconFloat {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-3px); }
}

#laporanDrawer .btn-close {
  filter: brightness(0) invert(1);
  opacity: 0.9;
  transition: transform .3s ease, opacity .3s ease;
  position: relative;
  z-index: 2;
}
#laporanDrawer .btn-close:hover {
  transform: rotate(90deg);
  opacity: 1;
}

#laporanDrawer .offcanvas-body {
  padding: 16px 20px;
  background: transparent;
}

/* Custom scrollbar drawer */
#laporanDrawer .offcanvas-body::-webkit-scrollbar {
  width: 6px;
}
#laporanDrawer .offcanvas-body::-webkit-scrollbar-track {
  background: transparent;
}
#laporanDrawer .offcanvas-body::-webkit-scrollbar-thumb {
  background: rgba(109, 76, 65, 0.25);
  border-radius: 3px;
}
#laporanDrawer .offcanvas-body::-webkit-scrollbar-thumb:hover {
  background: rgba(109, 76, 65, 0.5);
}

/* ===== LAPORAN ITEM CARD ===== */
.laporan-item {
  position: relative;
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 14px 16px;
  margin-bottom: 12px;
  transition:
    transform .3s var(--smooth-ease),
    box-shadow .3s ease,
    border-color .3s ease;
  overflow: hidden;
  animation: cardFadeIn .4s ease backwards;
}

.laporan-item::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  bottom: 0;
  width: 4px;
  background: linear-gradient(180deg, var(--primary) 0%, var(--primary-light) 100%);
  border-radius: 0 4px 4px 0;
  opacity: 0.5;
  transition: opacity .3s ease;
}

.laporan-item:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(93, 64, 55, 0.12);
  border-color: var(--primary-light);
}
.laporan-item:hover::before {
  opacity: 1;
}

.laporan-item:nth-child(1) { animation-delay: 0.05s; }
.laporan-item:nth-child(2) { animation-delay: 0.1s; }
.laporan-item:nth-child(3) { animation-delay: 0.15s; }
.laporan-item:nth-child(4) { animation-delay: 0.2s; }
.laporan-item:nth-child(5) { animation-delay: 0.25s; }
.laporan-item:nth-child(6) { animation-delay: 0.3s; }

@keyframes cardFadeIn {
  from {
    opacity: 0;
    transform: translateX(20px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

.laporan-item .head {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 12px;
  font-weight: 700;
  margin-bottom: 10px;
  padding-bottom: 8px;
  border-bottom: 1px dashed #e6dacc;
}

.laporan-item .head > span:first-child {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  color: var(--muted);
}
.laporan-item .head > span:first-child::before {
  content: '\f20e';
  font-family: 'bootstrap-icons';
  color: var(--primary);
  font-size: 13px;
}

.laporan-item .head .badge {
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%) !important;
  color: #fff !important;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.3px;
  box-shadow: 0 2px 5px rgba(109, 76, 65, 0.25);
}

.laporan-item .grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 6px;
  text-align: center;
  margin-bottom: 4px;
}

.laporan-item .grid .v {
  font-weight: 800;
  font-size: 14px;
  line-height: 1.2;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 3px;
  padding: 6px 4px;
  background: #faf6f0;
  border-radius: 8px;
  transition: transform .2s ease, background .2s ease;
}

.laporan-item:hover .grid .v {
  background: #f5ede0;
  transform: scale(1.03);
}

.laporan-item .grid .v.text-danger {
  background: #fdecea;
  color: #c0392b !important;
}
.laporan-item .grid .v.text-warning {
  background: #fef5e7;
  color: #b9770e !important;
}
.laporan-item .grid .v.text-success {
  background: #e8f5e9;
  color: #1e8449 !important;
}

.laporan-item .grid .l {
  font-size: 9px;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  font-weight: 600;
  margin-top: 3px;
}

/* Empty state */
.empty-state {
  text-align: center;
  padding: 40px 20px;
  color: var(--muted);
}
.empty-state i {
  font-size: 48px;
  color: var(--border);
  animation: wobble 3s ease-in-out infinite;
  margin-bottom: 12px;
  display: block;
}
.empty-state p {
  font-size: 13px;
  margin: 0;
}

/* Tombol lihat semua */
.btn-lihat-semua {
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  color: #fff;
  border: none;
  padding: 12px;
  border-radius: 12px;
  font-weight: 700;
  font-size: 13px;
  letter-spacing: 0.3px;
  margin-top: 8px;
  transition: transform .3s var(--bounce-ease), box-shadow .3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  box-shadow: 0 4px 12px rgba(109, 76, 65, 0.25);
}
.btn-lihat-semua:hover {
  color: #fff;
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(109, 76, 65, 0.35);
}
.btn-lihat-semua:active {
  transform: translateY(0);
}

/* ===== DESKTOP ===== */
@media (min-width: 992px) {
  .btn-toggle-sidebar { display: flex; }
  body.sidebar-collapsed .sidebar { transform: translateX(-100%); }
  body.sidebar-collapsed .main { margin-left: 0; width: 100%; }
  body.sidebar-collapsed .main.drawer-open { width: calc(100% - var(--drawer-width)); }
}

/* ===== MOBILE ===== */
@media (max-width: 991px) {
  .btn-toggle-sidebar { display: flex; }
  .sidebar { transform: translateX(-100%); }
  body.sidebar-open .sidebar { transform: translateX(0); box-shadow: 0 0 40px rgba(0,0,0,.35); }
  body.sidebar-open .sidebar-overlay { opacity: 1; visibility: visible; }
  .main { margin-left: 0; width: 100% !important; }
  .main.drawer-open { width: 100% !important; }
  body.drawer-open .btn-float-laporan { right: 24px; transform: rotate(0); }
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
  .btn-float-laporan { width: 56px; height: 56px; font-size: 22px; }
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
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout w-100 text-start d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </button>
            </form>
        </div>
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
                    <div style="font-size:11px;color:#8a7a6e;">{{ ucfirst($user->role ?? 'user') }}</div>
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

{{-- ===== FLOATING LAPORAN HARIAN (khusus admin) ===== --}}
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
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="laporanDrawerLabel">
            <i class="bi bi-clipboard2-data-fill me-2"></i>Laporan Harian Terbaru
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @forelse($laporanFloating as $lap)
            <div class="laporan-item">
                <div class="head">
                    <span>{{ $lap->tanggal->format('d/m/Y') }}</span>
                    <span class="badge">{{ $lap->kandang->nama ?? '-' }}</span>
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
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <p>Belum ada laporan harian.</p>
            </div>
        @endforelse
        <a href="{{ route('admin.laporan.index') }}" class="btn btn-lihat-semua">
            <i class="bi bi-arrow-right-circle-fill"></i>
            Lihat Semua Laporan
        </a>
    </div>
</div>

<script>
(function () {
    const drawer   = document.getElementById('laporanDrawer');
    const mainArea = document.getElementById('mainArea');
    const btnFloat = document.querySelector('.btn-float-laporan');
    if (!drawer || !mainArea) return;

    const buka  = () => { mainArea.classList.add('drawer-open'); document.body.classList.add('drawer-open'); };
    const tutup = () => { mainArea.classList.remove('drawer-open'); document.body.classList.remove('drawer-open'); };

    drawer.addEventListener('show.bs.offcanvas', buka);
    drawer.addEventListener('hide.bs.offcanvas', tutup);
    drawer.addEventListener('shown.bs.offcanvas', buka);
    drawer.addEventListener('hidden.bs.offcanvas', tutup);

    if (btnFloat) btnFloat.addEventListener('click', function () {
        setTimeout(() => drawer.classList.contains('show') ? buka() : tutup(), 50);
    });

    const btnClose = drawer.querySelector('[data-bs-dismiss="offcanvas"]');
    if (btnClose) btnClose.addEventListener('click', tutup);

    // Tutup dengan ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && drawer.classList.contains('show')) tutup();
    });
})();
</script>
@endif

@include('partials.cursor-animation')
</body>
</html>
