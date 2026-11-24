<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_akun',
        'id_jenis',
        'id_kategori',
        'id_instansi',
        'id_status',
        'judul',
        'isi_laporan',
        'tanggal_kejadian',
        'lokasi_kejadian',
        'anonim',
        'rahasia',
        'tanggal_laporan'
    ];

    protected $casts = [
        'tanggal_kejadian' => 'date',
        'tanggal_laporan' => 'datetime',
        'anonim' => 'boolean',
        'rahasia' => 'boolean'
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }

    public function jenis()
    {
        return $this->belongsTo(JenisPengajuan::class, 'id_jenis', 'id_jenis');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function instansi()
    {
        return $this->belongsTo(InstansiTujuan::class, 'id_instansi', 'id_instansi');
    }

    public function status()
    {
        return $this->belongsTo(StatusLaporan::class, 'id_status', 'id_status');
    }

    public function lampiran()
    {
        return $this->hasMany(Lampiran::class, 'id_laporan', 'id_laporan');
    }

    public function riwayatStatus()
    {
        return $this->hasMany(RiwayatStatus::class, 'id_laporan', 'id_laporan');
    }

    public function tanggapan()
    {
        return $this->hasMany(Tanggapan::class, 'id_laporan', 'id_laporan');
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'id_laporan', 'id_laporan');
    }
}
