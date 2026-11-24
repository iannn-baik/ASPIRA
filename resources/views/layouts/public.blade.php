<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ASPIRA') | Aspirasi & Pengaduan Mahasiswa</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

<div class="topbar">
    <div class="container topbar-inner">
        <span>Layanan Aspirasi &amp; Pengaduan Online Mahasiswa</span>
        <span>Waktu Lokal <strong id="jam">--:--:--</strong> WIB</span>
    </div>
</div>

<header class="navbar">
    <div class="container nav-inner">
        <a href="{{ route('beranda') }}" class="nav-brand">
            <span class="brand-icon">A</span>
            <span>ASPIRA</span>
        </a>

        <button class="nav-toggle" type="button" aria-label="Buka menu" onclick="document.getElementById('navMenu').classList.toggle('open')">☰</button>

        <nav class="nav-menu" id="navMenu">
            <div class="nav-links">
                <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'active' : '' }}">Home</a>
                <a href="{{ route('statistik') }}" class="{{ request()->routeIs('statistik') ? 'active' : '' }}">Statistik</a>
                <a href="{{ route('laporan.publik') }}" class="{{ request()->routeIs('laporan.publik') ? 'active' : '' }}">Laporan Publik</a>
                <a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'active' : '' }}">FAQ</a>
            </div>

            <div class="nav-actions">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('mahasiswa.dashboard') }}" class="btn btn-outline">
                        Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-ghost">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                @endauth
            </div>
        </nav>
    </div>
</header>

@yield('content')

<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <h4>Dikelola oleh</h4>
            <div class="nav-brand footer-brand">
                <span class="brand-icon">A</span>
                <span>ASPIRA</span>
            </div>
            <p>Layanan aspirasi dan pengaduan mahasiswa Universitas Lampung.</p>
        </div>
        <div class="footer-social">
            <h4>Sosial Media</h4>
            <div class="social-links">
                <a href="#">Instagram</a>
                <a href="#">X</a>
                <a href="#">YouTube</a>
            </div>
        </div>
    </div>
    <div class="container footer-copy">© {{ date('Y') }} ASPIRA Universitas Lampung</div>
</footer>

<script>
(function () {
    var el = document.getElementById('jam');
    function tick() {
        el.textContent = new Date().toLocaleTimeString('en-GB', { timeZone: 'Asia/Jakarta', hour12: false });
    }
    tick(); setInterval(tick, 1000);
})();
</script>

</body>
</html>
