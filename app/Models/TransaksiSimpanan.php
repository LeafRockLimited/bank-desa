<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSimpanan extends Model
{
    use HasFactory;
    protected $table = 'simpanan_transaksis';
    protected $fillable = ['simpanan_id', 'jenis_transaksi', 'nominal', 'tanggal_transaksi', 'keterangan'];

    public function simpanan()
    {
        return $this->belongsTo(Simpanan::class);
    }
}
