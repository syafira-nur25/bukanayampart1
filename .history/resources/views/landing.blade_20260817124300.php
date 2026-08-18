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
  --teks-terang:#ffe9c9; /* krem-emas untuk kontras di atas coklat gelap */
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

.nav-landing .navbar-brand{
  display:flex; align-items:center; gap:10px;
  text-decoration:none;
}
/* Logo perusahaan — bersih, tanpa background/border/bayangan */
.nav-logo{
  height: 46px;
  width: auto;
  object-fit: contain;
  display: block;
  background: transparent;
  border: none;
  box-shadow: none;
  border-radius: 0;
  padding: 0;
}
.nav-landing.scrolled .nav-logo{ height: 40px; }

.brand-divider{
  width: 1px;
  height: 32px;
  background: currentColor;
  opacity: .25;
  margin: 0 12px;
}

.brand-text{
  font-weight: 800;
  font-size: 20px;
  letter-spacing: 0.3px;
}
.brand-fallback{
  width:40px;height:40px;border-radius:10px;
  background:linear-gradient(135deg,var(--coklat-500),var(--coklat-400));
  display:inline-flex;align-items:center;justify-content:center;
  color:#ffe9c9;font-size:20px;
  box-shadow: 0 4px 12px rgba(0,0,0,.25);
}
.brand-fallback i{display:inline-block;animation:wobble 2.6s ease-in-out infinite}

/* WARNA BRAND & LINK: krem-emas, kontras dengan coklat gelap hero */
.nav-landing .brand-text,
.nav-landing .navbar-brand{
  color: var(--teks-terang);
  text-shadow: 0 2px 10px rgba(0,0,0,.45);
}
.nav-landing .nav-links a{
  color: var(--teks-terang);
  text-decoration:none;
  font-size:14px;
  font-weight:600;
  margin-left:22px;
  text-shadow: 0 1px 6px rgba(0,0,0,.4);
  transition: color .2s, transform .2s;
  display:inline-block;
}
.nav-landing .nav-links a:hover{
  color: #fff;
  transform: translateY(-1px);
}

