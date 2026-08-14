<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Peternakan')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="{{ url('/') }}">
            Peternakan
        </a>

        <div class="navbar-nav">

            <a class="nav-link" href="{{ route('kandang.index') }}">
                Kandang
            </a>

            <a class="nav-link" href="{{ route('populasi.index') }}">
                Populasi
            </a>

            <a class="nav-link" href="{{ route('produksi-telur.index') }}">
                Produksi Telur
            </a>

            <a class="nav-link" href="{{ route('penjualan-telur.index') }}">
                Penjualan
            </a>

            <a class="nav-link" href="{{ route('pakan-kandang.index') }}">
                Pakan
            </a>

            <a class="nav-link" href="{{ route('pemberian-pakan.index') }}">
                Pemberian Pakan
            </a>

        </div>
    </div>
</nav>

<main class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')

</main>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>
