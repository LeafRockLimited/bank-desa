<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pinjaman_id',
        'tanggal_bayar',
        'jumlah_bayar',
        'bunga',
        'sisa_pinjaman',
    ];

    public $slug = 'angsuran';

    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
           
        });
    }

    public function pinjaman(){
        return $this->belongsTo(Pinjaman::class,'pinjaman_id','id');
    }

    public function nasabah(){
        return $this->hasOneThrough(Nasabah::class,Pinjaman::class,'id','id','pinjaman_id','nasabah_id');
    }
}
