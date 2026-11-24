<?php

namespace Database\Seeders;

<<<<<<< HEAD
use App\Models\InstansiTujuan;
use App\Models\JenisPengajuan;
use App\Models\Kategori;
use App\Models\StatusLaporan;
=======
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
>>>>>>> 8539ca7d03a75e9fda300092635991690f3976ae
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
<<<<<<< HEAD
    /**
     * Data master untuk form laporan. Aman dijalankan berulang kali.
     */
    public function run(): void
    {
        foreach (['Pengaduan', 'Aspirasi', 'Permintaan Informasi'] as $nama) {
            JenisPengajuan::firstOrCreate(['nama_jenis' => $nama]);
        }

        foreach ([
            'Akademik', 'Fasilitas Kampus', 'Kemahasiswaan', 'Keuangan & Beasiswa',
            'Layanan Administrasi', 'Keamanan & Ketertiban', 'Lainnya',
        ] as $nama) {
            Kategori::firstOrCreate(['nama_kategori' => $nama]);
        }

        foreach ([
            'Rektorat', 'Fakultas', 'Biro Akademik', 'Biro Kemahasiswaan', 'UPT TIK',
        ] as $nama) {
            InstansiTujuan::firstOrCreate(['nama_instansi' => $nama]);
        }

        foreach (['Menunggu', 'Diproses', 'Selesai', 'Ditolak'] as $nama) {
            StatusLaporan::firstOrCreate(['nama_status' => $nama]);
        }
=======
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
>>>>>>> 8539ca7d03a75e9fda300092635991690f3976ae
    }
}
