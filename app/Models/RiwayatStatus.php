<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatStatus extends Model
{
    protected $table = 'riwayat_status';
    protected $primaryKey = 'id_riwayat';

    protected $fillable = [
        'id_laporan',
        'id_status',
        'id_akun',
        'keterangan',
        'waktu_perubahan'
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }

    public function status()
    {
        return $this->belongsTo(StatusLaporan::class, 'id_status', 'id_status');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }
}
