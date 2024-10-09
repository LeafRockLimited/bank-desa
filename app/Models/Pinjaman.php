<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;
    protected $table = 'pinjamans';

    public $slug = 'pinjaman';

    protected $fillable = [
        'nasabah_id',
        'jenis_pinjaman',
        'jumlah_pinjaman',
        'bunga',
        'tanggal_pengajuan',
        'tanggal_disetujui',
        'tanggal_jatuh_tempo',
        'status_pinjaman',
        'nominal_diterima'
    ];

    public function getMappedNasabahAttribute()
    {
        if ($this->nasabah) {
            return (object) [
                'code' => $this->nasabah->id,
                'label' => $this->nasabah->nama_lengkap,
            ];
        }
        return null;
    }

    public function nasabah(){
        return $this->belongsTo(Nasabah::class,'nasabah_id','id');
    }

    public function angsuran()
    {
        return $this->hasMany(Angsuran::class, 'pinjaman_id');
    }

    public function getLastAngsuranAttribute()
    {
        return $this->angsuran()->orderBy('created_at', 'desc')->first();
    }

    public function agunans()
    {
        return $this->hasMany(Agunan::class, 'pinjaman_id');
    }
}
