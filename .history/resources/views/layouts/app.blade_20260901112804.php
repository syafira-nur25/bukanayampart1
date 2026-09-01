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
  --primary-soft: #f3ede6;
  --sidebar-bg: #fdfcfa;
  --background: #f7f2ea;
  --card: #ffffff;
  --text: #33261f;
  --muted: #8a7a6e;
  --border: #e6dacc;
  --drawer-width: 380px;
  --sidebar-width: 264px;
  --sidebar-slim: 84px;
  --sidebar-gap: 16px;
}
* { box-sizing: border-box; }
body { margin: 0; font-family: 'Inter', sans-serif; background: var(--background); color: var(--text); }

/* ===== SIDEBAR (kartu membulat, terang) ===== */
.sidebar {
  position: fixed; left: var(--sidebar-gap); top: var(--sidebar-gap); bottom: var(--sidebar-gap);
  width: var(--sidebar-width);
  background: var(--sidebar-bg);
  border: 1px solid var(--border);
  border-radius: 20px;
  z-index: 1000;
  display: flex; flex-direction: column;
  overflow: hidden;
  transition: width .3s ease, transform .3s ease;
  box-shadow: 0 10px 30px rgba(93, 64, 55, .06);
}
.brand { display: flex; align-items: center; gap: 12px; padding: 20px 20px 12px; }
.brand-icon {
  width: 42px; height: 42px; border-radius: 50%;
  background: var(--primary); color: #fff;
  display: flex; align-items: center; justify-content: center;
  font-size: 18px; flex-shrink: 0;
}
.brand-icon i { display: inline-block; animation: wobble 2.6s ease-in-out infinite; }
.brand-title { font-size: 17px; font-weight: 800; color: var(--text); line-height: 1.1; }
.brand-subtitle { font-size: 11px; color: var(--muted); }

/* Search */
.sidebar-search { padding: 0 16px 10px; }
.search-box {
  display: flex; align-items: center; gap: 8px;
  background: #f1ece5; border-radius: 999px; padding: 9px 14px;
}
.search-box i { color: var(--muted); font-size: 14px; }
.search-box input { border: 0; background: transparent; outline: none; width: 100%; font-size: 13px; color: var(--text); }

