<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BukanAyam — Sistem Manajemen Peternakan Ayam | Desa Tanjung Agung</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
:root{
  --coklat-900:#2d1b16; --coklat-800:#3e2723; --coklat-700:#4e342e;
  --coklat-600:#5d4037; --coklat-500:#6d4c41; --coklat-400:#8d6e63;
  --krem:#f7f2ea; --krem-2:#efe6d9; --aksen:#d7a86e;
  --teks-terang:#ffe9c9;
}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;background:var(--krem);color:#33261f;margin:0}

/* ================= NAVBAR ================= */
.nav-landing{
  position:fixed; top:0; left:0; right:0; z-index:1030;
  background:transparent;
  border-bottom:1px solid transparent;
  transition: background .35s ease, border-color .35s ease, backdrop-filter .35s ease, padding .35s ease;
  padding: 18px 0;
}
.nav-landing .container{padding:0 24px}
.nav-landing .navbar-brand{display:flex; align-items:center; gap:10px; text-decoration:none;}
.nav-logo{height:46px; width:auto; object-fit:contain; display:block; background:transparent; border:none; box-shadow:none; border-radius:0; padding:0;}
.nav-landing.scrolled .nav-logo{height:38px;}
.brand-divider{width:1px; height:32px; background:currentColor; opacity:.25; margin:0 12px;}
.brand-egg{
  width:40px;height:40px;border-radius:10px;
  background:linear-gradient(135deg,var(--coklat-500),var(--coklat-400));
  display:none; align-items:center;justify-content:center;
  color:#ffe9c9;font-size:20px;
  box-shadow: 0 4px 12px rgba(0,0,0,.25);
}
.brand-text{font-weight: 800; font-size: 20px; letter-spacing: 0.3px;}
.nav-landing .brand-text,
.nav-landing .navbar-brand{color: var(--teks-terang); text-shadow: 0 2px 10px rgba(0,0,0,.45);}
.nav-landing .nav-links a{
  color: var(--teks-terang); text-decoration:none; font-size:14px; font-weight:600;
  margin-left:22px; text-shadow: 0 1px 6px rgba(0,0,0,.4); transition: color .2s, transform .2s; display:inline-block;
}
.nav-landing .nav-links a:hover{color: #fff; transform: translateY(-1px);}
.nav-landing.scrolled{
  background: rgba(45, 27, 22, 0.85);
  backdrop-filter: blur(14px) saturate(140%);
  -webkit-backdrop-filter: blur(14px) saturate(140%);
  border-bottom: 1px solid rgba(255,255,255,0.08);
  padding: 10px 0;
  box-shadow: 0 8px 24px rgba(0,0,0,0.18);
}
.nav-landing.scrolled .brand-text{color:#fff; text-shadow:none; transform:scale(.97); transform-origin:left center; transition:transform .3s ease;}
.nav-landing.scrolled .nav-links a{color: rgba(255,255,255,.9); text-shadow:none;}
.nav-landing.scrolled .nav-links a:hover{color:#fff;}
.nav-spacer{height:80px}
.btn-cta{background:var(--aksen);color:var(--coklat-900);font-weight:700;border:none;padding:8px 18px}
.btn-cta:hover{background:#c6935a;color:var(--coklat-900)}
.btn-ghost{border:1px solid rgba(255,255,255,.55);color:var(--teks-terang);padding:8px 18px;font-weight:600}
.btn-ghost:hover{background:rgba(255,255,255,.15);color:#fff}

/* ================= HERO (tanpa animasi) ================= */
.hero{
  background:linear-gradient(135deg,var(--coklat-900) 0%,var(--coklat-700) 60%,var(--coklat-500) 100%);
  color:#fff; overflow:hidden; position:relative;
  padding: 110px 0 170px;
}
.hero::before{
  content:"";position:absolute;inset:0;
  background: radial-gradient(circle at 20% 30%, rgba(215,168,110,.15), transparent 40%),
              radial-gradient(circle at 80% 70%, rgba(215,168,110,.10), transparent 40%);
  pointer-events:none;
}
.hero-badge{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);color:#ffe9c9}
.hero-egg{
  width:88px;height:88px;border-radius:24px;
  background:linear-gradient(135deg,var(--coklat-500),var(--coklat-400));
  display:flex;align-items:center;justify-content:center;
  font-size:42px;color:#ffe9c9;
  box-shadow:0 10px 30px rgba(0,0,0,.35);
}

/* ================= PEMBATAS GELOMBANG (statis) ================= */
.hero-wave{position:absolute; left:0; right:0; bottom:-1px; line-height:0; pointer-events:none;}
.hero-wave svg{width:100%; height:110px; display:block;}

.section-title{font-weight:800}
.feature-card{background:#fff;border:1px solid #e6dacc;border-radius:16px;padding:24px;height:100%;transition:.2s}
.feature-card:hover{transform:translateY(-4px);box-shadow:0 12px 26px rgba(93,64,55,.14)}
.feature-icon{width:48px;height:48px;border-radius:12px;background:var(--krem-2);color:var(--coklat-600);display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:14px}
.about{background:var(--krem-2)}
.check-item i{color:var(--coklat-500)}
footer{background:var(--coklat-900);color:#cbb5a8}
@media (max-width:991px){
  .nav-landing .nav-links{display:none}
  .brand-text{font-size:17px}
  .hero{padding:90px 0 150px}
  .hero-wave svg{height:80px}
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="nav-landing" id="navLanding">
  <div class="container d-flex align-items-center justify-content-between">
    <a href="{{ url('/') }}" class="navbar-brand">
      <img src="{{ asset('logo.png') }}" alt="Logo Perusahaan" class="nav-logo"
           onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
      <span class="brand-egg"><i class="bi bi-egg-fried"></i></span>
      <span class="brand-divider"></span>
      <span class="brand-text">BukanAyam</span>
    </a>
    <div class="nav-links d-none d-md-block">
      <a href="#fitur">Fitur</a>
      <a href="#tentang">Tentang</a>
    </div>
    <div>
      @auth
        <a href="{{ auth()->user()->role === 'admin' ? route('dashboard') : route('manpower.laporan.create') }}" class="btn btn-cta btn-sm">
          Buka Dashboard <i class="bi bi-arrow-right ms-1"></i>
        </a>
      @else
        <a href="{{ route('login') }}" class="btn btn-cta btn-sm">
          Masuk <i class="bi bi-box-arrow-in-right ms-1"></i>
        </a>
      @endauth
    </div>
  </div>
</nav>
<div class="nav-spacer"></div>

<!-- HERO (bersih, tanpa animasi) -->
<header class="hero">
  <div class="container position-relative" style="z-index:1">
    <div class="row justify-content-center">
      <div class="col-lg-9 text-center">
        <div class="hero-egg mx-auto mb-4"><i class="bi bi-egg-fried"></i></div>
        <span class="badge hero-badge rounded-pill px-3 py-2 mb-3">
          <i class="bi bi-geo-alt-fill me-1"></i> Desa Tanjung Agung
        </span>
        <h1 class="display-4 fw-bold lh-sm mb-3">
          Kelola Peternakan Ayam Jadi <span style="color:var(--aksen)">Lebih Mudah</span>
        </h1>
        <p class="lead mb-4 mx-auto" style="max-width:760px;color:#e8d9c8">
          Aplikasi BukanAyam dikembangkan dengan dukungan PT Pesona Khatulistiwa Nusantara (PKN),
          perusahaan yang berkomitmen pada digitalisasi dan pemberdayaan masyarakat desa.
          Kehadiran PKN membantu peternak ayam di Desa Tanjung Agung beralih dari pencatatan manual
          ke sistem terintegrasi — populasi, produksi telur, penjualan, hingga pakan tercatat akurat
          dan dapat dipantau kapan saja.
        </p>
        <div class="d-flex justify-content-center gap-2">
          @auth
            <a href="{{ auth()->user()->role === 'admin' ? route('dashboard') : route('manpower.laporan.create') }}" class="btn btn-cta">
              Buka Dashboard <i class="bi bi-arrow-right ms-1"></i>
            </a>
          @else
            <a href="{{ route('login') }}" class="btn btn-cta">
              Masuk <i class="bi bi-box-arrow-in-right ms-1"></i>
            </a>
            <a href="#fitur" class="btn btn-ghost">Lihat Fitur</a>
          @endauth
        </div>
      </div>
    </div>
  </div>

  {{-- ===== PEMBATAS GELOMBANG (statis, tanpa animasi) ===== --}}
  <div class="hero-wave" aria-hidden="true">
    <svg viewBox="0 0 1440 110" preserveAspectRatio="none">
      <path d="M0,70 C180,100 360,40 540,55 C720,70 900,100 1080,80 C1260,60 1350,45 1440,60 L1440,110 L0,110 Z"
            fill="rgba(247,242,234,0.35)"></path>
      <path d="M0,85 C240,110 480,55 720,70 C960,85 1200,105 1440,75 L1440,110 L0,110 Z"
            fill="#f7f2ea"></path>
    </svg>
  </div>
</header>

<!-- FITUR -->
<section id="fitur" class="py-5">
  <div class="container py-4">
    <div class="text-center mb-5">
      <h2 class="section-title">Fitur Utama</h2>
      <p class="text-muted">Semua yang dibutuhkan peternakan dalam satu aplikasi.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-people-fill"></i></div>
          <h5 class="fw-bold">Populasi Ayam</h5>
          <p class="small text-muted mb-0">Pencatatan ayam hidup, mati, dan afkir dengan sisa populasi yang terhitung otomatis per kandang.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-egg-fill"></i></div>
          <h5 class="fw-bold">Produksi Telur</h5>
          <p class="small text-muted mb-0">Catat produksi telur harian lengkap dengan persentase dan kualitas telur (bagus / reject).</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-cash-stack"></i></div>
          <h5 class="fw-bold">Penjualan Telur</h5>
          <p class="small text-muted mb-0">Pencatatan penjualan dengan customer, jumlah, dan total harga yang otomatis terakumulasi.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-basket-fill"></i></div>
          <h5 class="fw-bold">Manajemen Pakan</h5>
          <p class="small text-muted mb-0">Stok gudang pakan, pengambilan per kandang, dan laporan pakan yang dihitung otomatis.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-clipboard2-data-fill"></i></div>
          <h5 class="fw-bold">Laporan Harian Man Power</h5>
          <p class="small text-muted mb-0">Anak kandang mencatat kondisi lapangan lewat form sederhana langsung dari HP.</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-shield-lock-fill"></i></div>
          <h5 class="fw-bold">Multi-Role Admin & Man Power</h5>
          <p class="small text-muted mb-0">Hak akses terpisah antara admin dan anak kandang, sehingga data tetap aman dan terjaga.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TENTANG -->
<section id="tentang" class="about py-5">
  <div class="container py-4">
    <div class="row align-items-center g-4">
      <div class="col-lg-6">
        <h2 class="section-title mb-3">Tentang Aplikasi</h2>
        <p class="mb-3">
          BukanAyam dibangun untuk membantu peternakan ayam di
          <strong>Desa Tanjung Agung</strong> mencatat dan mengelola data peternakan
          secara digital. Data yang sebelumnya tersebar di buku catatan — populasi
          ayam, produksi telur, penjualan, sampai pemakaian pakan — kini terkumpul
          dalam satu sistem yang bisa diakses kapan saja.
        </p>
        <ul class="list-unstyled mb-0">
          <li class="check-item mb-2"><i class="bi bi-check-circle-fill me-2"></i>Pencatatan lapangan langsung oleh man power</li>
          <li class="check-item mb-2"><i class="bi bi-check-circle-fill me-2"></i>Perhitungan populasi & sisa pakan otomatis</li>
          <li class="check-item mb-2"><i class="bi bi-check-circle-fill me-2"></i>Laporan produksi dan pakan yang terintegrasi</li>
          <li class="check-item mb-2"><i class="bi bi-check-circle-fill me-2"></i>Dashboard terpisah untuk admin dan man power</li>
        </ul>
      </div>
      <div class="col-lg-6">
        <div class="feature-card text-center p-5">
          <div class="feature-icon mx-auto" style="width:70px;height:70px;font-size:32px">
            <i class="bi bi-egg-fried"></i>
          </div>
          <h4 class="fw-bold mt-3">BukanAyam</h4>
          <p class="text-muted small mb-4">Sistem Manajemen Peternakan Ayam</p>
          <div class="d-flex justify-content-center gap-2 flex-wrap">
            <span class="badge rounded-pill" style="background:var(--krem-2);color:var(--coklat-600)">
              <i class="bi bi-geo-alt me-1"></i>Desa Tanjung Agung
            </span>
            <span class="badge rounded-pill" style="background:var(--krem-2);color:var(--coklat-600)">
              <i class="bi bi-calendar3 me-1"></i>{{ date('Y') }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<footer class="py-4">
  <div class="container d-flex flex-wrap justify-content-between gap-2 small">
    <span><i class="bi bi-egg-fried me-1"></i> BukanAyam — Desa Tanjung Agung</span>
    <span>© {{ date('Y') }} Sistem Manajemen Peternakan Ayam</span>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const nav = document.getElementById('navLanding');
  function onScroll(){
    if (window.scrollY > 30) nav.classList.add('scrolled');
    else nav.classList.remove('scrolled');
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
</script>
</body>
</html>
