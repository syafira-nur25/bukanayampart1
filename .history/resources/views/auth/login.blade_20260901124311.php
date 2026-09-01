<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — BukanAyam</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
  --primary: #6d4c41;
  --primary-dark: #5d4037;
  --krem: #f7f2ea;
  --krem-2: #efe6d9;
  --aksen: #d7a86e;
  --text: #33261f;
  --muted: #8a7a6e;
  --border: #e6dacc;
}
* { box-sizing: border-box; }
body {
  margin: 0;
  font-family: 'Inter', sans-serif;
  min-height: 100vh;
  display: flex; align-items: center; justify-content: center;
  background: linear-gradient(135deg, #fdf9f0 0%, var(--krem) 45%, var(--krem-2) 75%, #e8d5bd 100%);
  color: var(--text);
}
.login-wrap { width: 100%; max-width: 430px; padding: 24px; text-align: center; }

/* ===== IKON ===== */
.login-icon {
  color: var(--primary);
  font-size: 108px; line-height: 1; margin-bottom: 30px;
  filter: drop-shadow(0 6px 14px rgba(93,64,55,.25));
}

/* ===== ALERT ===== */
.err-box {
  background: #fff; border: 1px solid #f8d7da; color: #842029;
  border-radius: 12px; padding: 10px 14px; font-size: 12.5px;
  margin-bottom: 14px; text-align: left;
}
.err-box.info { border-color: var(--border); color: var(--primary-dark); }

/* ===== INPUT PIL ===== */
.field {
  display: flex; align-items: center;
  background: #fff; border: 1px solid var(--border); border-radius: 999px;
  height: 52px; padding: 0 20px; margin-bottom: 16px;
  box-shadow: 0 4px 14px rgba(93,64,55,.08);
  transition: .2s;
}
.field:focus-within { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(109,76,65,.15); }
.f-icon { color: var(--muted); font-size: 17px; flex-shrink: 0; }
.divider { width: 1px; height: 26px; background: var(--border); margin: 0 14px; flex-shrink: 0; }
.field input {
  border: 0; outline: 0; background: transparent; width: 100%;
  font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500;
  letter-spacing: 1.5px; color: var(--text);
}
.field input::placeholder { color: #b3a294; }

/* ===== OPSI ===== */
.opts { display: flex; justify-content: space-between; align-items: center; margin: 2px 8px 24px; font-size: 12.5px; }
.remember { display: flex; align-items: center; gap: 7px; color: var(--muted); cursor: pointer; }
.remember input { accent-color: var(--primary); width: 15px; height: 15px; cursor: pointer; }
.forgot { color: var(--primary); text-decoration: none; font-weight: 600; }
.forgot:hover { color: var(--primary-dark); text-decoration: underline; }

/* ===== TOMBOL LOGIN ===== */
.btn-login {
  background: var(--primary); color: #fff; border: 0; border-radius: 999px;
  height: 50px; padding: 0 64px;
  font-family: 'Inter', sans-serif; font-size: 15px; font-weight: 700; letter-spacing: 2px;
  cursor: pointer; box-shadow: 0 6px 18px rgba(93,64,55,.35);
  transition: .2s;
}
.btn-login:hover { background: var(--primary-dark); transform: translateY(-1px); }
.btn-login:active { transform: translateY(0); }

.home-link { display: inline-block; margin-top: 26px; font-size: 12px; color: var(--muted); text-decoration: none; }
.home-link:hover { color: var(--primary-dark); text-decoration: underline; }
</style>
</head>
<body>
<div class="login-wrap">
    <div class="login-icon"><i class="bi bi-people-fill"></i></div>

    @if (session('status'))
        <div class="err-box info"><i class="bi bi-info-circle me-1"></i>{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="err-box"><i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="field">
            <i class="bi bi-person-fill f-icon"></i>
            <span class="divider"></span>
            <input type="email" name="email" placeholder="EMAIL"
                   value="{{ old('email') }}" required autofocus autocomplete="username">
        </div>
        <div class="field">
            <i class="bi bi-lock-fill f-icon"></i>
            <span class="divider"></span>
            <input type="password" name="password" placeholder="PASSWORD"
                   required autocomplete="current-password">
        </div>
        <div class="opts">
            <label class="remember"><input type="checkbox" name="remember"> Ingat saya</label>
            <a class="forgot" href="{{ route('password.request') }}">Lupa password?</a>
        </div>
        <button type="submit" class="btn-login">LOGIN</button>
    </form>

    <a class="home-link" href="{{ url('/') }}"><i class="bi bi-arrow-left me-1"></i>Kembali ke beranda</a>
</div>
@include('partials.cursor-animation')
</body>
</html>
