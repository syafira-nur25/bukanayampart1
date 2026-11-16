<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Laporan Harian')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root {
--primary: #1e3a5f;
--primary-dark: #152a45;
--primary-soft: #e0e7ff;
--border: #e2e8f0;
--muted: #718096;
--text: #1a202c;
--krem: #f0f4f8;
--krem-2: #e2e8f0;
}
body { background: var(--krem); color: var(--text); }
.topbar { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); }
.topbar .brand-logo { height: 38px; width: auto; object-fit: contain; }
.topbar .brand-icon {
width: 38px; height: 38px; display: none; align-items: center; justify-content: center;
background: #3b82f6; border-radius: 10px; color: #fff; font-size: 18px;
}
.topbar .brand-icon i { display: inline-block; animation: wobble 2.6s ease-in-out infinite; }
.topbar .brand-label { font-size: 13px; color: #cbd5e1; font-weight: 600; }
.btn-success { background: #10b981; border-color: #10b981; }
.btn-success:hover { background: #059669; border-color: #059669; }
@keyframes wobble { 0%,100% { transform: rotate(0); } 25% { transform: rotate(-10deg); } 75% { transform: rotate(10deg); } }
</style>
</head>
<body>
<nav class="topbar navbar navbar-dark px-3">
<span class="navbar-brand fw-bold d-flex align-items-center gap-2">
<img src="{{ asset('logo.png') }}" alt="Logo" class="brand-logo"
onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
<span class="brand-icon"><i class="bi bi-egg-fried"></i></span>
</span>
<div class="d-flex align-items-center gap-2">
<span class="text-white small d-none d-md-inline">{{ auth()->user()->name ?? '' }}</span>
<form method="POST" action="{{ route('logout') }}" class="mb-0">
@csrf
<button type="submit" class="btn btn-sm btn-outline-light">
<i class="bi bi-box-arrow-right me-1"></i>Keluar
</button>
</form>
</div>
</nav>
<main class="container py-4" style="max-width: 980px;">
@if (session('success'))
<div class="alert alert-success border-0 shadow-sm"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
@endif
@if ($errors->any())
<div class="alert alert-danger border-0 shadow-sm">
<strong>Periksa kembali:</strong>
<ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif
@yield('content')
</main>
</body>
</html>
