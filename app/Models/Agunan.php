<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agunan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pinjaman_id',
        'jenis_agunan',
        'nilai_agunan',
        'deskripsi_agunan',
        'tanggal_diserahkan',
        'status_agunan',
        'gambar_agunan'
    ];

    // Relasi ke model Pinjaman
    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'pinjaman_id');
    }
}
