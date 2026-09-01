<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Laporan Harian') — BukanAyam</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Merriweather:wght@700;900&display=swap" rel="stylesheet">
<style>
:root {
  --primary: #6d4c41;
  --primary-dark: #5d4037;
  --ink: #2d1b16;
  --background: #f7f2ea;
  --border: #e6dacc;
  --muted: #8a7a6e;
  --gold: #d7a86e;
}
* { box-sizing: border-box; }
body {
  margin: 0; font-family: 'Inter', sans-serif;
  background: var(--background); color: #33261f;
  min-height: 100vh; display: flex; flex-direction: column;
}
/* Garis aksen resmi di puncak halaman */
.accent-line { height: 4px; background: linear-gradient(90deg, var(--primary-dark), var(--gold), var(--primary-dark)); }

/* ===== HEADER RESMI ===== */
.mp-header { background: #fff; border-bottom: 1px solid var(--border); }
.mp-header-inner {
  max-width: 820px; margin: 0 auto; padding: 14px 16px;
  display: flex; align-items: center; justify-content: space-between; gap: 12px;
}
.brandmark {
  width: 46px; height: 46px; border-radius: 10px;
  background: var(--ink); color: #ffe9c9;
  display: flex; align-items: center; justify-content: center;
  font-size: 22px; flex-shrink: 0;
}
.brand-name { font-family: 'Merriweather', serif; font-weight: 900; font-size: 17px; color: var(--ink); line-height: 1.1; }
.brand-sub { font-size: 10.5px; color: var(--muted); text-transform: uppercase; letter-spacing: .8px; }
.user-chip { display: flex; align-items: center; gap: 10px; }
.user-avatar {
  width: 40px; height: 40px; border-radius: 50%;
  background: #e8d5bd; color: var(--primary-dark);
  font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.user-name { font-size: 13px; font-weight: 600; line-height: 1.2; }
.user-role { font-size: 10.5px; color: var(--muted); text-transform: uppercase; letter-spacing: .6px; }
.btn-logout {
  border: 1px solid var(--border); background: #fff; color: #842029;
  border-radius: 8px; font-size: 12.5px; padding: 7px 12px;
}
.btn-logout:hover { background: #f8d7da; border-color: #f8d7da; }

/* ===== BAR PORTAL ===== */
.mp-subheader { background: var(--ink); color: #efe4d6; }
.mp-subheader-inner {
  max-width: 820px; margin: 0 auto; padding: 10px 16px;
  display: flex; align-items: center; justify-content: space-between; gap: 10px;
}
.mp-subheader .title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
.mp-subheader .date { font-size: 11.5px; color: #cbb5a8; }

/* ===== KONTEN & FOOTER ===== */
main.mp-main { flex: 1; width: 100%; max-width: 820px; margin: 0 auto; padding: 24px 16px 40px; }
.mp-footer { border-top: 1px solid var(--border); background: #fff; }
.mp-footer-inner { max-width: 820px; margin: 0 auto; padding: 14px 16px; text-align: center; font-size: 11px; color: var(--muted); }

.btn-success { background: var(--primary); border-color: var(--primary); }
.btn-success:hover { background: var(--primary-dark); border-color: var(--primary-dark); }

/* Kartu bergaya dokumen/form resmi */
.doc-card { background: #fff; border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 2px 10px rgba(93,64,55,.06); }
.doc-head { border-bottom: 1px solid var(--border); padding: 18px 20px; background: linear-gradient(180deg, #fbf7f0, #fff); border-radius: 12px 12px 0 0; }
.doc-title { font-family: 'Merriweather', serif; font-weight: 700; font-size: 16px; color: var(--ink); }
.doc-sub { font-size: 12px; color: var(--muted); }

@media (max-width: 576px) {
  .user-name, .user-role { display: none; }
}
</style>
@stack('styles')
</head>
<body>
<div class="accent-line"></div>

{{-- ===== HEADER ===== --}}
<header class="mp-header">
  <div class="mp-header-inner">
    <div class="d-flex align-items-center gap-3">
      <div class="brandmark"><i class="bi bi-egg-fried"></i></div>
      <div>
        <div class="brand-name">BukanAyam</div>
        <div class="brand-sub">Sistem Manajemen Peternakan Ayam</div>
      </div>
    </div>
    <div class="user-chip">
      <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
      <div class="d-none d-sm-block">
        <div class="user-name">{{ auth()->user()->name ?? '' }}</div>
        <div class="user-role">Man Power</div>
      </div>
      <form method="POST" action="{{ route('logout') }}" class="mb-0">
        @csrf
        <button class="btn btn-logout"><i class="bi bi-box-arrow-right me-1"></i>Keluar</button>
      </form>
    </div>
  </div>
</header>

{{-- ===== BAR PORTAL + TANGGAL FORMAL ===== --}}
<div class="mp-subheader">
  <div class="mp-subheader-inner">
    <span class="title"><i class="bi bi-clipboard2-data me-1"></i> Portal Man Power</span>
    <span class="date">{{ now()->locale('id')->translatedFormat('l, j F Y') }}</span>
  </div>
</div>

{{-- ===== KONTEN ===== --}}
<main class="mp-main">
  @if (session('success'))
    <div class="alert alert-success border-0 shadow-sm">
      <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm">
      <strong>Periksa kembali:</strong>
      <ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
  @endif
  @yield('content')
</main>

{{-- ===== FOOTER RESMI ===== --}}
<footer class="mp-footer">
  <div class="mp-footer-inner">
    © {{ date('Y') }} BukanAyam — Desa Tanjung Agung · Didukung PT Pesona Khatulistiwa Nusantara
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
