<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\InstansiTujuan;
use App\Models\JenisPengajuan;
use App\Models\Kategori;
use App\Models\Laporan;
use App\Models\StatusLaporan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /** Beranda: hanya hero, form laporan, dan alur. */
    public function index()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();
        $instansi = InstansiTujuan::orderBy('nama_instansi')->get();

        // Urutan tab: Pengaduan, Aspirasi, Permintaan Informasi
        $urutan = ['Pengaduan', 'Aspirasi', 'Permintaan Informasi'];
        $jenis = JenisPengajuan::all()->sortBy(function ($j) use ($urutan) {
            $i = array_search($j->nama_jenis, $urutan);
            return $i === false ? 99 : $i;
        })->values();

        return view('beranda', compact('kategori', 'instansi', 'jenis'));
    }

    /** Halaman Statistik */
    public function statistik()
    {
        $stats = [
            'total'     => Laporan::count(),
            'diproses'  => Laporan::whereHas('status', fn ($q) => $q->where('nama_status', 'Diproses'))->count(),
            'selesai'   => Laporan::whereHas('status', fn ($q) => $q->where('nama_status', 'Selesai'))->count(),
            'mahasiswa' => Akun::where('role', 'mahasiswa')->count(),
        ];

        $perStatus   = StatusLaporan::withCount('laporan')->orderBy('id_status')->get();
        $perKategori = Kategori::withCount('laporan')->orderByDesc('laporan_count')->get();

        $maxKategori = max(1, (int) $perKategori->max('laporan_count'));
        $totalLaporan = max(1, $stats['total']);

        return view('statistik', compact('stats', 'perStatus', 'perKategori', 'maxKategori', 'totalLaporan'));
    }

    /** Halaman Laporan Publik (hanya laporan yang tidak rahasia, tanpa identitas pelapor) */
    public function laporanPublik(Request $request)
    {
        $query = Laporan::with(['status', 'kategori', 'jenis'])->where('rahasia', false);

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        $laporan  = $query->latest('tanggal_laporan')->paginate(9)->withQueryString();
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('laporan.publik', compact('laporan', 'kategori'));
    }
}
