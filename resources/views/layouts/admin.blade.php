<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Toko Buah Nayla</title>
    <link rel="stylesheet" href="{{ asset('css/apple.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 250px;
            background-color: var(--surface-tile-1);
            color: var(--body-on-dark);
            padding: 24px 0;
            display: flex;
            flex-direction: column;
        }
        .admin-sidebar .logo {
            font-size: 24px;
            font-weight: 600;
            padding: 0 24px;
            margin-bottom: 32px;
            color: var(--body-on-dark);
        }
        .admin-sidebar a {
            color: var(--body-muted);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
        }
        .admin-sidebar a:hover, .admin-sidebar a.active {
            color: var(--body-on-dark);
            background-color: var(--surface-tile-2);
        }
        .admin-content {
            flex: 1;
            background-color: var(--canvas-parchment);
            padding: 32px;
            overflow-y: auto;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }
        .card {
            background: var(--canvas);
            border-radius: 12px;
            padding: 24px;
            border: 1px solid var(--hairline);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 16px;
            border-bottom: 1px solid var(--hairline);
        }
        th {
            font-weight: 600;
            color: var(--ink-muted-80);
            font-size: 14px;
        }
        td {
            font-size: 15px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <i class="fa-solid fa-apple-whole" style="color:var(--primary-on-dark)"></i> Admin
            </a>
            <div style="flex:1;">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i> Dashboard
                </a>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-tags"></i> Kategori
                </a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box"></i> Produk
                </a>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.index') || request()->routeIs('admin.orders.show') ? 'active' : '' }}">
                    <i class="fa-solid fa-cart-shopping"></i> Pesanan
                </a>
                <a href="{{ route('admin.orders.scan') }}" class="{{ request()->routeIs('admin.orders.scan') ? 'active' : '' }}">
                    <i class="fa-solid fa-qrcode"></i> Scan QR Pelanggan
                </a>
            </div>
            <div style="margin-top: auto;">
                <a href="{{ route('home') }}">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Toko
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background:transparent; border:none; width:100%; text-align:left; color:var(--body-muted); padding:12px 24px; cursor:pointer; font-size:17px; display:flex; align-items:center; gap:12px;">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="admin-content">
            <div class="admin-header">
                <div>
                    <h1 class="display-md" style="font-size:28px;">@yield('header_title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-4">
                    <span style="font-weight:600;">{{ auth()->user()->name }}</span>
                    <div style="width:40px; height:40px; background:var(--primary); color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:600;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div style="background: #10b981; color: white; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background: #ef4444; color: white; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
