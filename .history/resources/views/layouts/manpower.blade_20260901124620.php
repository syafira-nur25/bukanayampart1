<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Laporan Harian')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
  --primary: #6d4c41;
  --primary-dark: #5d4037;
  --krem: #f7f2ea;
  --krem-2: #efe6d9;
  --aksen: #d7a86e;
  --teks: #33261f;
  --muted: #8a7a6e;
  --border: #e6dacc;
}
* { box-sizing: border-box; }
html { scroll-behavior: smooth; }
body {
  margin: 0;
  font-family: 'Inter', sans-serif;
  background: var(--krem);
  color: var(--teks);
  min-height: 100vh;
}

/* ===== NAVBAR MANPOWER ===== */
.mp-navbar {
  position: sticky; top: 0; z-index: 1000;
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  box-shadow: 0 4px 18px rgba(45, 27, 22, .18);
  padding: 0;
}
.mp-navbar .container {
  display: flex; align-items: center; justify-content: space-between;
  padding: 14px 20px; gap: 12px;
}

/* Brand (kiri) */
.mp-brand {
  display: flex; align-items: center; gap: 11px;
  text-decoration: none; color: #fff;
}
.mp-brand-icon {
  width: 42px; height: 42px; border-radius: 50%;
  background: rgba(255,255,255,.15);
  backdrop-filter: blur(8px);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 20px; flex-shrink: 0;
  box-shadow: inset 0 0 0 1px rgba(255,255,255,.18);
}
.mp-brand-icon i {
  display: inline-block;
  animation: wobble 2.8s ease-in-out infinite;
}
.mp-brand-text .t1 { font-size: 15px; font-weight: 800; letter-spacing: .3px; line-height: 1.1; }
.mp-brand-text .t2 { font-size: 10.5px; color: rgba(255,255,255,.72); font-weight: 500; }

/* Tengah: judul halaman (hanya di layar md+) */
.mp-page-title {
  display: none; color: #fff; text-align: center; flex: 1;
  font-size: 14px; font-weight: 600; white-space: nowrap;
  overflow: hidden; text-overflow: ellipsis; padding: 0 8px;
}
.mp-page-title i { opacity: .75; margin-right: 6px; }

