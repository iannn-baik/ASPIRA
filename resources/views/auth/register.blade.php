<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi ASPIRA</title>
</head>
<body>
    <h2>Daftar ASPIRA</h2>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color:red">{{ $error }}</p>
        @endforeach
    @endif

    <form action="{{ route('register.process') }}" method="POST">
        @csrf

        <input name="nama_lengkap" placeholder="Nama lengkap" required>
        <input name="nim" placeholder="NIM" required>
        <input type="email" name="email" placeholder="Email" required>
        <input name="fakultas" placeholder="Fakultas" required>
        <input name="program_studi" placeholder="Program studi" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation"
            placeholder="Konfirmasi password" required>

        <button type="submit">Daftar</button>
    </form>

    <a href="{{ route('login') }}">Sudah punya akun? Login</a>
</body>
</html>
