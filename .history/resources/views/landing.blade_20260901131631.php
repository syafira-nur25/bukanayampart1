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
  --rumput-1:#5d8a4a; --rumput-2:#6fa05a; --rumput-3:#84b867;
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
.nav-logo{height:46px;width:auto;object-fit:contain;display:block;background:transparent;border:none;box-shadow:none;border-radius:0;padding:0}
.nav-landing.scrolled .nav-logo{height:38px}
.brand-divider{width:1px;height:32px;background:currentColor;opacity:.25;margin:0 12px}
.brand-egg{width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,var(--coklat-500),var(--coklat-400));display:none;align-items:center;justify-content:center;color:#ffe9c9;font-size:20px;box-shadow:0 4px 12px rgba(0,0,0,.25)}
.brand-egg i{display:inline-block;animation:wobble 2.6s ease-in-out infinite}
.brand-text{font-weight:800;font-size:20px;letter-spacing:.3px}
.nav-landing .brand-text,.nav-landing .navbar-brand{color:var(--teks-terang);text-shadow:0 2px 10px rgba(0,0,0,.45)}
.nav-landing .nav-links a{color:var(--teks-terang);text-decoration:none;font-size:14px;font-weight:600;margin-left:22px;text-shadow:0 1px 6px rgba(0,0,0,.4);transition:color .2s,transform .2s;display:inline-block}
.nav-landing .nav-links a:hover{color:#fff;transform:translateY(-1px)}
.nav-landing.scrolled{background:rgba(45,27,22,.85);backdrop-filter:blur(14px) saturate(140%);-webkit-backdrop-filter:blur(14px) saturate(140%);border-bottom:1px solid rgba(255,255,255,.08);padding:10px 0;box-shadow:0 8px 24px rgba(0,0,0,.18)}
.nav-landing.scrolled .brand-text{color:#fff;text-shadow:none;transform:scale(.97);transform-origin:left center;transition:transform .3s ease}
.nav-landing.scrolled .nav-links a{color:rgba(255,255,255,.9);text-shadow:none}
.nav-landing.scrolled .nav-links a:hover{color:#fff}
.nav-spacer{height:80px}
.btn-cta{background:var(--aksen);color:var(--coklat-900);font-weight:700;border:none;padding:8px 18px}
.btn-cta:hover{background:#c6935a;color:var(--coklat-900)}
.btn-ghost{border:1px solid rgba(255,255,255,.55);color:var(--teks-terang);padding:8px 18px;font-weight:600}
.btn-ghost:hover{background:rgba(255,255,255,.15);color:#fff}

.hero{
  background:linear-gradient(135deg,var(--coklat-900) 0%,var(--coklat-700) 60%,var(--coklat-500) 100%);
  color:#fff;overflow:hidden;position:relative;
  padding:100px 0 80px;
}
.hero::before{
  content:"";position:absolute;inset:0;
  background:radial-gradient(circle at 20% 30%,rgba(215,168,110,.15),transparent 40%),
             radial-gradient(circle at 80% 70%,rgba(215,168,110,.10),transparent 40%);
  pointer-events:none;
}
.hero-badge{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);color:#ffe9c9}
.stage{position:relative;min-height:440px}
.egg{position:absolute;background:linear-gradient(180deg,#fff8ee,#e8d5bd);border-radius:50% 50% 50% 50%/60% 60% 40% 40%;box-shadow:0 16px 28px rgba(0,0,0,.28)}
.egg.s1{width:64px;height:80px;left:6%;top:30px;animation:float 3.2s .3s ease-in-out infinite}
.egg.s2{width:46px;height:58px;right:8%;top:20px;animation:float 3.6s .8s ease-in-out infinite}
.egg.s3{width:54px;height:68px;right:18%;bottom:60px;animation:float 3s 1.2s ease-in-out infinite}
.chicken-wrap{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);width:320px;height:320px}
.chicken-wrap svg{width:100%;height:100%;overflow:visible}
.ch-body{transform-origin:50% 100%;animation:bodyBounce 1.4s ease-in-out infinite}
.ch-head{transform-origin:50% 100%;animation:headNod 2s ease-in-out infinite}
.ch-wing-left{transform-origin:90% 30%;animation:flapL .9s ease-in-out infinite}
.ch-wing-right{transform-origin:10% 30%;animation:flapR .9s ease-in-out infinite}
.ch-tail{transform-origin:50% 80%;animation:tailWag 1.8s ease-in-out infinite}
.ch-comb{transform-origin:50% 100%;animation:combWiggle 1.4s ease-in-out infinite}
.ch-eye{transform-origin:center;animation:blink 4s infinite}
.ch-beak{transform-origin:50% 30%;animation:beakTalk 2.4s ease-in-out infinite}
.ch-egg-drop{transform-origin:center;animation:eggDrop 3.5s ease-in infinite;opacity:0}
.grass{transform-origin:bottom center;animation:grassSway 3s ease-in-out infinite}

@keyframes bodyBounce{0%,100%{transform:translateY(0) rotate(-1deg)}50%{transform:translateY(-8px) rotate(1deg)}}
@keyframes headNod{0%,100%{transform:translateY(0) rotate(0)}25%{transform:translateY(-3px) rotate(-6deg)}75%{transform:translateY(-1px) rotate(5deg)}}
@keyframes flapL{0%,100%{transform:rotate(-5deg)}50%{transform:rotate(-35deg)}}
@keyframes flapR{0%,100%{transform:rotate(5deg)}50%{transform:rotate(35deg)}}
@keyframes tailWag{0%,100%{transform:rotate(-4deg)}50%{transform:rotate(6deg)}}
@keyframes combWiggle{0%,100%{transform:rotate(0)}50%{transform:rotate(3deg)}}
@keyframes blink{0%,92%,100%{transform:scaleY(1)}95%{transform:scaleY(0.1)}}
@keyframes beakTalk{0%,40%,100%{transform:rotate(0)}45%{transform:rotate(8deg)}55%{transform:rotate(-3deg)}65%{transform:rotate(5deg)}}
@keyframes eggDrop{0%{transform:translate(0,0) scale(.6);opacity:0}15%{transform:translate(0,0) scale(.9);opacity:1}70%{transform:translate(-20px,120px) scale(1);opacity:1}90%{transform:translate(-25px,150px) scale(1.05);opacity:.7}100%{transform:translate(-30px,170px) scale(.8);opacity:0}}
@keyframes grassSway{0%,100%{transform:skewX(-2deg)}50%{transform:skewX(3deg)}}
@keyframes float{0%,100%{transform:translateY(0) rotate(-2deg)}50%{transform:translateY(-16px) rotate(2deg)}}
@keyframes wobble{0%,100%{transform:rotate(0)}25%{transform:rotate(-10deg)}75%{transform:rotate(10deg)}}

/* ============================================================ */
/* ===== PEMBATAS ANIMASI PETERNAKAN (GARIS GELOMBANG HIDUP) ===== */
/* ============================================================ */
.farm-divider{
  position:relative;
  width:100%;
  height:260px;
  overflow:hidden;
  background:linear-gradient(180deg, var(--coklat-500) 0%, #a0764f 30%, #c9a27a 60%, var(--krem) 100%);
  margin-top:-2px;
}

/* Langit + awan */
.farm-sky{
  position:absolute; top:0; left:0; width:100%; height:60%;
  background:linear-gradient(180deg, #f4d9b0 0%, #f7e4c2 50%, #f7f2ea 100%);
}
.cloud{
  position:absolute;
  background:rgba(255,255,255,.85);
  border-radius:50%;
  filter:blur(1px);
  box-shadow:0 4px 20px rgba(255,255,255,.4);
}
.cloud.c1{width:90px;height:30px;top:30px;animation:cloudDrift 45s linear infinite}
.cloud.c2{width:120px;height:36px;top:55px;animation:cloudDrift 60s linear infinite;animation-delay:-20s}
.cloud.c3{width:70px;height:24px;top:20px;animation:cloudDrift 38s linear infinite;animation-delay:-10s}
.cloud::before,.cloud::after{
  content:"";position:absolute;background:inherit;border-radius:50%;
}
.cloud::before{width:60%;height:130%;top:-40%;left:15%}
.cloud::after{width:45%;height:110%;top:-25%;right:10%}
@keyframes cloudDrift{
  0%{transform:translateX(-150px)}
  100%{transform:translateX(calc(100vw + 150px))}
}

/* Matahari */
.sun{
  position:absolute;
  width:60px;height:60px;
  top:25px; right:12%;
  background:radial-gradient(circle, #ffd97a 0%, #ffb84d 60%, transparent 80%);
  border-radius:50%;
  box-shadow:0 0 60px 20px rgba(255,200,100,.4);
  animation:sunPulse 4s ease-in-out infinite;
}
@keyframes sunPulse{
  0%,100%{transform:scale(1);filter:brightness(1)}
  50%{transform:scale(1.08);filter:brightness(1.15)}
}

/* Bukit-bukit gelombang (layer parallax) */
.hill{
  position:absolute;
  bottom:0;
  left:0;
  width:200%;
  height:100%;
}
.hill svg{width:100%;height:100%;display:block}
.hill-back{animation:hillScroll 40s linear infinite;opacity:.6}
.hill-mid{animation:hillScroll 28s linear infinite;opacity:.85}
.hill-front{animation:hillScroll 18s linear infinite}
@keyframes hillScroll{
  0%{transform:translateX(0)}
  100%{transform:translateX(-50%)}
}

/* Pagar kayu kandang */
.fence{
  position:absolute;
  bottom:78px;
  left:0;
  width:200%;
  height:50px;
  animation:hillScroll 18s linear infinite;
  z-index:3;
}
.fence svg{width:100%;height:100%}

/* Rumput bergoyang di depan */
.grass-tuft{
  position:absolute;
  bottom:0;
  width:100%;
  height:80px;
  z-index:4;
  pointer-events:none;
}
.grass-tuft svg{width:100%;height:100%}
.blade{transform-origin:bottom center;animation:bladeWave 2.5s ease-in-out infinite}
.blade:nth-child(2n){animation-duration:3s;animation-delay:-.5s}
.blade:nth-child(3n){animation-duration:2.2s;animation-delay:-1s}
.blade:nth-child(5n){animation-duration:2.8s;animation-delay:-1.5s}
@keyframes bladeWave{
  0%,100%{transform:rotate(-4deg) scaleY(1)}
  50%{transform:rotate(6deg) scaleY(1.05)}
}

/* Ayam mini berjalan */
.walking-chicken{
  position:absolute;
  bottom:62px;
  width:44px; height:44px;
  z-index:5;
  animation:chickenWalk 22s linear infinite;
}
.walking-chicken svg{width:100%;height:100%;overflow:visible}
.walking-chicken .wc-body{animation:wcBob .5s ease-in-out infinite}
.walking-chicken .wc-leg-l,.walking-chicken .wc-leg-r{transform-origin:top center}
.walking-chicken .wc-leg-l{animation:wcLegL .5s ease-in-out infinite}
.walking-chicken .wc-leg-r{animation:wcLegR .5s ease-in-out infinite}
.walking-chicken .wc-head{animation:wcHead .6s ease-in-out infinite}
.walking-chicken .wc-wing{transform-origin:50% 20%;animation:wcWing .4s ease-in-out infinite}
@keyframes chickenWalk{
  0%{left:-60px;transform:scaleX(1)}
  49%{transform:scaleX(1)}
  50%{left:calc(100% + 10px);transform:scaleX(-1)}
  99%{transform:scaleX(-1)}
  100%{left:-60px;transform:scaleX(1)}
}
@keyframes wcBob{0%,100%{transform:translateY(0)}50%{transform:translateY(-2px)}}
@keyframes wcLegL{0%,100%{transform:rotate(-15deg)}50%{transform:rotate(20deg)}}
@keyframes wcLegR{0%,100%{transform:rotate(20deg)}50%{transform:rotate(-15deg)}}
@keyframes wcHead{0%,100%{transform:translateX(0)}50%{transform:translateX(2px)}}
@keyframes wcWing{0%,100%{transform:rotate(-5deg)}50%{transform:rotate(10deg)}}

/* Kandang kecil (coop) di kejauhan */
.coop{
  position:absolute;
  bottom:85px;
  width:70px;height:55px;
  z-index:2;
  animation:hillScroll 28s linear infinite;
}
.coop:nth-of-type(1){left:15%}
.coop:nth-of-type(2){left:55%;animation-delay:-14s}

.section-title{font-weight:800}
.about{background:var(--krem);position:relative;z-index:10}
.check-item i{color:var(--coklat-500)}
.feature-card{background:#fff;border:1px solid #e6dacc;border-radius:16px;padding:24px;height:100%;transition:.2s}
.feature-card:hover{transform:translateY(-4px);box-shadow:0 12px 26px rgba(93,64,55,.14)}
.feature-icon{width:48px;height:48px;border-radius:12px;background:var(--krem-2);color:var(--coklat-600);display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:14px}
footer{background:var(--coklat-900);color:#cbb5a8}

@media (max-width:991px){
  .chicken-wrap{width:240px;height:240px}
  .stage{min-height:340px}
  .nav-landing .nav-links{display:none}
  .brand-text{font-size:17px}
  .farm-divider{height:200px}
  .coop{display:none}
  .sun{width:45px;height:45px;top:18px}
}
@media (max-width:576px){
  .farm-divider{height:170px}
  .walking-chicken{width:34px;height:34px;bottom:50px}
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
         Aplikasi BukanAyam dikembangkan dengan dukungan PT Pesona Khatulistiwa Nusantara (PKN), perusahaan yang berkomitmen pada digitalisasi dan pemberdayaan masyarakat desa. Kehadiran PKN membantu peternak ayam di Desa Tanjung Agung beralih dari pencatatan manual ke sistem terintegrasi — populasi, produksi telur, penjualan, hingga pakan tercatat akurat dan dapat dipantau kapan saja.
        </p>
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

<!-- ================================================================= -->
<!-- ===== PEMBATAS ANIMASI PETERNAKAN (GARIS GELOMBANG HIDUP) ===== -->
<!-- ================================================================= -->
<div class="farm-divider" aria-hidden="true">

  <!-- Langit pagi -->
  <div class="farm-sky"></div>

  <!-- Awan bergerak -->
  <div class="cloud c1"></div>
  <div class="cloud c2"></div>
  <div class="cloud c3"></div>

  <!-- Matahari -->
  <div class="sun"></div>

  <!-- Bukit belakang (paling jauh, paling lambat) -->
  <div class="hill hill-back">
    <svg viewBox="0 0 2400 260" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0,180 Q150,120 300,160 T600,150 T900,170 T1200,150 T1500,170 T1800,150 T2100,170 T2400,160 L2400,260 L0,260 Z"
            fill="#8fae6f" opacity=".7"/>
    </svg>
  </div>

  <!-- Kandang kecil di kejauhan -->
  <div class="coop" style="left:18%">
    <svg viewBox="0 0 70 55" xmlns="http://www.w3.org/2000/svg">
      <rect x="5" y="25" width="60" height="28" fill="#8b5a3c"/>
      <polygon points="0,28 35,5 70,28" fill="#5d3a22"/>
      <rect x="28" y="35" width="14" height="18" fill="#3e2723"/>
      <rect x="10" y="32" width="8" height="8" fill="#ffd97a" opacity=".8"/>
      <rect x="52" y="32" width="8" height="8" fill="#ffd97a" opacity=".8"/>
    </svg>
  </div>
  <div class="coop" style="left:72%">
    <svg viewBox="0 0 70 55" xmlns="http://www.w3.org/2000/svg">
      <rect x="5" y="25" width="60" height="28" fill="#8b5a3c"/>
      <polygon points="0,28 35,5 70,28" fill="#5d3a22"/>
      <rect x="28" y="35" width="14" height="18" fill="#3e2723"/>
      <rect x="10" y="32" width="8" height="8" fill="#ffd97a" opacity=".8"/>
      <rect x="52" y="32" width="8" height="8" fill="#ffd97a" opacity=".8"/>
    </svg>
  </div>

  <!-- Bukit tengah -->
  <div class="hill hill-mid">
    <svg viewBox="0 0 2400 260" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0,200 Q200,140 400,180 T800,170 T1200,190 T1600,170 T2000,190 T2400,180 L2400,260 L0,260 Z"
            fill="#6fa05a"/>
    </svg>
  </div>

  <!-- Pagar kayu kandang (sejajar bukit depan) -->
  <div class="fence">
    <svg viewBox="0 0 2400 50" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <!-- 2 bilah horizontal -->
      <rect x="0" y="12" width="2400" height="4" fill="#6d4225"/>
      <rect x="0" y="30" width="2400" height="4" fill="#6d4225"/>
      <!-- Tiang vertikal berulang -->
      <g fill="#8b5a3c" stroke="#5d3a22" stroke-width=".5">
        <!-- generate 48 tiang (jarak 50) × 2 untuk looping -->
        <g>
          <rect x="20" y="2" width="8" height="46" rx="1"/>
          <rect x="70" y="2" width="8" height="46" rx="1"/>
          <rect x="120" y="2" width="8" height="46" rx="1"/>
          <rect x="170" y="2" width="8" height="46" rx="1"/>
          <rect x="220" y="2" width="8" height="46" rx="1"/>
          <rect x="270" y="2" width="8" height="46" rx="1"/>
          <rect x="320" y="2" width="8" height="46" rx="1"/>
          <rect x="370" y="2" width="8" height="46" rx="1"/>
          <rect x="420" y="2" width="8" height="46" rx="1"/>
          <rect x="470" y="2" width="8" height="46" rx="1"/>
          <rect x="520" y="2" width="8" height="46" rx="1"/>
          <rect x="570" y="2" width="8" height="46" rx="1"/>
          <rect x="620" y="2" width="8" height="46" rx="1"/>
          <rect x="670" y="2" width="8" height="46" rx="1"/>
          <rect x="720" y="2" width="8" height="46" rx="1"/>
          <rect x="770" y="2" width="8" height="46" rx="1"/>
          <rect x="820" y="2" width="8" height="46" rx="1"/>
          <rect x="870" y="2" width="8" height="46" rx="1"/>
          <rect x="920" y="2" width="8" height="46" rx="1"/>
          <rect x="970" y="2" width="8" height="46" rx="1"/>
          <rect x="1020" y="2" width="8" height="46" rx="1"/>
          <rect x="1070" y="2" width="8" height="46" rx="1"/>
          <rect x="1120" y="2" width="8" height="46" rx="1"/>
          <rect x="1170" y="2" width="8" height="46" rx="1"/>
        </g>
        <g transform="translate(1200,0)">
          <rect x="20" y="2" width="8" height="46" rx="1"/>
          <rect x="70" y="2" width="8" height="46" rx="1"/>
          <rect x="120" y="2" width="8" height="46" rx="1"/>
          <rect x="170" y="2" width="8" height="46" rx="1"/>
          <rect x="220" y="2" width="8" height="46" rx="1"/>
          <rect x="270" y="2" width="8" height="46" rx="1"/>
          <rect x="320" y="2" width="8" height="46" rx="1"/>
          <rect x="370" y="2" width="8" height="46" rx="1"/>
          <rect x="420" y="2" width="8" height="46" rx="1"/>
          <rect x="470" y="2" width="8" height="46" rx="1"/>
          <rect x="520" y="2" width="8" height="46" rx="1"/>
          <rect x="570" y="2" width="8" height="46" rx="1"/>
          <rect x="620" y="2" width="8" height="46" rx="1"/>
          <rect x="670" y="2" width="8" height="46" rx="1"/>
          <rect x="720" y="2" width="8" height="46" rx="1"/>
          <rect x="770" y="2" width="8" height="46" rx="1"/>
          <rect x="820" y="2" width="8" height="46" rx="1"/>
          <rect x="870" y="2" width="8" height="46" rx="1"/>
          <rect x="920" y="2" width="8" height="46" rx="1"/>
          <rect x="970" y="2" width="8" height="46" rx="1"/>
          <rect x="1020" y="2" width="8" height="46" rx="1"/>
          <rect x="1070" y="2" width="8" height="46" rx="1"/>
          <rect x="1120" y="2" width="8" height="46" rx="1"/>
          <rect x="1170" y="2" width="8" height="46" rx="1"/>
        </g>
      </g>
    </svg>
  </div>

  <!-- Bukit depan (paling dekat, paling cepat) -->
  <div class="hill hill-front">
    <svg viewBox="0 0 2400 260" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0,220 Q180,170 360,200 T720,195 T1080,210 T1440,195 T1800,210 T2160,195 T2400,205 L2400,260 L0,260 Z"
            fill="var(--rumput-2)"/>
    </svg>
  </div>

  <!-- Ayam mini berjalan -->
  <div class="walking-chicken">
    <svg viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
      <g class="wc-body">
        <!-- ekor -->
        <path d="M8 22 Q2 18 4 12 Q8 16 10 20 Z" fill="#5d4037"/>
        <!-- badan -->
        <ellipse cx="22" cy="25" rx="14" ry="10" fill="#d7b58f"/>
        <ellipse cx="22" cy="27" rx="12" ry="8" fill="#e8cfa8"/>
        <!-- sayap -->
        <g class="wc-wing">
          <path d="M18 22 Q14 26 16 30 Q22 28 24 24 Z" fill="#a0764f"/>
        </g>
        <!-- kepala -->
        <g class="wc-head">
          <circle cx="34" cy="18" r="7" fill="#e8cfa8"/>
          <!-- jengger -->
          <path d="M32 12 Q34 8 36 12 Q37 10 38 13 Q36 14 33 13 Z" fill="#d93636"/>
          <!-- mata -->
          <circle cx="36" cy="17" r="1.3" fill="#2d1b16"/>
          <!-- paruh -->
          <path d="M40 19 L44 20 L40 21 Z" fill="#f4b400"/>
          <!-- pial -->
          <path d="M35 22 Q36 24 37 22 Z" fill="#d93636"/>
        </g>
        <!-- kaki -->
        <g class="wc-leg-l">
          <line x1="18" y1="34" x2="16" y2="44" stroke="#f4b400" stroke-width="2" stroke-linecap="round"/>
          <path d="M13 44 L16 44 L19 44" stroke="#f4b400" stroke-width="1.5" stroke-linecap="round" fill="none"/>
        </g>
        <g class="wc-leg-r">
          <line x1="26" y1="34" x2="28" y2="44" stroke="#f4b400" stroke-width="2" stroke-linecap="round"/>
          <path d="M25 44 L28 44 L31 44" stroke="#f4b400" stroke-width="1.5" stroke-linecap="round" fill="none"/>
        </g>
      </g>
    </svg>
  </div>

  <!-- Rumput depan bergoyang -->
  <div class="grass-tuft">
    <svg viewBox="0 0 1200 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <!-- base tanah -->
      <rect x="0" y="40" width="1200" height="40" fill="var(--rumput-2)"/>
      <!-- bilah rumput -->
      <g stroke-linecap="round" fill="none" stroke-width="2">
        <path class="blade" d="M10 50 Q12 30 8 10" stroke="var(--rumput-1)"/>
        <path class="blade" d="M25 50 Q28 28 30 12" stroke="var(--rumput-3)"/>
        <path class="blade" d="M45 50 Q42 32 46 8" stroke="var(--rumput-1)"/>
        <path class="blade" d="M65 50 Q68 30 62 14" stroke="var(--rumput-2)"/>
        <path class="blade" d="M85 50 Q82 28 88 10" stroke="var(--rumput-3)"/>
        <path class="blade" d="M105 50 Q108 32 102 12" stroke="var(--rumput-1)"/>
        <path class="blade" d="M125 50 Q122 30 128 8" stroke="var(--rumput-2)"/>
        <path class="blade" d="M145 50 Q148 28 142 14" stroke="var(--rumput-3)"/>
        <path class="blade" d="M165 50 Q162 32 168 10" stroke="var(--rumput-1)"/>
        <path class="blade" d="M185 50 Q188 30 182 12" stroke="var(--rumput-2)"/>
        <path class="blade" d="M205 50 Q202 28 208 8" stroke="var(--rumput-3)"/>
        <path class="blade" d="M225 50 Q228 32 222 14" stroke="var(--rumput-1)"/>
        <path class="blade" d="M245 50 Q242 30 248 10" stroke="var(--rumput-2)"/>
        <path class="blade" d="M265 50 Q268 28 262 12" stroke="var(--rumput-3)"/>
        <path class="blade" d="M285 50 Q282 32 288 8" stroke="var(--rumput-1)"/>
        <path class="blade" d="M305 50 Q308 30 302 14" stroke="var(--rumput-2)"/>
        <path class="blade" d="M325 50 Q322 28 328 10" stroke="var(--rumput-3)"/>
        <path class="blade" d="M345 50 Q348 32 342 12" stroke="var(--rumput-1)"/>
        <path class="blade" d="M365 50 Q362 30 368 8" stroke="var(--rumput-2)"/>
        <path class="blade" d="M385 50 Q388 28 382 14" stroke="var(--rumput-3)"/>
        <path class="blade" d="M405 50 Q402 32 408 10" stroke="var(--rumput-1)"/>
        <path class="blade" d="M425 50 Q428 30 422 12" stroke="var(--rumput-2)"/>
        <path class="blade" d="M445 50 Q442 28 448 8" stroke="var(--rumput-3)"/>
        <path class="blade" d="M465 50 Q468 32 462 14" stroke="var(--rumput-1)"/>
        <path class="blade" d="M485 50 Q482 30 488 10" stroke="var(--rumput-2)"/>
        <path class="blade" d="M505 50 Q508 28 502 12" stroke="var(--rumput-3)"/>
        <path class="blade" d="M525 50 Q522 32 528 8" stroke="var(--rumput-1)"/>
        <path class="blade" d="M545 50 Q548 30 542 14" stroke="var(--rumput-2)"/>
        <path class="blade" d="M565 50 Q562 28 568 10" stroke="var(--rumput-3)"/>
        <path class="blade" d="M585 50 Q588 32 582 12" stroke="var(--rumput-1)"/>
        <path class="blade" d="M605 50 Q602 30 608 8" stroke="var(--rumput-2)"/>
        <path class="blade" d="M625 50 Q628 28 622 14" stroke="var(--rumput-3)"/>
        <path class="blade" d="M645 50 Q642 32 648 10" stroke="var(--rumput-1)"/>
        <path class="blade" d="M665 50 Q668 30 662 12" stroke="var(--rumput-2)"/>
        <path class="blade" d="M685 50 Q682 28 688 8" stroke="var(--rumput-3)"/>
        <path class="blade" d="M705 50 Q708 32 702 14" stroke="var(--rumput-1)"/>
        <path class="blade" d="M725 50 Q722 30 728 10" stroke="var(--rumput-2)"/>
        <path class="blade" d="M745 50 Q748 28 742 12" stroke="var(--rumput-3)"/>
        <path class="blade" d="M765 50 Q762 32 768 8" stroke="var(--rumput-1)"/>
        <path class="blade" d="M785 50 Q788 30 782 14" stroke="var(--rumput-2)"/>
        <path class="blade" d="M805 50 Q802 28 808 10" stroke="var(--rumput-3)"/>
        <path class="blade" d="M825 50 Q828 32 822 12" stroke="var(--rumput-1)"/>
        <path class="blade" d="M845 50 Q842 30 848 8" stroke="var(--rumput-2)"/>
        <path class="blade" d="M865 50 Q868 28 862 14" stroke="var(--rumput-3)"/>
        <path class="blade" d="M885 50 Q882 32 888 10" stroke="var(--rumput-1)"/>
        <path class="blade" d="M905 50 Q908 30 902 12" stroke="var(--rumput-2)"/>
        <path class="blade" d="M925 50 Q922 28 928 8" stroke="var(--rumput-3)"/>
        <path class="blade" d="M945 50 Q948 32 942 14" stroke="var(--rumput-1)"/>
        <path class="blade" d="M965 50 Q962 30 968 10" stroke="var(--rumput-2)"/>
        <path class="blade" d="M985 50 Q988 28 982 12" stroke="var(--rumput-3)"/>
        <path class="blade" d="M1005 50 Q1002 32 1008 8" stroke="var(--rumput-1)"/>
        <path class="blade" d="M1025 50 Q1028 30 1022 14" stroke="var(--rumput-2)"/>
        <path class="blade" d="M1045 50 Q1042 28 1048 10" stroke="var(--rumput-3)"/>
        <path class="blade" d="M1065 50 Q1068 32 1062 12" stroke="var(--rumput-1)"/>
        <path class="blade" d="M1085 50 Q1082 30 1088 8" stroke="var(--rumput-2)"/>
        <path class="blade" d="M1105 50 Q1108 28 1102 14" stroke="var(--rumput-3)"/>
        <path class="blade" d="M1125 50 Q1122 32 1128 10" stroke="var(--rumput-1)"/>
        <path class="blade" d="M1145 50 Q1148 30 1142 12" stroke="var(--rumput-2)"/>
        <path class="blade" d="M1165 50 Q1162 28 1168 8" stroke="var(--rumput-3)"/>
        <path class="blade" d="M1185 50 Q1188 32 1182 14" stroke="var(--rumput-1)"/>
      </g>
    </svg>
  </div>
</div>

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

{{-- ===== ANIMASI KURSOR AYAM (dari file partial) ===== --}}
@include('partials.cursor-animation')
</body>
</html>
