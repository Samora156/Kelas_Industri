<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'email_sekolah',
        'kepala_sekolah',
        'telp_sekolah',
        'alamat',
        'nama_sekolah',
        'logo',
    ];
}
