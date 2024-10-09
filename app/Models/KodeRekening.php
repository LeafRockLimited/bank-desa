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
        'nama_rekening',
        'tipe',
        'sub_tipe',
        'status',
        'deskripsi',
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

    public function bukuBesars()
    {
        return $this->hasMany(BukuBesar::class, 'id_kode_rekening', 'id');
    }
}
