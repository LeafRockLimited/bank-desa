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
        'level_one',
        'uraian_level_one',
        'level_two',
        'uraian_level_two',
        'level_three',
        'uraian_level_three',
        'level_four',
        'uraian_level_four',
        'level_five',
        'uraian_level_five',
        'level_six',
        'uraian_level_six',
    ];

    public function bukuBesars()
    {
        return $this->hasMany(BukuBesar::class, 'id_kode_rekening', 'id');
    }
}
