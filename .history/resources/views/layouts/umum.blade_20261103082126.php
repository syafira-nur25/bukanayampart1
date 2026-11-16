<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Data Peternakan') — Mode Baca</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
--primary: #6d4c41; --primary-dark: #5d4037;
--sidebar: #2d1b16; --sidebar-hover: #4e342e;
--background: #f7f2ea; --text: #33261f; --muted: #8a7a6e; --border: #e6dacc;
--sidebar-width: 250px;
}
* { box-sizing: border-box; }
body { margin: 0; font-family: 'Inter', sans-serif; background: var(--background); color: var(--text); }
.sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; left: 0; top: 0; background: var(--sidebar); color: #fff; z-index: 1000; overflow-y: auto; }
.brand { height: 70px; display: flex; align-items: center; justify-content: center; gap: 10px; border-bottom: 1px solid rgba(255,255,255,.08); padding: 0 16px; }
.brand-logo { height: 40px; width: auto; object-fit: contain; }
.readonly-badge { background: #fff3cd; color: #997404; font-size: 10px; font-weight: 800; letter-spacing: 1px; padding: 4px 10px; border-radius: 999px; text-transform: uppercase; }
.sidebar-content { padding: 18px 12px; }
.menu-title { font-size: 11px; font-weight: 700; color: #a1887f; text-transform: uppercase; padding: 12px 12px 6px; letter-spacing: .8px; }
.sidebar a { color: #e5d8cf; text-decoration: none; display: flex; align-items: center; gap: 12px; padding: 11px 13px; border-radius: 9px; margin-bottom: 3px; font-size: 14px; transition: .2s; }
.sidebar a:hover { background: var(--sidebar-hover); color: #fff; }
.sidebar a.active { background: var(--primary); color: #fff; }
.sidebar a i { font-size: 17px; }
.sidebar-footer { padding: 14px; border-top: 1px solid rgba(255,255,255,.08); margin-top: 16px; }
.btn-logout { background: transparent; border: 1px solid rgba(255,255,255,.2); color: #fff; padding: 8px 12px; border-radius: 8px; font-size: 13px; cursor: pointer; width: 100%; }
.btn-logout:hover { background: #f8d7da; color: #842029; border-color: #f8d7da; }
.main { margin-left: var(--sidebar-width); min-height: 100vh; }
.topbar { height: 70px; background: #fff; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; padding: 0 26px; position: sticky; top: 0; z-index: 900; }
.page-title { font-size: 17px; font-weight: 700; }
.content { padding: 26px; }
.stat-card { background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: 18px; height: 100%; }
.stat-label { color: var(--muted); font-size: 12px; }
.stat-value { font-size: 24px; font-weight: 800; margin-top: 4px; }
.panel { background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: 20px; height: 100%; }
.panel-title { font-size: 15px; font-weight: 700; margin-bottom: 14px; }
.table { vertical-align: middle; }
.table thead th { font-size: 11.5px; color: var(--muted); font-weight: 600; border-bottom: 1px solid var(--border); text-transform: uppercase; letter-spacing: .4px; }
.table tbody td { font-size: 13px; border-color: #f0e9df; }
.note-readonly { background: #fff3cd; border: 1px solid #ffe69c; color: #7a5b00; border-radius: 12px; padding: 10px 14px; font-size: 12.5px; margin-bottom: 18px; }
@media (max-width: 991px) {
.sidebar { transform: translateX(-100%); transition: transform .3s ease; }
body.sidebar-open .sidebar { transform: translateX(0); }
.main { margin-left: 0; }
.btn-toggle { display: inline-flex !important; }
}
.btn-toggle { display: none; border: 1px solid var(--border); background: #fff; border-radius: 8px; width: 38px; height: 38px; align-items: center; justify-content: center; }
</style>
</head>
<body>
<aside class="sidebar" id="sidebar">
<div class="brand">
<img src="{{ asset('logo.png') }}" alt="Logo" class="brand-logo" onerror="this.style.display='none';">
<span class="readonly-badge">Mode Baca</span>
</div>
<div class="sidebar-content">
<div class="menu-title">Menu</div>
<a href="{{ route('umum.home') }}" class="{{ request()->routeIs('umum.home') ? 'active' : '' }}"><i class="bi bi-grid-1x2-fill"></i> Ringkasan</a>
<a href="{{ route('umum.populasi') }}" class="{{ request()->routeIs('umum.populasi') ? 'active' : '' }}"><i class="bi bi-people-fill"></i> Populasi Ayam</a>
<a href="{{ route('umum.produksi') }}" class="{{ request()->routeIs('umum.produksi') ? 'active' : '' }}"><i class="bi bi-egg-fill"></i> Produksi Telur</a>
<a href="{{ route('umum.penjualan') }}" class="{{ request()->routeIs('umum.penjualan') ? 'active' : '' }}"><i class="bi bi-cash-stack"></i> Penjualan</a>
<a href="{{ route('umum.pakan') }}" class="{{ request()->routeIs('umum.pakan') ? 'active' : '' }}"><i class="bi bi-box-seam-fill"></i> Stok Pakan</a>
<a href="{{ route('umum.laporan') }}" class="{{ request()->routeIs('umum.laporan') ? 'active' : '' }}"><i class="bi bi-clipboard2-data-fill"></i> Laporan Harian</a>
</div>
<div class="sidebar-footer">
<form method="POST" action="{{ route('logout') }}" class="mb-0">
@csrf
<button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right me-1"></i> Keluar</button>
</form>
</div>
</aside>

<div class="main">
<header class="topbar">
<div class="d-flex align-items-center gap-2">
<button class="btn-toggle" type="button" onclick="document.body.classList.toggle('sidebar-open')"><i class="bi bi-list"></i></button>
<div class="page-title">@yield('title', 'Ringkasan')</div>
</div>
<span class="readonly-badge"><i class="bi bi-eye-fill me-1"></i>Hanya Melihat</span>
</header>
<main class="content">
<div class="note-readonly">
<i class="bi bi-info-circle-fill me-1"></i>
Anda masuk sebagai <strong>Mode Baca (Umum)</strong> — seluruh data dapat dilihat, namun tidak dapat menambah, mengubah, atau menghapus data.
</div>
@yield('content')
</main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
