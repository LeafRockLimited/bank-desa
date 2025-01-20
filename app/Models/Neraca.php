<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neraca extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_rekening',
        'tahun',
        'bulan',
        'neraca_debit',
        'neraca_kredit',
        'saldo_debit',
        'saldo_kredit',
        'jumlah'
    ];

    public function rekening()
    {
        return $this->belongsTo(KodeRekening::class, 'id_rekening', 'id');
    }
}