/* User menu (kanan) */
.mp-user {
  display: flex; align-items: center; gap: 10px;
  position: relative;
}
.mp-avatar {
  width: 40px; height: 40px; border-radius: 50%;
  background: #fff; color: var(--primary-dark);
  display: flex; align-items: center; justify-content: center;
  font-weight: 800; font-size: 14px;
  box-shadow: 0 2px 8px rgba(0,0,0,.12);
  cursor: pointer;
  transition: transform .15s ease;
}
.mp-avatar:hover { transform: scale(1.05); }
.mp-user-info { display: none; line-height: 1.1; }
.mp-user-info .name { color: #fff; font-size: 13px; font-weight: 700; }
.mp-user-info .role { color: rgba(255,255,255,.72); font-size: 11px; }

/* Dropdown menu */
.mp-dropdown {
  position: absolute; top: calc(100% + 8px); right: 0;
  background: #fff; border: 1px solid var(--border);
  border-radius: 14px; min-width: 240px;
  box-shadow: 0 12px 30px rgba(45, 27, 22, .18);
  padding: 14px;
  opacity: 0; visibility: hidden; transform: translateY(-6px);
  transition: all .2s ease;
}
.mp-dropdown.show { opacity: 1; visibility: visible; transform: translateY(0); }

.mp-dropdown .user-head {
  display: flex; align-items: center; gap: 10px;
  padding-bottom: 12px; border-bottom: 1px solid var(--border);
  margin-bottom: 8px;
}
.mp-dropdown .user-head .av {
  width: 38px; height: 38px; border-radius: 50%;
  background: var(--krem-2); color: var(--primary-dark);
  display: flex; align-items: center; justify-content: center;
  font-weight: 800; flex-shrink: 0;
}
.mp-dropdown .user-head .nm { font-size: 13px; font-weight: 700; color: var(--teks); }
.mp-dropdown .user-head .rl { font-size: 11px; color: var(--muted); }

.mp-dropdown a, .mp-dropdown button {
  display: flex; align-items: center; gap: 10px; width: 100%;
  border: 0; background: transparent; padding: 10px 12px;
  border-radius: 10px; font-size: 13.5px; color: var(--teks);
  text-decoration: none; font-weight: 500; cursor: pointer;
  transition: background .15s ease;
  text-align: left;
}
.mp-dropdown a:hover, .mp-dropdown button:hover { background: var(--krem-2); }
.mp-dropdown .logout { color: #842029; }
.mp-dropdown .logout:hover { background: #f8d7da; color: #842029; }
.mp-dropdown i { font-size: 16px; width: 20px; text-align: center; }

/* ===== CONTENT ===== */
main.mp-content { padding: 20px; max-width: 1200px; margin: 0 auto; }

/* ===== ALERT ===== */
.mp-alert {
  background: #fff; border: 1px solid var(--border);
  border-left: 4px solid var(--primary);
  border-radius: 12px; padding: 12px 16px; margin-bottom: 16px;
  font-size: 13px;
}
.mp-alert.success { border-left-color: #2e7d32; background: #f0f9f1; color: #1b5e20; }
.mp-alert.danger  { border-left-color: #c62828; background: #fdf3f3; color: #b71c1c; }

/* ===== BUTTONS (sinkron sama admin) ===== */
.btn-primary { background: var(--primary); border-color: var(--primary); }
.btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }

@keyframes wobble {
  0%,100% { transform: rotate(0); }
  25%     { transform: rotate(-8deg); }
  75%     { transform: rotate(8deg); }
}

/* ===== RESPONSIVE ===== */
@media (min-width: 768px) {
  .mp-page-title { display: block; }
  .mp-user-info  { display: block; }
  main.mp-content { padding: 28px; }
}
@media (max-width: 575px) {
  .mp-navbar .container { padding: 12px 14px; }
  .mp-brand-text .t1 { font-size: 14px; }
  .mp-avatar { width: 38px; height: 38px; font-size: 13px; }
  main.mp-content { padding: 14px; }
}
</style>
@stack('styles')
</head>
<body>

@php
$user = auth()->user();
$initial = strtoupper(substr($user->name ?? 'U', 0, 1));
@endphp

<!-- ===== NAVBAR ===== -->
<nav class="mp-navbar">
  <div class="container">
    {{-- Brand (kiri) --}}
    <a href="{{ route('manpower.laporan.create') }}" class="mp-brand">
      <div class="mp-brand-icon"><i class="bi bi-egg-fried"></i></div>
      <div class="mp-brand-text">
        <div class="t1">BukanAyam</div>
        <div class="t2">Portal Man Power</div>
      </div>
    </a>

    {{-- Judul halaman (tengah, md+) --}}
    <div class="mp-page-title">
      <i class="bi bi-pencil-square"></i>
      @yield('title', 'Input Laporan Harian')
    </div>

    {{-- User (kanan) --}}
    <div class="mp-user">
      <div class="mp-user-info">
        <div class="name">{{ $user->name ?? 'User' }}</div>
        <div class="role">Man Power</div>
      </div>
      <div class="mp-avatar" id="mpAvatarBtn" title="Menu">
        {{ $initial }}
      </div>

      {{-- Dropdown --}}
      <div class="mp-dropdown" id="mpDropdown">
        <div class="user-head">
          <div class="av">{{ $initial }}</div>
          <div>
            <div class="nm">{{ $user->name ?? 'User' }}</div>
            <div class="rl">{{ $user->email ?? '' }}</div>
          </div>
        </div>
        <a href="{{ route('manpower.laporan.create') }}">
          <i class="bi bi-pencil-square"></i> Input Laporan Harian
        </a>
        <a href="{{ url('/') }}">
          <i class="bi bi-house-door"></i> Beranda
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="logout">
            <i class="bi bi-box-arrow-right"></i> Keluar
          </button>
        </form>
      </div>
    </div>
  </div>
</nav>

<!-- ===== KONTEN ===== -->
<main class="mp-content">
  @if(session('success'))
    <div class="mp-alert success">
      <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
  @endif
  @if($errors->any())
    <div class="mp-alert danger">
      <strong><i class="bi bi-exclamation-triangle-fill me-1"></i>Terjadi kesalahan:</strong>
      <ul class="mb-0 mt-1 ps-3">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif
  @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
  const btn = document.getElementById('mpAvatarBtn');
  const dd  = document.getElementById('mpDropdown');
  if (!btn || !dd) return;
  btn.addEventListener('click', e => { e.stopPropagation(); dd.classList.toggle('show'); });
  document.addEventListener('click', e => {
    if (!dd.contains(e.target)) dd.classList.remove('show');
  });
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') dd.classList.remove('show');
  });
})();
</script>
@stack('scripts')
@include('partials.cursor-animation')
</body>
</html>
