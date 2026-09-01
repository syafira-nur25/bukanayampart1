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
  --primary-soft: #f4ede6;
  --bg: #f7f2ea;
  --text: #33261f;
  --muted: #8a7a6e;
  --border: #e6dacc;
}
* { box-sizing: border-box; }
body {
  margin: 0; font-family: 'Inter', sans-serif; color: var(--text);
  background: linear-gradient(180deg, #f7f2ea 0%, #efe6d9 100%);
  min-height: 100vh;
}

/* ===== NAVBAR BARU ===== */
.mp-navbar {
  position: sticky; top: 0; z-index: 1000;
  background: rgba(255,255,255,.88);
  backdrop-filter: blur(14px);
  -webkit-backdrop-filter: blur(14px);
  border-bottom: 1px solid var(--border);
  box-shadow: 0 4px 20px rgba(93,64,55,.07);
  padding: 10px 0;
}
.mp-logo {
  width: 42px; height: 42px; border-radius: 12px;
  background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  color: #ffe9c9; display: flex; align-items: center; justify-content: center;
  font-size: 20px; box-shadow: 0 4px 12px rgba(93,64,55,.3); flex-shrink: 0;
}
.mp-logo i { display: inline-block; animation: wobble 2.6s ease-in-out infinite; }
.mp-brand-name { font-weight: 800; font-size: 16px; line-height: 1.1; }
.mp-brand-sub { font-size: 10.5px; color: var(--muted); letter-spacing: .6px; text-transform: uppercase; }
.mp-date-chip {
  display: inline-flex; align-items: center; gap: 7px;
  background: var(--primary-soft); color: var(--primary-dark);
  border-radius: 999px; padding: 7px 14px; font-size: 12px; font-weight: 600;
}
.mp-avatar {
  width: 38px; height: 38px; border-radius: 50%;
  background: var(--primary-soft); color: var(--primary-dark);
  font-weight: 700; display: flex; align-items: center; justify-content: center;
  border: 2px solid #fff; box-shadow: 0 2px 8px rgba(93,64,55,.2); flex-shrink: 0;
}
.mp-user-name { font-size: 13px; font-weight: 700; line-height: 1.1; }
.mp-user-role { font-size: 10.5px; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; }
.mp-logout {
  border: none; background: transparent; color: var(--muted);
  border-radius: 999px; padding: 8px 14px; font-size: 13px; font-weight: 600; transition: .2s;
}
.mp-logout:hover { background: #f8d7da; color: #842029; }

main.mp-main { padding: 28px 16px 60px; }
.container-form { max-width: 980px; }

@keyframes wobble { 0%,100% { transform: rotate(0); } 25% { transform: rotate(-10deg); } 75% { transform: rotate(10deg); } }
</style>
</head>
<body>

{{-- ===== NAVBAR ===== --}}
<nav class="mp-navbar">
  <div class="container container-form d-flex align-items-center justify-content-between gap-2">
    <div class="d-flex align-items-center gap-2">
      <div class="mp-logo"><i class="bi bi-egg-fried"></i></div>
      <div>
        <div class="mp-brand-name">BukanAyam</div>
        <div class="mp-brand-sub">Portal Man Power</div>
      </div>
    </div>

    <div class="d-flex align-items-center gap-2">
      <span class="mp-date-chip d-none d-sm-inline-flex">
        <i class="bi bi-calendar3"></i> {{ now()->translatedFormat('l, j M Y') }}
      </span>
      <div class="d-flex align-items-center gap-2">
        <div class="mp-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
        <div class="d-none d-md-block">
          <div class="mp-user-name">{{ auth()->user()->name ?? 'User' }}</div>
          <div class="mp-user-role">Man Power</div>
        </div>
      </div>
      <form method="POST" action="{{ route('logout') }}" class="mb-0">
        @csrf
        <button class="mp-logout" title="Keluar">
          <i class="bi bi-box-arrow-right"></i><span class="d-none d-sm-inline"> Keluar</span>
        </button>
      </form>
    </div>
  </div>
</nav>

<main class="mp-main">
  <div class="container container-form">
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
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
