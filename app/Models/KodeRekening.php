<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeRekening extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_rekening_id',
        'nomor_rekening',
        'jenis_saldo', 
        'nama_rekening'
    ];

    protected $casts = [
        'kode_rekening' => 'json',
    ];
    
    public function getJenisRekeningAttribute()
    {
        $idJenis = $this->kode_rekening['id_jenis'];
        return JenisRekening::where('id_jenis', $idJenis)->first();
    }

    public function jenis_rekening(){
        return $this->belongsTo(JenisRekening::class,'jenis_rekening_id','id');
    }

    public function rekening_plotting(){
        return $this->hasOne(RekeningPlotting::class,'kode_rekening_id','id');
    }
}
