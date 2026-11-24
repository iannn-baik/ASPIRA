<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa | ASPIRA</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

<div class="app">
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <div class="brand-logo">A</div>
            <div>
                <h2>ASPIRA</h2>
                <small>Aspirasi Mahasiswa</small>
            </div>
        </div>

        <div class="menu-label">MENU UTAMA</div>

        <nav>
            <a href="{{ route('mahasiswa.dashboard') }}" class="menu active">
                <span>▦</span> Dashboard
            </a>
            <a href="#" class="menu">
                <span>＋</span> Buat Laporan
            </a>
            <a href="#" class="menu">
                <span>▤</span> Riwayat Laporan
            </a>
            <a href="#" class="menu">
                <span>◉</span> Informasi
            </a>
        </nav>

        <div class="menu-label">AKUN</div>
        <nav>
            <a href="#" class="menu">
                <span>♙</span> Profil Saya
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="help-box">
                <strong>Butuh bantuan?</strong>
                <p>Hubungi layanan bantuan ASPIRA.</p>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="logout" type="submit">↪ Keluar</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <button class="hamburger" onclick="toggleSidebar()">☰</button>
            <div class="breadcrumb">Halaman / <strong>Dashboard</strong></div>

            <div class="user-info">
                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <strong>{{ auth()->user()->nama_lengkap }}</strong>
                    <small>Mahasiswa</small>
                </div>
            </div>
        </header>

        <section class="content">
            <div class="welcome">
                <div>
                    <p class="eyebrow">DASHBOARD MAHASISWA</p>
                    <h1>Halo, {{ auth()->user()->nama_lengkap }}!</h1>
                    <p>Selamat datang di layanan aspirasi dan pengaduan mahasiswa.</p>
                </div>

                <div class="welcome-icon">✦</div>
            </div>

            <div class="section-heading">
                <div>
                    <h2>Ringkasan Laporan</h2>
                    <p>Pantau perkembangan laporan yang kamu kirimkan.</p>
                </div>
                <a href="#" class="primary-button">＋ Buat Laporan</a>
            </div>

            <div class="stats">
                <div class="stat-card">
                    <div class="stat-icon blue">▤</div>
                    <div>
                        <span>Total Laporan</span>
                        <h2>{{ \App\Models\Laporan::where('id_akun', auth()->id())->count() }}</h2>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orange">◷</div>
                    <div>
                        <span>Menunggu</span>
                        <h2>{{ \App\Models\Laporan::where('id_akun', auth()->id())->whereHas('statusLaporan', fn($q) => $q->where('nama_status', 'Menunggu'))->count() }}</h2>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon purple">↻</div>
                    <div>
                        <span>Diproses</span>
                        <h2>{{ \App\Models\Laporan::where('id_akun', auth()->id())->whereHas('statusLaporan', fn($q) => $q->where('nama_status', 'Diproses'))->count() }}</h2>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green">✓</div>
                    <div>
                        <span>Selesai</span>
                        <h2>{{ \App\Models\Laporan::where('id_akun', auth()->id())->whereHas('statusLaporan', fn($q) => $q->where('nama_status', 'Selesai'))->count() }}</h2>
                    </div>
                </div>
            </div>

            <div class="section-heading report-heading">
                <div>
                    <h2>Laporan Terbaru</h2>
                    <p>Daftar laporan yang sudah kamu kirimkan.</p>
                </div>
                <a href="#" class="text-link">Lihat semua →</a>
            </div>

            <div class="report-container">
                @php
                    $reports = \App\Models\Laporan::with(['statusLaporan', 'jenisPengajuan'])
                        ->where('id_akun', auth()->id())
                        ->latest('tanggal_laporan')
                        ->take(5)
                        ->get();
                @endphp

                @forelse($reports as $report)
                    <div class="report-item">
                        <div class="report-icon">▤</div>
                        <div class="report-detail">
                            <strong>{{ $report->judul }}</strong>
                            <small>
                                {{ $report->jenisPengajuan->nama_jenis ?? 'Laporan' }}
                                · {{ $report->tanggal_laporan }}
                            </small>
                        </div>
                        <span class="status">
                            {{ $report->statusLaporan->nama_status ?? 'Belum ada status' }}
                        </span>
                    </div>
                @empty
                    <div class="empty-state">
                        <div>▤</div>
                        <strong>Belum ada laporan</strong>
                        <p>Kamu belum mengirimkan laporan apa pun.</p>
                    </div>
                @endforelse
            </div>

            <footer>
                © {{ date('Y') }} ASPIRA — Layanan Aspirasi dan Pengaduan Mahasiswa
            </footer>
        </section>
    </main>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
}
</script>

</body>
</html>
