<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BukuBesar extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_jurnal',
        'id_rekening',
        'debit',
        'kredit',
        'saldo',
    ];

    public function rekening()
    {
        return $this->belongsTo(KodeRekening::class, 'id_rekening', 'id');
    }

    public function jurnal(){
        return $this->belongsTo(Jurnal::class,'id_jurnal','id');
    }


}
