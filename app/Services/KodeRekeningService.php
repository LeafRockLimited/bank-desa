<?php
namespace App\Services;

use App\Models\KodeRekening;

class KodeRekeningService {
    protected static $module = null;

    /**
     * Set module untuk transaksi
     */
    public static function setModule(string $module)
    {
        self::$module = $module;
        return new static;
    }

    /**
     * Get daftar kode rekening berdasarkan module
     */
    public static function getModule(string $module)
    {
        return KodeRekening::where('module', $module)->get();
    }

    /**
     * Ambil atau buat Kode Rekening berdasarkan kode
     */
    public function code(string $code)
    {
        return KodeRekening::firstOrCreate([
            'module' => self::$module,
            'nomor_rekening' => $code
        ], [
            'nama_rekening' => 'Unknown', // Default jika belum ada
            'deskripsi' => '',
            'saldo_normal' => 'debit'
        ]);
    }

    /**
     * Tambah transaksi debit
     */
    public function debit(float $amount)
    {
        return $this->updateSaldo('debit', $amount);
    }

    /**
     * Tambah transaksi kredit
     */
    public function kredit(float $amount)
    {
        return $this->updateSaldo('kredit', $amount);
    }

    /**
     * Update saldo berdasarkan jenis transaksi
     */
    private function updateSaldo(string $type, float $amount)
    {
        $rekening = KodeRekening::where('module', self::$module)->first();
        if (!$rekening) {
            throw new \Exception("Kode Rekening untuk module " . self::$module . " tidak ditemukan.");
        }

        // Logika saldo normal
        if ($rekening->saldo_normal == 'debit' && $type == 'debit') {
            $rekening->total_debit += $amount;
        } elseif ($rekening->saldo_normal == 'kredit' && $type == 'kredit') {
            $rekening->total_kredit += $amount;
        } else {
            $rekening->total_debit -= $amount; // Koreksi jika saldo normal berbeda
        }

        $rekening->save();
        return $rekening;
    }
}