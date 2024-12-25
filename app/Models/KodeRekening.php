<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeRekening extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_rekening',
        'nama_rekening',
        'saldo_normal',
        'deskripsi',
    ];

    public function bukuBesars()
    {
        return $this->hasMany(BukuBesar::class, 'id_kode_rekening', 'id');
    }
}
