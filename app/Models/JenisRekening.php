<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisRekening extends Model
{
    use HasFactory;

    protected $fillable = ['id_jenis', 'nama'];
    
    public function kode_rekening()
    {
        return $this->hasMany(KodeRekening::class, 'kode_rekening->id_jenis', 'id_jenis');
    }
}
