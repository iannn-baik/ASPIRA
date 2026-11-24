<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Akun extends Authenticatable
{
    protected $table = 'akun';
    protected $primaryKey = 'id_akun';

    protected $fillable = [
        'nama_lengkap',
        'nim',
        'email',
        'password',
        'fakultas',
        'program_studi',
        'role'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'id_akun', 'id_akun');
    }

    public function tanggapan(): HasMany
    {
        return $this->hasMany(Tanggapan::class, 'id_akun', 'id_akun');
    }

    public function riwayatStatus(): HasMany
    {
        return $this->hasMany(RiwayatStatus::class, 'id_akun', 'id_akun');
    }
}
