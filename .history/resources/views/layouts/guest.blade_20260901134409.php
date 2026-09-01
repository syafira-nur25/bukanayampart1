<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BukanAyam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f7f2ea; }
        .btn-success { background: #6d4c41; border-color: #6d4c41; }
        .btn-success:hover { background: #5d4037; border-color: #5d4037; }
        .egg-wobble i { display: inline-block; animation: wobble 2.6s ease-in-out infinite; }
        @keyframes wobble { 0%,100% { transform: rotate(0); } 25% { transform: rotate(-10deg); } 75% { transform: rotate(10deg); } }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100">
    <div class="container" style="max-width: 420px;">
        {{ $slot }}
        <a href="{{ url('/') }}" class="d-block text-center mt-3 small text-muted text-decoration-none">
            ← Kembali ke beranda
        </a>
    </div>
</body>
</html>
