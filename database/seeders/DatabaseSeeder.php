
<?php

namespace Database\Seeders;

use App\Models\InstansiTujuan;
use App\Models\JenisPengajuan;
use App\Models\Kategori;
use App\Models\StatusLaporan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Pengaduan', 'Aspirasi', 'Permintaan Informasi'] as $nama) {
            JenisPengajuan::firstOrCreate(['nama_jenis' => $nama]);
        }

        foreach ([
            'Akademik',
            'Fasilitas Kampus',
            'Kemahasiswaan',
            'Keuangan & Beasiswa',
            'Layanan Administrasi',
            'Keamanan & Ketertiban',
            'Lainnya',
        ] as $nama) {
            Kategori::firstOrCreate(['nama_kategori' => $nama]);
        }

        foreach ([
            'Rektorat',
            'Fakultas',
            'Biro Akademik',
            'Biro Kemahasiswaan',
            'UPT TIK',
        ] as $nama) {
            InstansiTujuan::firstOrCreate(['nama_instansi' => $nama]);
        }

        foreach (['Menunggu', 'Diproses', 'Selesai', 'Ditolak'] as $nama) {
            StatusLaporan::firstOrCreate(['nama_status' => $nama]);
        }
    }
}
