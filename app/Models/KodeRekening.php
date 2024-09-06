<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeRekening extends Model
{
    use HasFactory;

    protected $fillable = ['kode_rekening', 'jenis_saldo', 'nama_kode_rekening'];

    protected $casts = [
        'kode_rekening' => 'json',
    ];

    public function getJenisRekeningAttribute()
    {
        $idJenis = $this->kode_rekening['id_jenis'];
        return JenisRekening::where('id_jenis', $idJenis)->first();
    }
}
