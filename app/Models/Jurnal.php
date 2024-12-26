<?php

namespace App\Models;

use App\BukuBesarTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_bukti',
        'id_rekening',
        'debit',
        'kredit',
        'jumlah',
        'keterangan',
        'tanggal_transaksi',
        'komponen_lak',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($jurnal) {
            if (is_null($jurnal->kredit) || $jurnal->kredit == '') {
                $jurnal->kredit = 0;
            }
            if (is_null($jurnal->debit) || $jurnal->debit == '') {
                $jurnal->debit = 0;
            }

            $rekening = KodeRekening::find($jurnal->id_rekening);
            if($rekening->saldo_normal == 'Debit'){
                $jurnal->jumlah = $jurnal->debit - $jurnal->kredit;
            }else{
                $jurnal->jumlah = $jurnal->kredit - $jurnal->debit;
            }
        });

        static::updating(function ($jurnal) {
            if (is_null($jurnal->kredit) || $jurnal->kredit == '') {
                $jurnal->kredit = 0;
            }
            if (is_null($jurnal->debit) || $jurnal->debit == '') {
                $jurnal->debit = 0;
            }
            $rekening = KodeRekening::find($jurnal->id_rekening);
            if($rekening->saldo_normal == 'Debit'){
                $jurnal->jumlah = $jurnal->debit - $jurnal->kredit;
            }else{
                $jurnal->jumlah = $jurnal->kredit - $jurnal->debit;
            }
        });
    }

    public function rekening()
    {
        return $this->belongsTo(KodeRekening::class, 'id_rekening', 'id');
    }

    public function buku_besar()
    {
        return $this->hasOne(BukuBesar::class, 'id_jurnal', 'id');
    }
}
