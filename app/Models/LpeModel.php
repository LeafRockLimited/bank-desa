<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LpeModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tahun'.
        'bulan',
        'penyertaan_modal_desa_awal',
        'penyertaan_modal_masyarakat_awal',
        'penyertaan_modal_desa',
        'penyertaan_modal_masyarakat',
        'penyertaan_modal_akhir',
        'saldo_awal_tidak_dicadangkan',
        'saldo_laba_dicadangkan',
        'laba_rugi_periode_berjalan',
        'bagi_hasil_penyertaan_modal_desa',
        'bagi_hasil_penyertaan_modal_masyarakat',
        'saldo_laba_akhir',
        'modal_donasi_sumbangan',
        'ekuitas_akhir'
    ];
}
