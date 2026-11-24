<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPengajuan extends Model
{
    protected $table = 'jenis_pengajuan';
    protected $primaryKey = 'id_jenis';

    protected $fillable = ['nama_jenis'];

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_jenis', 'id_jenis');
    }
}
