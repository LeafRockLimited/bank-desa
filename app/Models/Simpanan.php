<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    use HasFactory;
    protected $fillable = ['nasabah_id', 'rekening_simpanan' ,'jenis_simpanan_id', 'tanggal_buka', 'saldo_awal', 'saldo_terkini', 'status_simpanan'];

    protected $casts = [
        'rekening_simpanan' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        // Event sebelum menyimpan data baru atau mengupdate
        static::saving(function ($simpanan) {
            if ($simpanan->exists && $simpanan->getOriginal('status_simpanan') === 'Tutup') {
                throw new \Exception("Transaksi tidak dapat dilakukan karena status simpanan sudah Tutup.");
            }

            if ($simpanan->isDormant()) {
                throw new \Exception("Rekening dalam status Dormant. Tidak dapat melakukan transaksi.");
            }
        });

        static::updating(function ($simpanan) {
            if ($simpanan->status_simpanan === 'Tutup') {
                throw new \Exception("Tidak dapat mengubah simpanan, karena statusnya sudah Tutup.");
            }

            if ($simpanan->isDormant()) {
                throw new \Exception("Rekening dalam status Dormant. Tidak dapat melakukan transaksi.");
            }
        });
    }



    
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function jenisSimpanan()
    {
        return $this->belongsTo(JenisSimpanan::class);
    }

    public function transaksi()
    {
        return $this->hasMany(TransaksiSimpanan::class);
    }

    public function bunga()
    {
        return $this->hasMany(BungaSimpanan::class);
    }

    public function bisa_dicairkan(){
        return $this->jenisSimpanan->bisa_dicairkan;
    }

    /**
     * Periksa apakah rekening sudah dalam status Dormant
     *
     * @return bool
     */
    public function isDormant()
    {
        $lastTransaction = $this->transaksi()->latest('created_at')->first();

        if (!$lastTransaction) {
            // Jika tidak ada transaksi sama sekali sejak dibuka, gunakan tanggal_buka
            $lastActivityDate = Carbon::parse($this->tanggal_buka);
        } else {
            $lastActivityDate = Carbon::parse($lastTransaction->created_at);
        }

        return $lastActivityDate->diffInMonths(Carbon::now()) >= 6;
    }
}
