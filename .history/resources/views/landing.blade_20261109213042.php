<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Manajemen Peternakan Ayam | Desa Tanjung Agung</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
:root{
--navy-900:#152a45; --navy-800:#1e3a5f; --navy-700:#2c5282;
--navy-600:#3b82f6; --navy-500:#60a5fa; --navy-400:#93c5fd;
--background:#f0f4f8; --background-2:#e2e8f0; --aksen:#3b82f6;
--teks-terang:#ffffff;
}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;background:var(--background);color:#1a202c;margin:0}
.nav-landing{
position:fixed; top:0; left:0; right:0; z-index:1030;
background:transparent;
border-bottom:1px solid transparent;
transition: background .35s ease, border-color .35s ease, backdrop-filter .35s ease, padding .35s ease;
padding: 18px 0;
}
.nav-landing .container{padding:0 24px}
.nav-landing .navbar-brand{display:flex; align-items:center; gap:10px; text-decoration:none;}
.brand-logos{display:flex;align-items:center;gap:12px;}
.nav-logo{height:46px;width:auto;object-fit:contain;display:block;background:transparent;border:none;box-shadow:none;border-radius:0;padding:0}
.nav-logo-pkn{height:42px;background:transparent;border-radius:0;padding:0;box-shadow:none;}
.nav-landing.scrolled .nav-logo{height:38px}
.nav-landing.scrolled .nav-logo-pkn{height:34px}
.brand-egg{
width:40px;height:40px;border-radius:10px;
background:linear-gradient(135deg,var(--navy-800),var(--navy-700));
display:none;align-items:center;justify-content:center;
color:#fff;font-size:20px;box-shadow:0 4px 12px rgba(0,0,0,.25);
}
.brand-egg i{display:inline-block;animation:wobble 2.6s ease-in-out infinite}
.nav-landing .nav-links a{color:var(--teks-terang);text-decoration:none;font-size:14px;font-weight:600;margin-left:22px;text-shadow:0 1px 6px rgba(0,0,0,.4);transition:color .2s,transform .2s;display:inline-block}
.nav-landing .nav-links a:hover{color:#fff;transform:translateY(-1px)}
.nav-landing.scrolled{
background:rgba(21,42,69,.9);
backdrop-filter:blur(14px) saturate(140%);
-webkit-backdrop-filter:blur(14px) saturate(140%);
border-bottom:1px solid rgba(255,255,255,.08);
padding:10px 0;box-shadow:0 8px 24px rgba(0,0,0,.18);
}
.nav-landing.scrolled .nav-links a{color:rgba(255,255,255,.9);text-shadow:none}
.nav-landing.scrolled .nav-links a:hover{color:#fff}
.btn-cta{background:var(--aksen);color:#fff;font-weight:700;border:none;padding:8px 18px}
.btn-cta:hover{background:#2563eb;color:#fff}

/* ===== HERO BARU ===== */
.hero-new{
position:relative;
min-height:640px;
display:flex;
align-items:center;
background:
linear-gradient(90deg, rgba(21,42,69,.95) 0%, rgba(21,42,69,.75) 45%, rgba(21,42,69,.15) 100%),
url("{{ asset('gambar1.png') }}") center/cover no-repeat;
color:#fff;
padding:140px 0 80px;
overflow:hidden;
}
.hero-new::before{
content:"";
position:absolute;
top:0; left:0; right:0; bottom:0;
background:radial-gradient(circle at 80% 50%, rgba(59,130,246,.15), transparent 50%);
pointer-events:none;
}
.hero-new .container{position:relative;z-index:1}
.hero-new .badge-top{
display:inline-flex;align-items:center;gap:8px;
background:rgba(255,255,255,.15);
border:1px solid rgba(255,255,255,.3);
color:#fff;
padding:8px 16px;
border-radius:30px;
font-size:13px;font-weight:600;
margin-bottom:24px;
}
.hero-new h1{
font-size:52px;
font-weight:900;
line-height:1.1;
margin-bottom:20px;
letter-spacing:-0.5px;
}
.hero-new h1 span{color:var(--navy-500)}
.hero-new p{
font-size:16px;
opacity:.9;
line-height:1.6;
max-width:540px;
margin-bottom:32px;
}
.hero-new .hero-btns{display:flex;gap:14px;flex-wrap:wrap}
.btn-hero-primary{
background:var(--aksen);
color:#fff;
border:none;
padding:14px 28px;
border-radius:10px;
font-weight:700;
font-size:14px;
text-decoration:none;
display:inline-flex;align-items:center;gap:8px;
transition:.2s;
}
.btn-hero-primary:hover{background:#2563eb;color:#fff;transform:translateY(-2px);box-shadow:0 8px 20px rgba(59,130,246,.4)}
.btn-hero-outline{
background:transparent;
color:#fff;
border:2px solid rgba(255,255,255,.5);
padding:12px 26px;
border-radius:10px;
font-weight:700;
font-size:14px;
text-decoration:none;
display:inline-flex;align-items:center;gap:8px;
transition:.2s;
}
.btn-hero-outline:hover{background:rgba(255,255,255,.1);border-color:#fff;color:#fff}

/* ===== SECTION KANDANG ===== */
.kandang-section{
padding:80px 0;
background:#fff;
}
.section-label{
font-size:12px;
font-weight:700;
letter-spacing:1.5px;
text-transform:uppercase;
color:var(--aksen);
margin-bottom:10px;
}
.section-title{
font-size:32px;
font-weight:800;
color:var(--navy-900);
margin-bottom:14px;
}
.section-subtitle{
font-size:15px;
color:#718096;
margin-bottom:48px;
max-width:620px;
}
.kandang-card{
background:#fff;
border:1px solid var(--background-2);
border-radius:20px;
overflow:hidden;
transition:.3s;
height:100%;
}
.kandang-card:hover{
transform:translateY(-6px);
box-shadow:0 20px 40px rgba(30,58,95,.12);
border-color:var(--aksen);
}
.kandang-img-wrap{
position:relative;
height:280px;
overflow:hidden;
background:var(--background);
}
.kandang-img-wrap img{
width:100%;
height:100%;
object-fit:cover;
transition:transform .5s ease;
}
.kandang-card:hover .kandang-img-wrap img{transform:scale(1.06)}
.kandang-badge{
position:absolute;
top:16px;left:16px;
background:var(--aksen);
color:#fff;
padding:6px 14px;
border-radius:30px;
font-size:12px;
font-weight:700;
display:inline-flex;align-items:center;gap:6px;
}
.kandang-body{padding:24px}
.kandang-body h3{
font-size:20px;
font-weight:800;
color:var(--navy-900);
margin-bottom:10px;
}
.kandang-body p{
font-size:14px;
color:#718096;
line-height:1.6;
margin-bottom:18px;
}
.kandang-stats{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:12px;
padding-top:16px;
border-top:1px solid var(--background-2);
}
.kandang-stat{
text-align:center;
}
.kandang-stat .val{
font-size:18px;
font-weight:800;
color:var(--navy-900);
display:block;
}
.kandang-stat .lbl{
font-size:11px;
color:#718096;
text-transform:uppercase;
letter-spacing:.5px;
}

/* ===== TENTANG ===== */
.about{background:var(--background)}
.check-item i{color:var(--navy-600)}
.feature-card{background:#fff;border:1px solid var(--background-2);border-radius:16px;padding:24px;height:100%;transition:.2s}
.feature-card:hover{transform:translateY(-4px);box-shadow:0 12px 26px rgba(30,58,95,.14)}
.feature-icon{width:48px;height:48px;border-radius:12px;background:var(--background-2);color:var(--navy-700);display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:14px}

/* ===== FOOTER ===== */
footer{background:var(--navy-900);color:#cbd5e1}

@keyframes wobble{0%,100% { transform: rotate(0); } 25% { transform: rotate(-10deg); } 75% { transform: rotate(10deg); }}

@media (max-width:991px){
.hero-new{min-height:auto;padding:120px 0 60px;background-position:center}
.hero-new h1{font-size:36px}
.nav-landing .nav-links{display:none}
.section-title{font-size:26px}
.kandang-img-wrap{height:220px}
.nav-logo{height:36px}
.nav-logo-pkn{height:32px}
}
</style>
</head>
<body>
<nav class="nav-landing" id="navLanding">
<div class="container d-flex align-items-center justify-content-between">
<a href="{{ url('/') }}" class="navbar-brand">
<span class="brand-logos">
<img src="{{ asset('logo.png') }}" alt="Logo" class="nav-logo"
onerror="this.style.display='none'; this.parentElement.querySelector('.brand-egg').style.display='flex';">
<img src="{{ asset('logopkn.png') }}" alt="Logo PKN" class="nav-logo nav-logo-pkn"
onerror="this.style.display='none';">
<span class="brand-egg"><i class="bi bi-egg-fried"></i></span>
</span>
</a>
<div class="nav-links d-none d-md-block">
<a href="#tentang">Tentang</a>
<a href="#kandang">Kandang</a>
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

{{-- ===== HERO BARU ===== --}}
<header class="hero-new">
<div class="container">
<div class="row align-items-center">
<div class="col-lg-7">
<span class="badge-top">
<i class="bi bi-geo-alt-fill"></i> Desa Tanjung Agung
</span>
<h1>Raised with Care,<br>Delivered with <span>Quality</span></h1>
<p>
Sistem Manajemen Peternakan Ayam dikembangkan dengan dukungan PT Pesona Khatulistiwa Nusantara (PKN), perusahaan yang berkomitmen pada digitalisasi dan pemberdayaan masyarakat desa. Kehadiran PKN membantu peternak ayam di Desa Tanjung Agung beralih dari pencatatan manual ke sistem terintegrasi.
</p>
<div class="hero-btns">
<a href="#kandang" class="btn-hero-primary">
Lihat Kandang <i class="bi bi-arrow-right"></i>
</a>
<a href="#tentang" class="btn-hero-outline">
Tentang Kami <i class="bi bi-chevron-right"></i>
</a>
</div>
</div>
</div>
</div>
</header>

{{-- ===== SECTION KANDANG ===== --}}
<section id="kandang" class="kandang-section">
<div class="container">
<div class="text-center">
<div class="section-label">Fasilitas Peternakan</div>
<div class="section-title">Kandang Kami</div>
<div class="section-subtitle mx-auto">
Dua kandang modern dengan standar kebersihan dan kenyamanan tinggi untuk menghasilkan produk berkualitas.
</div>
</div>
<div class="row g-4">
{{-- KANDANG 1 --}}
<div class="col-md-6">
<div class="kandang-card">
<div class="kandang-img-wrap">
<img src="{{ asset('kandang1.png') }}" alt="Kandang 1"
onerror="this.src='https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?w=800';">
<span class="kandang-badge"><i class="bi bi-house-door-fill"></i> Kandang 1</span>
</div>
<div class="kandang-body">
<h3>Kandang 1</h3>
<p>Kandang utama dengan kapasitas besar, dilengkapi sistem ventilasi dan pencahayaan yang optimal untuk kesehatan ayam.</p>
<div class="kandang-stats">
<div class="kandang-stat">
<span class="val">A</span>
<span class="lbl">Kelas</span>
</div>
<div class="kandang-stat">
<span class="val">Besar</span>
<span class="lbl">Kapasitas</span>
</div>
<div class="kandang-stat">
<span class="val">Aktif</span>
<span class="lbl">Status</span>
</div>
</div>
</div>
</div>
</div>
{{-- KANDANG 2 --}}
<div class="col-md-6">
<div class="kandang-card">
<div class="kandang-img-wrap">
<img src="{{ asset('kandang2.png') }}" alt="Kandang 2"
onerror="this.src='https://images.unsplash.com/photo-1569396116180-210c182bedb8?w=800';">
<span class="kandang-badge"><i class="bi bi-house-door-fill"></i> Kandang 2</span>
</div>
<div class="kandang-body">
<h3>Kandang 2</h3>
<p>Kandang pendukung dengan desain ergonomis, menjaga kebersihan dan kenyamanan ayam untuk produksi telur maksimal.</p>
<div class="kandang-stats">
<div class="kandang-stat">
<span class="val">A</span>
<span class="lbl">Kelas</span>
</div>
<div class="kandang-stat">
<span class="val">Sedang</span>
<span class="lbl">Kapasitas</span>
</div>
<div class="kandang-stat">
<span class="val">Aktif</span>
<span class="lbl">Status</span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

{{-- ===== TENTANG ===== --}}
<section id="tentang" class="about py-5">
<div class="container py-4">
<div class="row align-items-center g-4">
<div class="col-lg-6">
<div class="section-label">Tentang Aplikasi</div>
<h2 class="section-title mb-3">A Farm Built on Trust & Tradition</h2>
<p class="mb-3">
Aplikasi ini dibangun untuk membantu peternakan ayam di
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
<p class="text-muted small mb-0 mt-3">Sistem Manajemen Peternakan Ayam</p>
<div class="d-flex justify-content-center gap-2 flex-wrap mt-3">
<span class="badge rounded-pill" style="background:var(--background-2);color:var(--navy-700)">
<i class="bi bi-geo-alt me-1"></i>Desa Tanjung Agung
</span>
<span class="badge rounded-pill" style="background:var(--background-2);color:var(--navy-700)">
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
<span><i class="bi bi-egg-fried me-1"></i> Desa Tanjung Agung</span>
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
