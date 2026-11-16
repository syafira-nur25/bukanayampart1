<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FARM2025 — Sistem Manajemen Peternakan Ayam | Desa Tanjung Agung</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
:root {
    --primary: #1e3a5f;
    --primary-dark: #152a45;
    --primary-light: #2c5282;
    --accent: #3b82f6;
    --accent-light: #60a5fa;
    --background: #f0f4f8;
    --text: #1a202c;
    --muted: #718096;
    --border: #e2e8f0;
    --success: #10b981;
    --warning: #f59e0b;
}
html { scroll-behavior: smooth; }
body {
    font-family: 'Inter', sans-serif;
    background: var(--background);
    color: var(--text);
    margin: 0;
}

/* NAVBAR */
.nav-landing {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1030;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--border);
    padding: 16px 0;
    transition: all 0.3s ease;
}
.nav-landing .container { padding: 0 24px; }
.nav-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
}
.nav-brand-icon {
    width: 42px;
    height: 42px;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}
.nav-brand-text {
    font-size: 18px;
    font-weight: 800;
    color: var(--primary);
}
.nav-landing .nav-links a {
    color: var(--text);
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    margin-left: 24px;
    transition: color 0.2s;
}
.nav-landing .nav-links a:hover { color: var(--accent); }
.btn-nav {
    background: linear-gradient(135deg, var(--accent), var(--primary-light));
    color: white;
    font-weight: 700;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 13px;
    text-decoration: none;
    transition: 0.2s;
}
.btn-nav:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    color: white;
}

/* HERO */
.hero {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    color: white;
    overflow: hidden;
    position: relative;
    padding: 140px 0 80px;
}
.hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 600px;
    height: 600px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}
.hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -5%;
    width: 400px;
    height: 400px;
    background: rgba(255,255,255,0.03);
    border-radius: 50%;
}
.hero-badge {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    padding: 8px 16px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 24px;
}
.hero h1 {
    font-size: 48px;
    font-weight: 900;
    line-height: 1.1;
    margin-bottom: 20px;
    position: relative;
    z-index: 1;
}
.hero h1 span { color: var(--accent-light); }
.hero p {
    font-size: 16px;
    opacity: 0.9;
    line-height: 1.6;
    position: relative;
    z-index: 1;
}
.hero-visual {
    position: relative;
    z-index: 1;
    text-align: center;
}
.hero-icon {
    font-size: 200px;
    opacity: 0.2;
    animation: float 3s ease-in-out infinite;
}
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

/* FEATURES */
.features { padding: 80px 0; }
.section-title {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 12px;
}
.section-subtitle {
    font-size: 15px;
    color: var(--muted);
    margin-bottom: 48px;
}
.feature-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 32px;
    height: 100%;
    transition: 0.3s;
}
.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(30, 58, 95, 0.1);
    border-color: var(--accent-light);
}
.feature-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 20px;
}
.feature-icon.blue { background: rgba(59, 130, 246, 0.12); color: var(--accent); }
.feature-icon.green { background: rgba(16, 185, 129, 0.12); color: var(--success); }
.feature-icon.yellow { background: rgba(245, 158, 11, 0.12); color: var(--warning); }
.feature-icon.purple { background: rgba(139, 92, 246, 0.12); color: #8b5cf6; }
.feature-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 10px;
}
.feature-desc {
    font-size: 14px;
    color: var(--muted);
    line-height: 1.6;
}

/* ABOUT */
.about {
    background: white;
    padding: 80px 0;
}
.about-card {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    border-radius: 24px;
    padding: 48px;
    color: white;
    position: relative;
    overflow: hidden;
}
.about-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
}
.check-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    font-size: 14px;
}
.check-item i {
    color: var(--accent-light);
    font-size: 20px;
}

/* FOOTER */
footer {
    background: var(--primary-dark);
    color: rgba(255,255,255,0.7);
    padding: 32px 0;
    font-size: 13px;
}
footer a { color: var(--accent-light); text-decoration: none; }

