
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun | ASPIRA</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 35px 20px;
            color: #1e293b;
        }

        .container {
            width: 100%;
            max-width: 1050px;
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            background: white;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(30, 64, 175, 0.09);
        }

        .left-panel {
            background: linear-gradient(145deg, #1746a2, #2563eb);
            color: white;
            padding: 55px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo {
            font-size: 27px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 55px;
        }

        .logo span {
            color: #bfdbfe;
        }

        .left-panel h1 {
            font-size: 31px;
            line-height: 1.4;
            margin-bottom: 18px;
        }

        .left-panel p {
            font-size: 14px;
            line-height: 1.9;
            color: #dbeafe;
        }

        .left-footer {
            margin-top: 65px;
            font-size: 12px;
            color: #bfdbfe;
        }

        .right-panel {
            padding: 45px 50px;
        }

        .form-header {
            margin-bottom: 28px;
        }

        .form-header h2 {
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .form-header p {
            color: #64748b;
            font-size: 13px;
        }

        .form-group {
            margin-bottom: 17px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 7px;
            color: #334155;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #dbe2ed;
            border-radius: 9px;
            outline: none;
            font-family: inherit;
            font-size: 13px;
            background: #fff;
            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-group input::placeholder {
            color: #a0aaba;
        }

        .error-box {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            padding: 12px 15px;
            border-radius: 9px;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .error-box ul {
            padding-left: 18px;
        }

        .btn-submit {
            width: 100%;
            border: none;
            padding: 13px;
            border-radius: 9px;
            background: #2563eb;
            color: white;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: 0.2s;
        }

        .btn-submit:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .login-link {
            text-align: center;
            margin-top: 22px;
            font-size: 12px;
            color: #64748b;
        }

        .login-link a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 750px) {
            body {
                padding: 20px 14px;
            }

            .container {
                grid-template-columns: 1fr;
                max-width: 480px;
            }

            .left-panel {
                padding: 28px;
            }

            .logo {
                margin-bottom: 22px;
            }

            .left-panel h1 {
                font-size: 23px;
            }

            .left-panel p {
                font-size: 12px;
            }

            .left-footer {
                display: none;
            }

            .right-panel {
                padding: 30px 25px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="left-panel">
        <div class="logo">ASP<span>IRA</span></div>

        <h1>Sampaikan Aspirasi dan Pengaduanmu</h1>

        <p>
            Buat akun ASPIRA untuk menyampaikan pengaduan,
            aspirasi, dan kebutuhan informasi terkait
            pelayanan kampus secara mudah.
        </p>

        <div class="left-footer">
            Sistem Informasi Aspirasi dan Pengaduan
        </div>
    </div>

    <div class="right-panel">

        <div class="form-header">
            <h2>Buat Akun</h2>
            <p>Lengkapi data berikut untuk mendaftar ke ASPIRA.</p>
        </div>

        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.process') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap"
                    placeholder="Masukkan nama lengkap"
                    value="{{ old('nama_lengkap') }}" required>
            </div>

            <div class="form-group">
                <label>Nomor Induk Mahasiswa (NIM)</label>
                <input type="text" name="nim"
                    placeholder="Masukkan NIM"
                    value="{{ old('nim') }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email"
                    placeholder="nama@email.com"
                    value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Fakultas</label>
                <input type="text" name="fakultas"
                    placeholder="Masukkan fakultas"
                    value="{{ old('fakultas') }}" required>
            </div>

            <div class="form-group">
                <label>Program Studi</label>
                <input type="text" name="program_studi"
                    placeholder="Masukkan program studi"
                    value="{{ old('program_studi') }}" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password"
                    placeholder="Minimal 8 karakter" required>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="btn-submit">
                Daftar Sekarang
            </button>
        </form>

        <div class="login-link">
            Sudah punya akun?
            <a href="{{ route('login') }}">Masuk di sini</a>
        </div>

    </div>
</div>

</body>
</html>