/* Menu */
.sidebar-content { flex: 1; overflow-y: auto; overflow-x: hidden; padding: 6px 14px 14px; }
.sidebar-content::-webkit-scrollbar { width: 4px; }
.sidebar-content::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }
.menu-title {
  font-size: 10.5px; font-weight: 700; color: var(--muted);
  text-transform: uppercase; letter-spacing: .8px;
  padding: 12px 12px 6px;
}
.sidebar-content a.menu-link {
  display: flex; align-items: center; gap: 12px;
  padding: 11px 12px; margin-bottom: 2px;
  border-radius: 12px; position: relative;
  color: #6b6259; font-size: 14px; font-weight: 500; text-decoration: none;
  transition: background .15s ease, color .15s ease;
}
.sidebar-content a.menu-link i { font-size: 17px; width: 22px; text-align: center; flex-shrink: 0; }
.sidebar-content a.menu-link:hover { background: var(--primary-soft); color: var(--primary-dark); }
.sidebar-content a.menu-link.active { background: var(--primary-soft); color: var(--primary); font-weight: 600; }
/* indikator aktif di tepi kiri kartu (seperti referensi) */
.sidebar-content a.menu-link.active::before {
  content: ''; position: absolute; left: -14px; top: 9px; bottom: 9px;
  width: 4px; border-radius: 4px; background: var(--primary);
}
.menu-label { white-space: nowrap; }
.menu-badge {
  margin-left: auto; background: #ece5dc; color: #6b6259;
  border-radius: 999px; font-size: 10.5px; font-weight: 700; padding: 2px 8px;
}
.menu-badge.accent { background: var(--primary); color: #fff; }

/* Footer sidebar */
.sidebar-footer { padding: 12px 14px; border-top: 1px solid var(--border); }
.btn-logout {
  display: flex; align-items: center; gap: 12px; width: 100%;
  border: 0; background: transparent; color: #6b6259;
  padding: 10px 12px; border-radius: 12px; font-size: 14px; cursor: pointer;
}
.btn-logout i { font-size: 16px; width: 22px; text-align: center; }
.btn-logout:hover { background: #f8d7da; color: #842029; }

/* ===== OVERLAY (mobile) ===== */
.sidebar-overlay { position: fixed; inset: 0; background: rgba(20,10,5,.5); z-index: 999; opacity: 0; visibility: hidden; transition: opacity .25s ease, visibility .25s ease; }

/* ===== MAIN ===== */
.main {
  margin-left: calc(var(--sidebar-width) + var(--sidebar-gap) * 2);
  width: calc(100% - (var(--sidebar-width) + var(--sidebar-gap) * 2));
  min-height: 100vh;
  transition: margin-left .3s ease, width .35s ease;
}
.main.drawer-open { width: calc(100% - (var(--sidebar-width) + var(--sidebar-gap) * 2) - var(--drawer-width)); }

.topbar { height: 75px; background: white; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 30px; gap: 12px; position: sticky; top: 0; z-index: 900; }
.topbar-left { display: flex; align-items: center; gap: 12px; min-width: 0; }
.page-title { font-size: 18px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.page-subtitle { font-size: 12px; color: var(--muted); margin-top: 2px; }
.profile { display: flex; align-items: center; gap: 10px; }
.profile-avatar { width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; background: #e8d5bd; color: var(--primary-dark); border-radius: 50%; font-weight: 700; flex-shrink: 0; }
.content { padding: 30px; }

/* Tombol toggle sidebar (☰) */
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

/* ===== FLOATING BUTTON & DRAWER ===== */
.btn-float-laporan {
  position: fixed; right: 22px; bottom: 22px; z-index: 1040;
  width: 56px; height: 56px; border-radius: 50%;
  background: var(--primary); color: #fff; border: none; font-size: 22px;
  box-shadow: 0 8px 20px rgba(45,27,22,.35);
  display: flex; align-items: center; justify-content: center;
  transition: transform .2s ease, background .2s ease, right .35s ease;
}
.btn-float-laporan:hover { transform: translateY(-3px); background: var(--primary-dark); }
.btn-float-laporan .badge-count {
  position: absolute; top: -4px; right: -4px;
  background: #d93636; color: #fff; font-size: 10px; font-weight: 700;
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

/* ===== DESKTOP: collapse jadi slim (ikon saja) ===== */
@media (min-width: 992px) {
  .btn-toggle-sidebar { display: flex; }
  body.sidebar-collapsed .sidebar { width: var(--sidebar-slim); }
  body.sidebar-collapsed .brand { justify-content: center; padding: 20px 0 12px; }
  body.sidebar-collapsed .brand-text,
  body.sidebar-collapsed .sidebar-search,
  body.sidebar-collapsed .menu-title,
  body.sidebar-collapsed .menu-label,
  body.sidebar-collapsed .menu-badge { display: none; }
  body.sidebar-collapsed .sidebar-content a.menu-link { justify-content: center; padding: 12px 0; }
  body.sidebar-collapsed .btn-logout { justify-content: center; }
  body.sidebar-collapsed .main {
    margin-left: calc(var(--sidebar-slim) + var(--sidebar-gap) * 2);
    width: calc(100% - (var(--sidebar-slim) + var(--sidebar-gap) * 2));
  }
  body.sidebar-collapsed .main.drawer-open {
    width: calc(100% - (var(--sidebar-slim) + var(--sidebar-gap) * 2) - var(--drawer-width));
  }
}

/* ===== MOBILE / TABLET: off-canvas ===== */
@media (max-width: 991px) {
  .btn-toggle-sidebar { display: flex; }
  .sidebar { transform: translateX(calc(-100% - var(--sidebar-gap) * 2)); }
  body.sidebar-open .sidebar { transform: translateX(0); box-shadow: 0 0 40px rgba(0,0,0,.35); }
  body.sidebar-open .sidebar-overlay { opacity: 1; visibility: visible; }
  .main { margin-left: 0 !important; width: 100% !important; }
  .main.drawer-open { width: 100% !important; }
  body.drawer-open .btn-float-laporan { right: 22px; }
  .content { padding: 16px; }
  .topbar { padding: 0 16px; height: 64px; }
  .page-title { font-size: 16px; }
  .page-subtitle { font-size: 11px; }
  .stat-value { font-size: 22px; }
}

/* ===== HP KECIL ===== */
@media (max-width: 480px) {
  #laporanDrawer { --bs-offcanvas-width: min(var(--drawer-width), 92vw); }
  .content { padding: 12px; }
}
</style>
@stack('styles')
</head>
<body>
@php
$user = auth()->user();
$isAdmin = $user && ($user->role ?? '') === 'admin';
$laporanHariIni = $isAdmin ? \App\Models\LaporanHarian::whereDate('tanggal', today())->count() : 0;
@endphp

<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="brand-icon"><i class="bi bi-egg-fried"></i></div>
        <div class="brand-text">
            <div class="brand-title">BukanAyam</div>
            <div class="brand-subtitle">Peternakan Ayam</div>
        </div>
    </div>

    @if ($isAdmin)
    <div class="sidebar-search">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input id="sidebarSearch" type="text" placeholder="Cari menu...">
        </div>
    </div>
    @endif

    <div class="sidebar-content">
        @if ($isAdmin)
            <div class="menu-title">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i><span class="menu-label">Dashboard</span>
            </a>

            <div class="menu-title">Data Peternakan</div>
            <a href="{{ route('kandang.index') }}" class="menu-link {{ request()->is('kandang*') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill"></i><span class="menu-label">Kandang</span>
            </a>
            <a href="{{ route('populasi.index') }}" class="menu-link {{ request()->is('populasi*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i><span class="menu-label">Populasi Ayam</span>
            </a>
            <a href="{{ route('bobot.index') }}" class="menu-link {{ request()->is('bobot*') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i><span class="menu-label">Bobot Ayam</span>
            </a>

            <div class="menu-title">Produksi</div>
            <a href="{{ route('produksi-telur.index') }}" class="menu-link {{ request()->is('produksi-telur*') ? 'active' : '' }}">
                <i class="bi bi-egg-fill"></i><span class="menu-label">Produksi Telur</span>
            </a>
            <a href="{{ route('penjualan-telur.index') }}" class="menu-link {{ request()->is('penjualan-telur*') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i><span class="menu-label">Penjualan Telur</span>
            </a>
            <a href="{{ route('stok-telur.index') }}" class="menu-link {{ request()->is('stok-telur*') ? 'active' : '' }}">
                <i class="bi bi-boxes"></i><span class="menu-label">Stok Telur</span>
            </a>
            <a href="{{ route('gudang-telur.index') }}" class="menu-link {{ request()->is('gudang-telur*') ? 'active' : '' }}">
                <i class="bi bi-building"></i><span class="menu-label">Gudang Telur</span>
            </a>

            <div class="menu-title">Keuangan</div>
            <a href="{{ route('arus-kas.index') }}" class="menu-link {{ request()->is('arus-kas*') ? 'active' : '' }}">
                <i class="bi bi-cash-coin"></i><span class="menu-label">Arus Kas</span>
            </a>

            <div class="menu-title">Pakan</div>
            <a href="{{ route('pakan-kandang.index') }}" class="menu-link {{ request()->is('pakan-kandang*') ? 'active' : '' }}">
                <i class="bi bi-box-seam-fill"></i><span class="menu-label">Stok Pakan</span>
            </a>
            <a href="{{ route('pemberian-pakan.index') }}" class="menu-link {{ request()->is('pemberian-pakan*') ? 'active' : '' }}">
                <i class="bi bi-basket-fill"></i><span class="menu-label">Pemberian Pakan</span>
            </a>
            <a href="{{ route('pakan.laporan') }}" class="menu-link {{ request()->is('laporan-pakan*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-fill"></i><span class="menu-label">Laporan Pakan</span>
            </a>

            <div class="menu-title">Man Power</div>
            <a href="{{ route('admin.laporan.index') }}" class="menu-link {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                <i class="bi bi-clipboard2-data-fill"></i><span class="menu-label">Laporan Harian</span>
                @if ($laporanHariIni > 0)
                    <span class="menu-badge accent">{{ $laporanHariIni }}</span>
                @endif
            </a>
        @else
            <div class="menu-title">Menu</div>
            <a href="{{ route('manpower.laporan.create') }}" class="menu-link {{ request()->routeIs('manpower.laporan.*') ? 'active' : '' }}">
                <i class="bi bi-pencil-square"></i><span class="menu-label">Input Laporan Harian</span>
            </a>
        @endif
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i><span class="menu-label">Keluar</span>
            </button>
        </form>
    </div>
</aside>

{{-- Overlay gelap saat sidebar terbuka di HP --}}
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

{{-- ===== LOGIKA TOGGLE SIDEBAR (desktop slim / mobile off-canvas) ===== --}}
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

    // ===== SEARCH FILTER MENU SIDEBAR =====
    var searchInput = document.getElementById('sidebarSearch');
    if (searchInput) searchInput.addEventListener('input', function () {
        var q = this.value.toLowerCase();
        document.querySelectorAll('.sidebar-content a.menu-link').forEach(function (a) {
            var label = a.querySelector('.menu-label');
            var text  = label ? label.textContent.toLowerCase() : '';
            a.style.display = (text.indexOf(q) !== -1) ? '' : 'none';
        });
    });
})();
</script>

{{-- ===== FLOATING LAPORAN HARIAN (khusus admin) ===== --}}
@if ($isAdmin)
@php
$laporanFloating = \App\Models\LaporanHarian::with('kandang')
    ->latest('tanggal')->latest('id')->limit(12)->get();
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
    <div class="offcanvas-header" style="background: var(--primary); color:#fff;">
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
                    <span class="badge" style="background:var(--primary);color:#fff;">
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

{{-- ✅ SCRIPT EFEK BELAH (3 lapis pengaman) --}}
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

@include('partials.cursor-animation')
</body>
</html>