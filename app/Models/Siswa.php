<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_kelas',
        'id_sekolah',
        'nama',
        'foto',
        'tahun_ajaran',
        'angkatan',
        'email',
        'password',
    ];

    public function kelas() {
        return $this->belongsTo('App\Models\Kelas', 'nama_kelas');
    }
}
