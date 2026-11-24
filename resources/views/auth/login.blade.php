
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | ASPIRA</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="login-wrapper">

    <section class="illustration">
        <div class="brand">
            <div class="brand-icon">A</div>
            <span>ASPIRA</span>
        </div>

        <div class="illustration-content">
            <div class="illustration-circle">
                <div class="illustration-card">
                    <div class="mini-icon">✓</div>
                    <div class="mini-lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="mini-status">Laporan terkirim</div>
                </div>
                <div class="floating-icon">✦</div>
                <div class="floating-icon second">✉</div>
            </div>

            <h1>Suarakan Aspirasi,<br>Wujudkan Perubahan.</h1>
            <p>Sampaikan pengaduan dan aspirasi kamu untuk menciptakan lingkungan kampus yang lebih baik.</p>
        </div>

        <div class="illustration-footer">
            © 2026 ASPIRA Universitas Lampung
        </div>
    </section>

    <main class="login-section">
        <div class="login-card">

            <div class="mobile-brand">
                <div class="brand-icon">A</div>
                <span>ASPIRA</span>
            </div>

            <div class="welcome-text">
                <span class="subtitle">SELAMAT DATANG KEMBALI</span>
                <h2>Masuk ke akunmu</h2>
                <p>Silakan masuk untuk melanjutkan ke layanan ASPIRA.</p>
            </div>

            @if (session('url.intended') && !$errors->any())
                <div class="alert" style="background:#eef6ff;border-color:#cfe4f8;color:#176daf;">
                    Silakan masuk terlebih dahulu untuk membuat laporan.
                </div>
            @endif

            @if ($errors->any())
                <div class="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="login">Email atau NIM</label>
                    <input
                        type="text"
                        id="login"
                        name="login"
                        value="{{ old('login') }}"
                        placeholder="Masukkan email atau NIM"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <div class="form-options">
                    <label class="remember">
                        <input type="checkbox" name="remember">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="login-button">
                    Masuk ke ASPIRA
                    <span>→</span>
                </button>
            </form>

            <div class="register-link">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>

            <div class="register-link">
                <a href="{{ route('beranda') }}">← Kembali ke beranda</a>
            </div>

            <div class="login-footer">
                ASPIRA · Layanan Aspirasi dan Pengaduan Mahasiswa
            </div>

        </div>
    </main>

</div>

</body>
</html>
