<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BukuBesar extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_kode_rekening', 'keterangan' ,'tanggal', 'debit', 'kredit', 'saldo'
    ];

    public function kodeRekening()
    {
        return $this->belongsTo(KodeRekening::class, 'id_kode_rekening');
    }

     /**
     * Boot function for the model to handle creating and updating events
     */
    public static function boot()
    {
        parent::boot();

        // Ketika membuat transaksi baru
        static::creating(function ($bukuBesar) {
            // Hitung saldo untuk transaksi baru
            $bukuBesar->calculateNewTransactionSaldo();
        });

        // Ketika memperbarui transaksi yang sudah ada
        static::updating(function ($bukuBesar) {
            // Hitung saldo ketika transaksi diperbarui
            $bukuBesar->adjustSaldoForUpdatedTransaction();
        });
    }

    /**
     * Menghitung saldo untuk transaksi baru
     */
    public function calculateNewTransactionSaldo()
    {
        // Ambil transaksi terakhir dari kode rekening yang sama
        $lastTransaction = BukuBesar::where('id_kode_rekening', $this->id_kode_rekening)
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();

        // Saldo terakhir dari transaksi sebelumnya (0 jika tidak ada transaksi sebelumnya)
        $previousSaldo = $lastTransaction ? $lastTransaction->saldo : 0;

        // Saldo baru dihitung berdasarkan debit dan kredit yang ditambahkan
        $this->saldo = $previousSaldo + $this->debit - $this->kredit;
    }

    /**
     * Menghitung saldo ketika transaksi diperbarui
     */
    public function adjustSaldoForUpdatedTransaction()
    {
        // Ambil data transaksi sebelum diupdate
        $originalTransaction = self::find($this->id);

        // Ambil saldo transaksi terakhir (sebelum transaksi yang diupdate)
        $lastTransaction = BukuBesar::where('id_kode_rekening', $this->id_kode_rekening)
            ->where('id', '<>', $this->id) // Mengambil selain transaksi yang diupdate
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();

        // Saldo dari transaksi sebelum transaksi yang sedang diupdate
        $previousSaldo = $lastTransaction ? $lastTransaction->saldo : 0;

        // Hitung perbedaan saldo dengan nilai debit dan kredit sebelumnya
        $saldoAdjustment = ($this->debit - $this->kredit);

        // Update saldo berdasarkan saldo sebelumnya ditambah perubahan transaksi baru
        $this->saldo = $previousSaldo + $saldoAdjustment;
    }

}
