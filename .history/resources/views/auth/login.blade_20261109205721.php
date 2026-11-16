<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — FARM2025</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
    --primary: #1e3a5f;
    --primary-dark: #152a45;
    --primary-light: #2c5282;
    --accent: #3b82f6;
    --background: #f0f4f8;
    --text: #1a202c;
    --muted: #718096;
    --border: #e2e8f0;
}
* { box-sizing: border-box; }
body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--background) 0%, #e2e8f0 100%);
    color: var(--text);
    padding: 20px;
}
.login-container {
    display: flex;
    max-width: 900px;
    width: 100%;
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(30, 58, 95, 0.15);
}
.login-left {
    flex: 1;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    color: white;
    padding: 48px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    overflow: hidden;
}
.login-left::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 400px;
    height: 400px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
}
.login-left::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}
.login-brand {
    position: relative;
    z-index: 1;
    margin-bottom: 32px;
}
.login-brand-icon {
    width: 56px;
    height: 56px;
    background: rgba(255,255,255,0.15);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin-bottom: 16px;
}
.login-brand-title {
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 4px;
}
.login-brand-sub {
    font-size: 12px;
    opacity: 0.8;
}
.login-features {
    position: relative;
    z-index: 1;
}
.login-feature {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    font-size: 13px;
}
.login-feature-icon {
    width: 32px;
    height: 32px;
    background: rgba(255,255,255,0.15);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.login-right {
    flex: 1;
    padding: 48px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.login-title {
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 8px;
    color: var(--text);
}
.login-subtitle {
    font-size: 13px;
    color: var(--muted);
    margin-bottom: 32px;
}
.form-group {
    margin-bottom: 20px;
}
.form-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--border);
    border-radius: 10px;
    font-size: 14px;
    font-family: 'Inter', sans-serif;
    transition: 0.2s;
    background: var(--background);
}
.form-input:focus {
    outline: none;
    border-color: var(--accent);
    background: white;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    font-size: 12px;
}
.form-check {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--muted);
    cursor: pointer;
}
.form-check input {
    accent-color: var(--accent);
}
.form-link {
    color: var(--accent);
    text-decoration: none;
    font-weight: 600;
}
.form-link:hover {
    color: var(--primary);
    text-decoration: underline;
}
.btn-login {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, var(--accent), var(--primary-light));
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    transition: 0.2s;
    letter-spacing: 0.5px;
}
.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
}
.alert-box {
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 20px;
}
.alert-error {
    background: rgba(239, 68, 68, 0.1);
    color: #991b1b;
    border-left: 4px solid #ef4444;
}
.alert-info {
    background: rgba(59, 130, 246, 0.1);
    color: #1e40af;
    border-left: 4px solid #3b82f6;
}
.home-link {
    display: block;
    text-align: center;
    margin-top: 24px;
    font-size: 12px;
    color: var(--muted);
    text-decoration: none;
}
.home-link:hover {
    color: var(--primary);
}
@media (max-width: 768px) {
    .login-left { display: none; }
    .login-right { padding: 32px 24px; }
}
</style>
</head>
<body>
<div class="login-container">
    <div class="login-left">
        <div class="login-brand">
            <div class="login-brand-icon"><i class="bi bi-egg-fried"></i></div>
            <div class="login-brand-title">FARM2025</div>
            <div class="login-brand-sub">Sistem Manajemen Peternakan Ayam</div>
        </div>
        <div class="login-features">
            <div class="login-feature">
                <div class="login-feature-icon"><i class="bi bi-house-door-fill"></i></div>
                <div>Kelola kandang & populasi ayam</div>
            </div>
            <div class="login-feature">
                <div class="login-feature-icon"><i class="bi bi-egg-fill"></i></div>
                <div>Pantau produksi telur harian</div>
            </div>
            <div class="login-feature">
                <div class="login-feature-icon"><i class="bi bi-cash-stack"></i></div>
                <div>Kelola penjualan & keuangan</div>
            </div>
            <div class="login-feature">
                <div class="login-feature-icon"><i class="bi bi-bar-chart-fill"></i></div>
                <div>Laporan & analisis terintegrasi</div>
            </div>
        </div>
    </div>
    <div class="login-right">
        <div>
            <div class="login-title">Selamat Datang</div>
            <div class="login-subtitle">Masuk ke akun Anda untuk melanjutkan</div>

            @if (session('status'))
                <div class="alert-box alert-info">
                    <i class="bi bi-info-circle me-1"></i>{{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert-box alert-error">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input"
                        value="{{ old('email') }}" required autofocus autocomplete="username"
                        placeholder="nama@email.com">
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input"
                        required autocomplete="current-password"
                        placeholder="••••••••">
                </div>
                <div class="form-options">
                    <label class="form-check">
                        <input type="checkbox" name="remember"> Ingat saya
                    </label>
                    <a class="form-link" href="{{ route('password.request') }}">Lupa password?</a>
                </div>
                <button type="submit" class="btn-login">MASUK</button>
            </form>
            <a class="home-link" href="{{ url('/') }}">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke beranda
            </a>
        </div>
    </div>
</div>
</body>
</html> 
