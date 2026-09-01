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
  --blue: #2196f3;      /* ganti ke #6d4c41 kalau mau warna coklat brand */
  --blue-dark: #1976d2;
}
* { box-sizing: border-box; }
html, body { height: 100%; }
body {
  margin: 0;
  font-family: 'Inter', sans-serif;
  background: linear-gradient(120deg, #fdeccb 0%, #ece5d8 30%, #dbe3ee 65%, #cbd6e6 100%);
  background-attachment: fixed;
  display: flex; align-items: center; justify-content: center;
}
.login-wrap { width: 100%; max-width: 430px; padding: 28px; text-align: center; }

/* Ikon orang besar di atas */
.login-icon { color: var(--blue); font-size: 105px; line-height: 1; margin-bottom: 30px; }

/* Input bentuk pil dengan ikon + garis pemisah */
.field {
  display: flex; align-items: center;
  background: #fff; border-radius: 999px;
  height: 52px; padding: 0 20px; margin-bottom: 16px;
  box-shadow: 0 4px 14px rgba(70, 90, 120, .08);
  transition: box-shadow .2s;
}
.field:focus-within { box-shadow: 0 0 0 3px rgba(33, 150, 243, .18); }
.field .f-icon { color: #8a8f98; font-size: 17px; flex-shrink: 0; }
.field .divider { width: 1px; height: 26px; background: #d9dce1; margin: 0 13px; flex-shrink: 0; }
.field input {
  border: 0; outline: 0; background: transparent; width: 100%;
  font-family: 'Inter', sans-serif; font-size: 13px; color: #333;
}
.field input::placeholder {
  color: #9aa0a8; font-size: 12px; font-weight: 500; letter-spacing: 1.5px;
}

/* Remember me + forgot password */
.opts {
  display: flex; justify-content: space-between; align-items: center;
  margin: 2px 8px 24px; font-size: 12.5px;
}
.remember { display: flex; align-items: center; gap: 7px; color: #5c6570; cursor: pointer; }
.remember input { accent-color: var(--blue); width: 15px; height: 15px; cursor: pointer; }
.forgot { color: var(--blue); text-decoration: none; font-weight: 500; }
.forgot:hover { text-decoration: underline; }

/* Tombol LOGIN pil biru */
.btn-login {
  background: var(--blue); color: #fff; border: 0; border-radius: 999px;
  height: 50px; padding: 0 60px;
  font-family: 'Inter', sans-serif; font-size: 15px; font-weight: 600; letter-spacing: 2px;
  cursor: pointer; transition: .2s;
  box-shadow: 0 6px 18px rgba(33, 150, 243, .35);
}
.btn-login:hover { background: var(--blue-dark); }
.btn-login:active { transform: scale(.98); }

/* Pesan error / status */
.alert-box {
  background: #fff; border-radius: 14px; padding: 10px 16px; margin-bottom: 16px;
  font-size: 12.5px; text-align: left; color: #c0392b;
  box-shadow: 0 4px 14px rgba(70, 90, 120, .08);
}
.alert-box.info { color: var(--blue-dark); }

.home-link {
  display: inline-block; margin-top: 24px;
  font-size: 12px; color: #7d8794; text-decoration: none;
}
.home-link:hover { text-decoration: underline; }
</style>
</head>
<body>

<div class="login-wrap">
    <div class="login-icon"><i class="bi bi-people-fill"></i></div>

    {{-- Pesan status (mis. link reset password terkirim) --}}
    @if (session('status'))
        <div class="alert-box info"><i class="bi bi-info-circle me-1"></i>{{ session('status') }}</div>
    @endif

    {{-- Pesan error login --}}
    @error('email')
        <div class="alert-box"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
    @enderror
    @error('password')
        <div class="alert-box"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
            <i class="bi bi-person-fill f-icon"></i>
            <span class="divider"></span>
            <input type="email" name="email" value="{{ old('email') }}"
                   placeholder="USERNAME / EMAIL" required autofocus autocomplete="username">
        </div>

        <div class="field">
            <i class="bi bi-lock-fill f-icon"></i>
            <span class="divider"></span>
            <input type="password" name="password" placeholder="PASSWORD"
                   required autocomplete="current-password">
        </div>

        <div class="opts">
            <label class="remember">
                <input type="checkbox" name="remember"> Remember me
            </label>
            <a class="forgot" href="{{ route('password.request') }}">Forgot password?</a>
        </div>

        <button type="submit" class="btn-login">LOGIN</button>
    </form>

    <a class="home-link" href="{{ url('/') }}">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke beranda
    </a>
</div>

@include('partials.cursor-animation')
</body>
</html>
