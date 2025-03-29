<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanSimpanan extends Model
{
    use HasFactory;
    protected $table = 'simpanan_laporans';
    protected $fillable = ['tanggal_laporan', 'total_simpanan', 'total_setoran', 'total_penarikan', 'total_bunga'];
}
