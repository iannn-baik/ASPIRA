<?php

namespace App\Http\Controllers;

use App\Models\InstansiTujuan;
use App\Models\JenisPengajuan;
use App\Models\Kategori;
use App\Models\Laporan;
use App\Models\Lampiran;
use App\Models\RiwayatStatus;
use App\Models\StatusLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $laporan = Laporan::with(['status', 'jenis', 'kategori'])
            ->where('id_akun', $request->user()->id_akun)
            ->latest('tanggal_laporan')
            ->paginate(10);

        return view('laporan.index', compact('laporan'));
    }

    /**
     * Dipanggil dari form di beranda saat pengunjung belum login.
     * Isian disimpan sementara, lalu pengunjung diminta login/daftar
     * dan setelahnya dikembalikan ke form dengan isian yang sama.
     */
    public function lanjut(Request $request)
    {
        if ($request->user()) {
            return redirect()->route('laporan.create');
        }

        $request->session()->put('draft_laporan', $request->only([
            'id_jenis', 'id_kategori', 'id_instansi', 'judul', 'isi_laporan',
            'tanggal_kejadian', 'lokasi_kejadian', 'anonim', 'rahasia',
        ]));
        $request->session()->put('url.intended', route('laporan.create'));

        return redirect()->route('login');
    }

    public function create()
    {
        return view('laporan.create', [
            'draft'    => session()->pull('draft_laporan', []),
            'jenis'    => JenisPengajuan::orderBy('id_jenis')->get(),
            'kategori' => Kategori::orderBy('nama_kategori')->get(),
            'instansi' => InstansiTujuan::orderBy('nama_instansi')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_jenis'         => 'required|exists:jenis_pengajuan,id_jenis',
            'id_kategori'      => 'required|exists:kategori,id_kategori',
            'id_instansi'      => 'nullable|exists:instansi_tujuan,id_instansi',
            'judul'            => 'required|string|max:150',
            'isi_laporan'      => 'required|string|min:20',
            'tanggal_kejadian' => 'required|date|before_or_equal:today',
            'lokasi_kejadian'  => 'required|string|max:150',
            'lampiran'         => 'nullable|array|max:3',
            'lampiran.*'       => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'isi_laporan.min'     => 'Isi laporan minimal 20 karakter.',
            'lampiran.max'        => 'Lampiran maksimal 3 file.',
            'lampiran.*.mimes'    => 'Lampiran harus berupa JPG, PNG, atau PDF.',
            'lampiran.*.max'      => 'Ukuran tiap lampiran maksimal 2 MB.',
        ]);

        $status = StatusLaporan::firstOrCreate(['nama_status' => 'Menunggu']);

        DB::transaction(function () use ($request, $data, $status) {
            $laporan = Laporan::create([
                'id_akun'          => $request->user()->id_akun,
                'id_jenis'         => $data['id_jenis'],
                'id_kategori'      => $data['id_kategori'],
                'id_instansi'      => $data['id_instansi'] ?? null,
                'id_status'        => $status->id_status,
                'judul'            => $data['judul'],
                'isi_laporan'      => $data['isi_laporan'],
                'tanggal_kejadian' => $data['tanggal_kejadian'] ?? null,
                'lokasi_kejadian'  => $data['lokasi_kejadian'] ?? null,
                'anonim'           => $request->boolean('anonim'),
                'rahasia'          => $request->boolean('rahasia'),
            ]);

            RiwayatStatus::create([
                'id_laporan'      => $laporan->id_laporan,
                'id_status'       => $status->id_status,
                'id_akun'         => $request->user()->id_akun,
                'keterangan'      => 'Laporan dikirim.',
                'waktu_perubahan' => now(),
            ]);

            foreach ($request->file('lampiran', []) as $file) {
                Lampiran::create([
                    'id_laporan' => $laporan->id_laporan,
                    'nama_file'  => $file->getClientOriginalName(),
                    'path_file'  => $file->store('lampiran', 'public'),
                ]);
            }
        });

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil dikirim. Kami akan segera menindaklanjutinya.');
    }
}
