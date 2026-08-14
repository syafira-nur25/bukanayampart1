<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Farm Management')
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>

        :root {
            --primary: #198754;
            --primary-dark: #146c43;
            --sidebar: #12372a;
            --sidebar-hover: #1c4d3b;
            --background: #f5f7f6;
            --card: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #e5e7eb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--background);
            color: var(--text);
        }

        /* SIDEBAR */

        .sidebar {
            width: 260px;
            height: 100vh;

            position: fixed;
            left: 0;
            top: 0;

            background: var(--sidebar);
            color: white;

            z-index: 1000;

            transition: 0.3s;
        }

        .brand {
            height: 75px;

            display: flex;
            align-items: center;

            padding: 0 24px;

            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .brand-icon {
            width: 42px;
            height: 42px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #198754;
            border-radius: 12px;

            font-size: 22px;

            margin-right: 12px;
        }

        .brand-title {
            font-size: 18px;
            font-weight: 800;
        }

        .brand-subtitle {
            font-size: 11px;
            color: #9fb8ad;
        }

        .sidebar-content {
            padding: 20px 14px;
        }

        .menu-title {
            font-size: 11px;
            font-weight: 700;

            color: #7fa294;

            text-transform: uppercase;

            padding: 15px 12px 8px;

            letter-spacing: 0.8px;
        }

        .sidebar a {
            color: #d7e5df;

            text-decoration: none;

            display: flex;
            align-items: center;

            gap: 12px;

            padding: 11px 13px;

            border-radius: 9px;

            margin-bottom: 3px;

            font-size: 14px;

            transition: 0.2s;
        }

        .sidebar a:hover {
            background: var(--sidebar-hover);
            color: white;
        }

        .sidebar a.active {
            background: var(--primary);
            color: white;
        }

        .sidebar a i {
            font-size: 17px;
        }

        /* MAIN */

        .main {
            margin-left: 260px;
            min-height: 100vh;
        }

        /* TOPBAR */

        .topbar {
            height: 75px;

            background: white;

            border-bottom: 1px solid var(--border);

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 30px;
        }

        .page-title {
            font-size: 18px;
            font-weight: 700;
        }

        .page-subtitle {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-avatar {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #d1e7dd;

            color: var(--primary-dark);

            border-radius: 50%;

            font-weight: 700;
        }

        /* CONTENT */

        .content {
            padding: 30px;
        }

        /* CARDS */

        .stat-card {
            background: white;

            border: 1px solid var(--border);

            border-radius: 16px;

            padding: 20px;

            height: 100%;

            transition: 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);

            box-shadow:
                0 8px 25px rgba(0,0,0,0.06);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-icon {
            width: 45px;
            height: 45px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 12px;

            font-size: 20px;
        }

        .icon-green {
            background: #d1e7dd;
            color: #146c43;
        }

        .icon-blue {
            background: #cfe2ff;
            color: #084298;
        }

        .icon-yellow {
            background: #fff3cd;
            color: #997404;
        }

        .icon-red {
            background: #f8d7da;
            color: #842029;
        }

        .stat-label {
            color: var(--muted);
            font-size: 13px;
            margin-top: 16px;
        }

        .stat-value {
            font-size: 27px;
            font-weight: 800;
            margin-top: 4px;
        }

        .stat-description {
            color: var(--muted);
            font-size: 11px;
            margin-top: 4px;
        }

        /* PANEL */

        .panel {
            background: white;

            border: 1px solid var(--border);

            border-radius: 16px;

            padding: 22px;

            height: 100%;
        }

        .panel-header {
            display: flex;

            align-items: center;
            justify-content: space-between;

            margin-bottom: 20px;
        }

        .panel-title {
            font-size: 16px;
            font-weight: 700;
        }

        .panel-link {
            color: var(--primary);

            text-decoration: none;

            font-size: 13px;
            font-weight: 600;
        }

        /* TABLE */

        .table {
            vertical-align: middle;
        }

        .table thead th {
            font-size: 12px;

            color: var(--muted);

            font-weight: 600;

            border-bottom: 1px solid var(--border);
        }

        .table tbody td {
            font-size: 13px;

            border-color: #f0f1f2;
        }

        .badge-status {
            padding: 6px 10px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: 600;
        }

        .badge-success {
            background: #d1e7dd;
            color: #146c43;
        }

        .badge-warning {
            background: #fff3cd;
            color: #997404;
        }

        /* BUTTON */

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* MOBILE */

        @media (max-width: 991px) {

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
            }

            .content {
                padding: 20px;
            }

            .topbar {
                padding: 0 20px;
            }

        }

    </style>

    @stack('styles')

</head>

<body>

<!-- SIDEBAR -->

<aside class="sidebar" id="sidebar">

    <div class="brand">

        <div class="brand-icon">
            <i class="bi bi-egg-fried"></i>
        </div>

        <div>
            <div class="brand-title">
                BukanAyam
            </div>

            <div clManagementass="brand-subtitle">
                Chicken Farm
            </div>
        </div>

    </div>

    <div class="sidebar-content">

        <div class="menu-title">
            Menu Utama
        </div>

        <a
            href="{{ url('/') }}"
            class="{{ request()->is('/') ? 'active' : '' }}"
        >
            <i class="bi bi-grid-1x2-fill"></i>
            Dashboard
        </a>


        <div class="menu-title">
            Data Peternakan
        </div>

        <a
            href="{{ route('kandang.index') }}"
            class="{{ request()->is('kandang*') ? 'active' : '' }}"
        >
            <i class="bi bi-house-door-fill"></i>
            Kandang
        </a>

        <a
            href="{{ route('populasi.index') }}"
            class="{{ request()->is('populasi*') ? 'active' : '' }}"
        >
            <i class="bi bi-people-fill"></i>
            Populasi Ayam
        </a>


        <div class="menu-title">
            Produksi
        </div>

        <a
            href="{{ route('produksi-telur.index') }}"
            class="{{ request()->is('produksi-telur*') ? 'active' : '' }}"
        >
            <i class="bi bi-egg-fill"></i>
            Produksi Telur
        </a>

        <a
            href="{{ route('penjualan-telur.index') }}"
            class="{{ request()->is('penjualan-telur*') ? 'active' : '' }}"
        >
            <i class="bi bi-cash-stack"></i>
            Penjualan Telur
        </a>


        <div class="menu-title">
            Pakan
        </div>

        <a
            href="{{ route('pakan-kandang.index') }}"
            class="{{ request()->is('pakan-kandang*') ? 'active' : '' }}"
        >
            <i class="bi bi-box-seam-fill"></i>
            Stok Pakan
        </a>

        <a
            href="{{ route('pemberian-pakan.index') }}"
            class="{{ request()->is('pemberian-pakan*') ? 'active' : '' }}"
        >
            <i class="bi bi-basket-fill"></i>
            Pemberian Pakan
        </a>

        <a
            href="{{ route('total-pakan.index') }}"
            class="{{ request()->is('total-pakan*') ? 'active' : '' }}"
        >
            <i class="bi bi-bar-chart-fill"></i>
            Total Pakan
        </a>

    </div>

</aside>


<!-- MAIN -->

<div class="main">

    <!-- TOPBAR -->

    <header class="topbar">

        <div>

            <div class="page-title">
                @yield('title', 'Dashboard')
            </div>

            <div class="page-subtitle">
                Sistem Manajemen Peternakan Ayam
            </div>

        </div>

        <div class="profile">

            <div class="profile-avatar">
                A
            </div>

            <div class="d-none d-md-block">

                <div style="font-size:13px;font-weight:600;">
                    Administrator
                </div>

                <div style="font-size:11px;color:#6b7280;">
                    Farm Manager
                </div>

            </div>

        </div>

    </header>


    <!-- CONTENT -->

    <main class="content">

        @if(session('success'))

            <div class="alert alert-success border-0 shadow-sm">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>

        @endif


        @if($errors->any())

            <div class="alert alert-danger border-0 shadow-sm">

                <strong>
                    Terjadi kesalahan:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        @yield('content')

    </main>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

@stack('scripts')

</body>

</html>
