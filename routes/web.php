<?php

<<<<<<< HEAD
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman publik (tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('beranda');
Route::get('/statistik', [HomeController::class, 'statistik'])->name('statistik');
Route::get('/laporan-publik', [HomeController::class, 'laporanPublik'])->name('laporan.publik');
Route::get('/faq', fn () => view('faq'))->name('faq');

// Pengunjung yang belum login mengisi form di beranda -> draft disimpan, lalu diminta login.
Route::post('/laporan/lanjut', [LaporanController::class, 'lanjut'])->name('laporan.lanjut');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
=======
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

>>>>>>> 8539ca7d03a75e9fda300092635991690f3976ae
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

<<<<<<< HEAD
/*
|--------------------------------------------------------------------------
| Mahasiswa (wajib login). Buat laporan baru bisa diakses setelah login.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/laporan/buat', [LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    });
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
=======
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
>>>>>>> 8539ca7d03a75e9fda300092635991690f3976ae
});