@media (max-width: 991px) {
    .hero h1 { font-size: 36px; }
    .hero { padding: 120px 0 60px; }
    .nav-landing .nav-links { display: none; }
    .section-title { font-size: 26px; }
}
</style>
</head>
<body>
<nav class="nav-landing">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="{{ url('/') }}" class="nav-brand">
            <div class="nav-brand-icon"><i class="bi bi-egg-fried"></i></div>
            <div class="nav-brand-text">FARM2025</div>
        </a>
        <div class="nav-links d-none d-md-block">
            <a href="#fitur">Fitur</a>
            <a href="#tentang">Tentang</a>
        </div>
        <div>
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? route('dashboard') : route('manpower.laporan.create') }}" class="btn-nav">
                    Buka Dashboard <i class="bi bi-arrow-right ms-1"></i>
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-nav">
                    Masuk <i class="bi bi-box-arrow-in-right ms-1"></i>
                </a>
            @endauth
        </div>
    </div>
</nav>

<header class="hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="hero-badge">
                    <i class="bi bi-geo-alt-fill"></i> Desa Tanjung Agung
                </div>
                <h1>Kelola Peternakan Ayam Jadi <span>Lebih Mudah</span></h1>
                <p>
                    Aplikasi ini dikembangkan dengan dukungan PT Pesona Khatulistiwa Nusantara (PKN),
                    perusahaan yang berkomitmen pada digitalisasi dan pemberdayaan masyarakat desa.
                    Kehadiran PKN membantu peternak ayam di Desa Tanjung Agung beralih dari pencatatan
                    manual ke sistem terintegrasi.
                </p>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div class="hero-visual">
                    <i class="bi bi-egg-fried hero-icon"></i>
                </div>
            </div>
        </div>
    </div>
</header>

<section id="fitur" class="features">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-title">Fitur Unggulan</div>
            <div class="section-subtitle">Semua yang Anda butuhkan untuk mengelola peternakan dalam satu platform</div>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon blue"><i class="bi bi-house-door-fill"></i></div>
                    <div class="feature-title">Manajemen Kandang</div>
                    <div class="feature-desc">Kelola data kandang, lokasi, dan kapasitas dengan mudah</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon green"><i class="bi bi-people-fill"></i></div>
                    <div class="feature-title">Populasi Ayam</div>
                    <div class="feature-desc">Pantau populasi, kematian, dan afkir secara real-time</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon yellow"><i class="bi bi-egg-fill"></i></div>
                    <div class="feature-title">Produksi Telur</div>
                    <div class="feature-desc">Catat dan analisis produksi telur harian per kandang</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon purple"><i class="bi bi-cash-stack"></i></div>
                    <div class="feature-title">Keuangan</div>
                    <div class="feature-desc">Kelola penjualan, arus kas, dan laporan keuangan</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="tentang" class="about">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="about-card">
                    <h2 class="section-title" style="color: white;">Tentang Aplikasi</h2>
                    <p style="opacity: 0.9; margin-bottom: 24px;">
                        Aplikasi ini dibangun untuk membantu peternakan ayam di
                        <strong>Desa Tanjung Agung</strong> mencatat dan mengelola data peternakan
                        secara digital.
                    </p>
                    <div class="check-item"><i class="bi bi-check-circle-fill"></i>Pencatatan lapangan langsung oleh man power</div>
                    <div class="check-item"><i class="bi bi-check-circle-fill"></i>Perhitungan populasi & sisa pakan otomatis</div>
                    <div class="check-item"><i class="bi bi-check-circle-fill"></i>Laporan produksi dan pakan yang terintegrasi</div>
                    <div class="check-item"><i class="bi bi-check-circle-fill"></i>Dashboard terpisah untuk admin dan man power</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="feature-card text-center p-5">
                    <div class="feature-icon blue mx-auto" style="width: 80px; height: 80px; font-size: 36px;">
                        <i class="bi bi-egg-fried"></i>
                    </div>
                    <h3 class="mt-3 mb-2">FARM2025</h3>
                    <p class="text-muted mb-4">Sistem Manajemen Peternakan Ayam</p>
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <span class="badge" style="background: var(--background); color: var(--primary); padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                            <i class="bi bi-geo-alt me-1"></i>Desa Tanjung Agung
                        </span>
                        <span class="badge" style="background: var(--background); color: var(--primary); padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                            <i class="bi bi-calendar3 me-1"></i>{{ date('Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container d-flex flex-wrap justify-content-between gap-2">
        <span><i class="bi bi-egg-fried me-1"></i> FARM2025 — Desa Tanjung Agung</span>
        <span>© {{ date('Y') }} Sistem Manajemen Peternakan Ayam. Didukung oleh <a href="#">PT PKN</a></span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
