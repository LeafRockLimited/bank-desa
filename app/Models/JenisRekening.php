<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisRekening extends Model
{
    use HasFactory;

    protected $fillable = ['id_jenis', 'nama'];
    
    public function kodeRekening()
    {
        return $this->hasMany(KodeRekening::class, 'kode_rekening->id_jenis', 'id_jenis');
    }
}
