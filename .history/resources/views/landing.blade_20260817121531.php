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
}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;background:var(--krem);color:#33261f}

.nav-landing{background:var(--coklat-800)}
.nav-landing .navbar-brand{font-weight:800;color:#fff}
.brand-egg{width:38px;height:38px;border-radius:10px;background:var(--coklat-500);display:inline-flex;align-items:center;justify-content:center;color:#ffe9c9;font-size:18px;margin-right:8px}
.brand-egg i{display:inline-block;animation:wobble 2.6s ease-in-out infinite}
.btn-cta{background:var(--aksen);color:var(--coklat-900);font-weight:700;border:none}
.btn-cta:hover{background:#c6935a;color:var(--coklat-900)}
.btn-ghost{border:1px solid rgba(255,255,255,.45);color:#fff}
.btn-ghost:hover{background:rgba(255,255,255,.12);color:#fff}

.hero{background:linear-gradient(135deg,var(--coklat-900),var(--coklat-600));color:#fff;overflow:hidden}
.hero-badge{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);color:#ffe9c9}

.egg-stage{position:relative;min-height:360px}
.egg{position:absolute;background:linear-gradient(180deg,#fff8ee,#e8d5bd);border-radius:50% 50% 50% 50%/60% 60% 40% 40%;box-shadow:0 16px 28px rgba(0,0,0,.28)}
.egg.big{width:170px;height:215px;left:50%;margin-left:-85px;top:70px;animation:float 4s ease-in-out infinite}
.egg.s1{width:64px;height:80px;left:8%;top:40px;animation:float 3.2s .3s ease-in-out infinite}
.egg.s2{width:46px;height:58px;right:10%;top:20px;animation:float 3.6s .8s ease-in-out infinite}
.egg.s3{width:54px;height:68px;right:20%;bottom:30px;animation:float 3s 1.2s ease-in-out infinite}
.egg-shadow{position:absolute;width:150px;height:26px;background:rgba(0,0,0,.3);border-radius:50%;left:50%;margin-left:-75px;bottom:26px;filter:blur(4px);animation:shadow 4s ease-in-out infinite}
.chick-badge{position:absolute;left:14%;bottom:60px;width:64px;height:64px;border-radius:50%;background:var(--aksen);display:flex;align-items:center;justify-content:center;font-size:28px;color:var(--coklat-900);box-shadow:0 12px 22px rgba(0,0,0,.25);animation:float 3.4s .5s ease-in-out infinite}
@keyframes float{0%,100%{transform:translateY(0) rotate(-2deg)}50%{transform:translateY(-16px) rotate(2deg)}}
@keyframes shadow{0%,100%{transform:scale(1);opacity:.35}50%{transform:scale(.82);opacity:.22}}
@keyframes wobble{0%,100%{transform:rotate(0)}25%{transform:rotate(-10deg)}75%{transform:rotate(10deg)}}

.section-title{font-weight:800}
.feature-card{background:#fff;border:1px solid #e6dacc;border-radius:16px;padding:24px;height:100%;transition:.2s}
.feature-card:hover{transform:translateY(-4px);box-shadow:0 12px 26px rgba(93,64,55,.14)}
.feature-icon{width:48px;height:48px;border-radius:12px;background:var(--krem-2);color:var(--coklat-600);display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:14px}
.about{background:var(--krem-2)}
.check-item i{color:var(--coklat-500)}
footer{background:var(--coklat-900);color:#cbb5a8}
</style>
</head>
<body>

<nav class="navbar navbar-dark nav-landing sticky-top">
  <div class="container">
    <span class="navbar-brand d-flex align-items-center">
      <span class="brand-egg"><i class="bi bi-egg-fried"></i></span> BukanAyam
    </span>
    <div class="ms-auto d-flex gap-2">
      <a href="#fitur" class="btn btn-ghost btn-sm d-none d-md-inline">Fitur</a>
      <a href="#tentang" class="btn btn-ghost btn-sm d-none d-md-inline">Tentang</a>
      @auth
        <a href="{{ auth()->user()->role === 'admin' ? route('dashboard') : route('manpower.laporan.create') }}" class="btn btn-cta btn-sm">
          Buka Dashboard <i class="bi bi-arrow-right ms-1"></i>
        </a>
      @else
        <a href="{{ route('login') }}" class="btn btn-cta btn-sm">Masuk <i class="bi bi-box-arrow-in-right ms-1"></i></a>
      @endauth
    </div>
  </div>
</nav>

<header class="hero py-5">
  <div class="container py-4">
    <div class="row align-items-center g-4">
      <div class="col-lg-6">
        <span class="badge hero-badge rounded-pill px-3 py-2 mb-3">
          <i class="bi bi-geo-alt-fill me-1"></i> Desa Tanjung Agung
        </span>
        <h1 class="display-5 fw-bold lh-sm mb-3">
          Kelola Peternakan Ayam Jadi <span style="color:var(--aksen)">Lebih Mudah</span>
        </h1>
        <p class="lead mb-4" style="color:#e8d9c8">
          BukanAyam adalah aplikasi pencatatan pengelolaan data peternakan ayam —
          populasi, produksi telur, penjualan, hingga pakan — untuk peternakan di
          Desa Tanjung Agung, dalam satu sistem yang rapi dan terhubung.
        </p>
        <div class="d-flex gap-2 flex-wrap">
          <a href="{{ route('login') }}" class="btn btn-cta btn-lg px-4">
            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Aplikasi
          </a>
          <a href="#fitur" class="btn btn-ghost btn-lg px-4">Lihat Fitur</a>
        </div>
      </div>
      <div class="col-lg-6 d-none d-lg-block">
        <div class="egg-stage">
          <div class="egg big"></div>
          <div class="egg s1"></div>
          <div class="egg s2"></div>
          <div class="egg s3"></div>
          <div class="chick-badge"><i class="bi bi-egg-fried"></i></div>
          <div class="egg-shadow"></div>
        </div>
      </div>
    </div>
  </div>
</header>

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
</body>
</html>
