<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BungaSimpanan extends Model
{
    use HasFactory;
    protected $table = 'simpanan_bungas';
    protected $fillable = ['simpanan_id', 'tanggal_perhitungan', 'persentase_bunga', 'nominal_bunga'];

    public function simpanan()
    {
        return $this->belongsTo(Simpanan::class);
    }
}