/* ===== STATE SCROLLED ===== */
.nav-landing.scrolled{
  background: rgba(45, 27, 22, 0.85);
  backdrop-filter: blur(14px) saturate(140%);
  -webkit-backdrop-filter: blur(14px) saturate(140%);
  border-bottom: 1px solid rgba(255,255,255,0.08);
  padding: 10px 0;
  box-shadow: 0 8px 24px rgba(0,0,0,0.18);
}
.nav-landing.scrolled .nav-logo{ height: 38px; }
.nav-landing.scrolled .brand-text{
  color: #fff;
  text-shadow: none;
  transform: scale(.97);
  transform-origin: left center;
  transition: transform .3s ease;
}
.nav-landing.scrolled .nav-links a{
  color: rgba(255,255,255,.9);
  text-shadow: none;
}
.nav-landing.scrolled .nav-links a:hover{ color:#fff; }

.nav-spacer{height:80px}

/* ================= BUTTONS ================= */
.btn-cta{background:var(--aksen);color:var(--coklat-900);font-weight:700;border:none;padding:8px 18px}
.btn-cta:hover{background:#c6935a;color:var(--coklat-900)}
.btn-ghost{border:1px solid rgba(255,255,255,.55);color:var(--teks-terang);padding:8px 18px;font-weight:600}
.btn-ghost:hover{background:rgba(255,255,255,.15);color:#fff}

/* ================= HERO ================= */
.hero{
  background:linear-gradient(135deg,var(--coklat-900) 0%,var(--coklat-700) 60%,var(--coklat-500) 100%);
  color:#fff;overflow:hidden;position:relative;
  padding: 100px 0 80px;
}
.hero::before{
  content:"";position:absolute;inset:0;
  background: radial-gradient(circle at 20% 30%, rgba(215,168,110,.15), transparent 40%),
              radial-gradient(circle at 80% 70%, rgba(215,168,110,.10), transparent 40%);
  pointer-events:none;
}
.hero-badge{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);color:#ffe9c9}

/* ================= STAGE AYAM ================= */
.stage{position:relative;min-height:440px}
.egg{position:absolute;background:linear-gradient(180deg,#fff8ee,#e8d5bd);border-radius:50% 50% 50% 50%/60% 60% 40% 40%;box-shadow:0 16px 28px rgba(0,0,0,.28)}
.egg.s1{width:64px;height:80px;left:6%;top:30px;animation:float 3.2s .3s ease-in-out infinite}
.egg.s2{width:46px;height:58px;right:8%;top:20px;animation:float 3.6s .8s ease-in-out infinite}
.egg.s3{width:54px;height:68px;right:18%;bottom:60px;animation:float 3s 1.2s ease-in-out infinite}

.chicken-wrap{
  position:absolute;left:50%;top:50%;
  transform:translate(-50%,-50%);
  width: 320px; height: 320px;
}
.chicken-wrap svg{width:100%;height:100%;overflow:visible}

.ch-body{transform-origin:50% 100%;animation:bodyBounce 1.4s ease-in-out infinite}
.ch-head{transform-origin:50% 100%;animation:headNod 2s ease-in-out infinite}
.ch-wing-left{transform-origin:90% 30%;animation:flapL 0.9s ease-in-out infinite}
.ch-wing-right{transform-origin:10% 30%;animation:flapR 0.9s ease-in-out infinite}
.ch-tail{transform-origin:50% 80%;animation:tailWag 1.8s ease-in-out infinite}
.ch-comb{transform-origin:50% 100%;animation:combWiggle 1.4s ease-in-out infinite}
.ch-eye{transform-origin:center;animation:blink 4s infinite}
.ch-beak{transform-origin:50% 30%;animation:beakTalk 2.4s ease-in-out infinite}
.ch-egg-drop{transform-origin:center;animation: eggDrop 3.5s ease-in infinite;opacity:0;}
.grass{transform-origin:bottom center;animation:grassSway 3s ease-in-out infinite}

@keyframes bodyBounce{0%,100%{transform:translateY(0) rotate(-1deg)}50%{transform:translateY(-8px) rotate(1deg)}}
@keyframes headNod{0%,100%{transform:translateY(0) rotate(0)}25%{transform:translateY(-3px) rotate(-6deg)}75%{transform:translateY(-1px) rotate(5deg)}}
@keyframes flapL{0%,100%{transform:rotate(-5deg)}50%{transform:rotate(-35deg)}}
@keyframes flapR{0%,100%{transform:rotate(5deg)}50%{transform:rotate(35deg)}}
@keyframes tailWag{0%,100%{transform:rotate(-4deg)}50%{transform:rotate(6deg)}}
@keyframes combWiggle{0%,100%{transform:rotate(0)}50%{transform:rotate(3deg)}}
@keyframes blink{0%, 92%, 100%{transform:scaleY(1)}95%{transform:scaleY(0.1)}}
@keyframes beakTalk{0%,40%,100%{transform:rotate(0)}45%{transform:rotate(8deg)}55%{transform:rotate(-3deg)}65%{transform:rotate(5deg)}}
@keyframes eggDrop{0%{transform:translate(0,0) scale(.6);opacity:0}15%{transform:translate(0,0) scale(.9);opacity:1}70%{transform:translate(-20px,120px) scale(1);opacity:1}90%{transform:translate(-25px,150px) scale(1.05);opacity:.7}100%{transform:translate(-30px,170px) scale(.8);opacity:0}}
@keyframes grassSway{0%,100%{transform:skewX(-2deg)}50%{transform:skewX(3deg)}}
@keyframes float{0%,100%{transform:translateY(0) rotate(-2deg)}50%{transform:translateY(-16px) rotate(2deg)}}
@keyframes wobble{0%,100%{transform:rotate(0)}25%{transform:rotate(-10deg)}75%{transform:rotate(10deg)}}

/* ================= SECTIONS ================= */
.section-title{font-weight:800}
.feature-card{background:#fff;border:1px solid #e6dacc;border-radius:16px;padding:24px;height:100%;transition:.2s}
.feature-card:hover{transform:translateY(-4px);box-shadow:0 12px 26px rgba(93,64,55,.14)}
.feature-icon{width:48px;height:48px;border-radius:12px;background:var(--krem-2);color:var(--coklat-600);display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:14px}
.about{background:var(--krem-2)}
.check-item i{color:var(--coklat-500)}
footer{background:var(--coklat-900);color:#cbb5a8}

@media (max-width:991px){
  .chicken-wrap{width:240px;height:240px}
  .stage{min-height:340px}
  .nav-landing .nav-links{display:none}
  .brand-text{font-size:17px}
}
</style>
</head>
<body>

<a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">
    {{-- Logo perusahaan (bersih, tanpa border) --}}
    <img src="{{ asset('logo.png') }}" alt="Logo Pesona Khatulistiwa Nusantara" class="nav-logo">

    <span class="brand-divider"></span>

    <span class="brand-egg"><i class="bi bi-egg-fried"></i></span>
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

<!-- HERO -->
<header class="hero">
  <div class="container">
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
          @guest
            <a href="{{ route('login') }}" class="btn btn-cta btn-lg px-4">
              <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Aplikasi
            </a>
          @endguest
          <a href="#fitur" class="btn btn-ghost btn-lg px-4">Lihat Fitur</a>
        </div>
      </div>

      <div class="col-lg-6 d-none d-lg-block">
        <div class="stage">
          <div class="egg s1"></div>
          <div class="egg s2"></div>
          <div class="egg s3"></div>

          <div class="chicken-wrap">
            <svg viewBox="0 0 320 320" xmlns="http://www.w3.org/2000/svg">
              <g class="grass">
                <path d="M40 290 Q60 270 80 290 Q100 270 120 290 Q140 270 160 290 Q180 270 200 290 Q220 270 240 290 Q260 270 280 290" stroke="#5d8a4a" stroke-width="4" fill="none" stroke-linecap="round"/>
                <path d="M50 295 L50 280 M90 295 L90 278 M130 295 L130 282 M170 295 L170 278 M210 295 L210 280 M250 295 L250 278" stroke="#6fa05a" stroke-width="2" stroke-linecap="round"/>
              </g>
              <ellipse cx="160" cy="285" rx="70" ry="8" fill="rgba(0,0,0,.25)"/>
              <g class="ch-body">
                <g class="ch-tail">
                  <path d="M230 200 Q275 160 270 110 Q255 140 240 155 Q255 120 245 95 Q230 130 220 150 Q225 115 215 100 Q205 140 210 175 Z" fill="#5d4037"/>
                  <path d="M232 195 Q265 160 260 120" stroke="#3e2723" stroke-width="2" fill="none"/>
                </g>
                <g>
                  <line x1="140" y1="250" x2="135" y2="285" stroke="#f4b400" stroke-width="5" stroke-linecap="round"/>
                  <line x1="180" y1="250" x2="185" y2="285" stroke="#f4b400" stroke-width="5" stroke-linecap="round"/>
                  <path d="M125 285 L135 285 L145 285 M135 285 L135 295" stroke="#f4b400" stroke-width="4" stroke-linecap="round" fill="none"/>
                  <path d="M175 285 L185 285 L195 285 M185 285 L185 295" stroke="#f4b400" stroke-width="4" stroke-linecap="round" fill="none"/>
                </g>
                <ellipse cx="160" cy="210" rx="75" ry="55" fill="#c9a27a"/>
                <ellipse cx="160" cy="215" rx="70" ry="50" fill="#d7b58f"/>
                <ellipse cx="150" cy="230" rx="40" ry="25" fill="#e8cfa8" opacity=".7"/>
                <g class="ch-wing-left">
                  <path d="M210 180 Q250 190 245 230 Q230 215 215 220 Q225 205 210 195 Z" fill="#a0764f"/>
                  <path d="M215 190 Q235 200 232 220" stroke="#7d5a3a" stroke-width="1.5" fill="none"/>
                </g>
                <g class="ch-wing-right">
                  <path d="M110 180 Q70 190 75 230 Q90 215 105 220 Q95 205 110 195 Z" fill="#a0764f"/>
                  <path d="M105 190 Q85 200 88 220" stroke="#7d5a3a" stroke-width="1.5" fill="none"/>
                </g>
                <g class="ch-head">
                  <path d="M145 175 Q160 165 175 175 L175 200 L145 200 Z" fill="#d7b58f"/>
                  <g class="ch-comb">
                    <path d="M140 105 Q145 85 150 100 Q155 80 160 100 Q165 82 170 100 Q175 85 180 108 Q165 115 140 110 Z" fill="#d93636"/>
                    <path d="M142 108 Q150 95 160 105 Q170 95 178 108" stroke="#a02020" stroke-width="1" fill="none"/>
                  </g>
                  <circle cx="160" cy="130" r="38" fill="#d7b58f"/>
                  <circle cx="160" cy="132" r="34" fill="#e8cfa8"/>
                  <circle cx="140" cy="138" r="6" fill="#f4b8b8" opacity=".7"/>
                  <g>
                    <circle cx="148" cy="125" r="6" fill="#fff"/>
                    <circle cx="148" cy="125" r="4" fill="#2d1b16"/>
                    <circle cx="149" cy="124" r="1.5" fill="#fff"/>
                    <ellipse class="ch-eye" cx="148" cy="125" rx="6" ry="6" fill="#d7b58f" transform="scaleY(0)"/>
                  </g>
                  <g>
                    <circle cx="172" cy="125" r="6" fill="#fff"/>
                    <circle cx="172" cy="125" r="4" fill="#2d1b16"/>
                    <circle cx="173" cy="124" r="1.5" fill="#fff"/>
                    <ellipse class="ch-eye" cx="172" cy="125" rx="6" ry="6" fill="#d7b58f" transform="scaleY(0)"/>
                  </g>
                  <g class="ch-beak">
                    <path d="M155 140 L165 140 L160 158 Z" fill="#f4b400"/>
                    <path d="M155 140 L165 140" stroke="#c79000" stroke-width="1"/>
                    <path d="M157 148 L163 148" stroke="#c79000" stroke-width=".5"/>
                  </g>
                  <path d="M155 155 Q160 172 165 155 Q163 165 160 165 Q157 165 155 155 Z" fill="#d93636"/>
                </g>
                <g class="ch-egg-drop">
                  <ellipse cx="160" cy="260" rx="10" ry="13" fill="#fff8ee" stroke="#e8d5bd" stroke-width="1"/>
                  <ellipse cx="158" cy="257" rx="3" ry="4" fill="#fff" opacity=".7"/>
                </g>
              </g>
            </svg>
          </div>
        </div>
      </div>
    </div>
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
