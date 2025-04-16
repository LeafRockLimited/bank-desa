<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neraca extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_rekening_id',
        'total_debit',
        'total_kredit',
        'saldo',
        'periode_awal', // Tanggal 1 setiap bulan
    ];

    protected $dates = ['periode_awal'];

    public function kodeRekening()
    {
        return $this->belongsTo(KodeRekening::class, 'kode_rekening_id');
    }

    public static function getOrCreateForCurrentMonth($kodeRekeningId)
    {
        $periodeAwal = Carbon::now()->startOfMonth();

        return self::firstOrCreate(
            ['kode_rekening_id' => $kodeRekeningId, 'periode_awal' => $periodeAwal],
            ['total_debit' => 0, 'total_kredit' => 0, 'saldo' => 0]
        );
    }
}
