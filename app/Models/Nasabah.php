<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'alamat',
        'nomor_telepon',
        'email',
        'tanggal_lahir',
        'nomor_identitas',
        'pekerjaan',
    ];
}
