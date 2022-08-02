<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_sekolah',
        'id_kelas',
        'nama_guru',
        'foto',
        'alamat',
        'tlpn',
        'bank',
        'rekening',
        'email',
        'password',
    ];
}
