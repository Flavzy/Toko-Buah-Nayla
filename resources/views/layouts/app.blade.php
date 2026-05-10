<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Buah Nayla - @yield('title', 'Buah Segar Setiap Hari')</title>
    <link rel="stylesheet" href="{{ asset('css/apple.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body>
    <!-- Global Nav -->
    <nav class="global-nav" id="global-nav">
        <div class="container nav-container">
            <a href="{{ route('home') }}" style="font-size: 18px; font-weight: 600;"><i class="fa-solid fa-apple-whole"></i></a>
            
            <!-- Mobile Toggle -->
            <button class="nav-toggle" id="nav-toggle">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="nav-links" id="nav-links">
                <a href="{{ route('products.index') }}">Store</a>
                <a href="{{ route('home') }}#kategori">Macam Buah</a>
                <a href="{{ route('products.index', ['category' => 'es-buah']) }}">Es Buah</a>
                <a href="#footer">Tentang Kami</a>
                
                <div class="flex items-center gap-4 ml-4" style="border-left: 1px solid rgba(255,255,255,0.2); padding-left: 16px;">
                    <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                    <a href="{{ route('cart.index') }}">
                        <i class="fa-solid fa-bag-shopping"></i>
                        @php $cartCount = collect(session('cart', []))->sum('quantity'); @endphp
                        @if($cartCount > 0)
                            <span style="background:var(--primary); color:white; border-radius:50%; padding:2px 6px; font-size:10px; margin-left:4px;">{{ $cartCount }}</span>
                        @endif
                    </a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        @else
                            <a href="{{ route('orders.index') }}">Pesanan</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="btn" style="background:transparent; color:var(--body-on-dark); font-size:12px; padding:0 16px;">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">Sign In</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <script>
        document.getElementById('nav-toggle').addEventListener('click', function() {
            document.getElementById('global-nav').classList.toggle('mobile-active');
            const icon = this.querySelector('i');
            if (icon.classList.contains('fa-bars')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            } else {
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            }
        });

        // Close menu when clicking links
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('global-nav').classList.remove('mobile-active');
                document.getElementById('nav-toggle').querySelector('i').classList.replace('fa-xmark', 'fa-bars');
            });
        });
    </script>

    @if(session('success'))
        <div style="background: #10b981; color: white; text-align: center; padding: 12px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #ef4444; color: white; text-align: center; padding: 12px; font-size: 14px;">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')

    <!-- Footer -->
    <footer id="footer" class="site-footer">
        <div class="container">
            <div class="grid grid-cols-4 gap-6 mb-8">
                <div>
                    <h3 class="caption" style="font-weight: 600; margin-bottom: 16px;">Belanja dan Belajar</h3>
                    <div class="flex-col gap-2">
                        <a href="#" class="dense-link">Store</a>
                        <a href="#" class="dense-link">Buah Segar</a>
                        <a href="#" class="dense-link">Es Buah</a>
                        <a href="#" class="dense-link">Buah Import</a>
                    </div>
                </div>
                <div>
                    <h3 class="caption" style="font-weight: 600; margin-bottom: 16px;">Akun</h3>
                    <div class="flex-col gap-2">
                        <a href="#" class="dense-link">Kelola Akun Anda</a>
                        <a href="{{ route('cart.index') }}" class="dense-link">Keranjang Belanja</a>
                        <a href="{{ route('orders.index') }}" class="dense-link">Status Pesanan</a>
                    </div>
                </div>
                <div>
                    <h3 class="caption" style="font-weight: 600; margin-bottom: 16px;">Toko Buah Nayla</h3>
                    <div class="flex-col gap-2">
                        <a href="#" class="dense-link">Temukan Toko</a>
                        <a href="#" class="dense-link">Berbelanja Langsung</a>
                        <a href="#" class="dense-link">Opsi Pembayaran</a>
                    </div>
                </div>
                <div>
                    <h3 class="caption" style="font-weight: 600; margin-bottom: 16px;">Tentang Kami</h3>
                    <div class="flex-col gap-2">
                        <a href="#" class="dense-link">Sejarah Nayla</a>
                        <a href="#" class="dense-link">Karir</a>
                        <a href="#" class="dense-link">Hubungi Kami</a>
                    </div>
                </div>
            </div>
            <div class="fine-print flex justify-between items-center">
                <p>Copyright © {{ date('Y') }} Toko Buah Nayla. Semua hak dilindungi undang-undang.</p>
                <div class="flex gap-4">
                    <a href="#" class="text-muted">Kebijakan Privasi</a>
                    <a href="#" class="text-muted">Syarat Penggunaan</a>
                    <a href="#" class="text-muted">Peta Situs</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
