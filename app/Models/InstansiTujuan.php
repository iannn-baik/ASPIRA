<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstansiTujuan extends Model
{
    protected $table = 'instansi_tujuan';
    protected $primaryKey = 'id_instansi';

    protected $fillable = ['nama_instansi'];

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_instansi', 'id_instansi');
    }
}
