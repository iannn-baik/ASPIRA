<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'nim';

        $credentials = [
            $field => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // Kembali ke halaman yang tadi dituju (mis. form Buat Laporan)
            return redirect()->intended(route('mahasiswa.dashboard'));
        }

        return back()
            ->withErrors(['login' => 'NIM/email atau password salah.'])
            ->onlyInput('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:akun,nim',
            'email' => 'required|email|max:100|unique:akun,email',
            'fakultas' => 'required|string|max:100',
            'program_studi' => 'required|string|max:100',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'mahasiswa';

        $akun = Akun::create($data);

        Auth::login($akun);
        $request->session()->regenerate();

        return redirect()->intended(route('mahasiswa.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda');
    }
}
