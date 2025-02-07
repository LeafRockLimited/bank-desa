<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class NeracaBkd
{
    use HasFactory;

    protected static $kas_tunai = '1.1.01.01';
    protected static $bank = [
        '1.1.01.02',
        '1.1.01.03',
        '1.1.01.04',
        '1.1.01.05',
    ];
    protected static $harta_tetap = [];
    protected static $pinjaman_bkd_lain_aktiva = [];
    protected static $akumulasi_penyusutan = [];


    protected static $bank_pasiva = [];

    protected static $pinjaman_bkd_lain = [];
    protected static $pinjaman_lainnya = [];
    protected static $modal = [];
    protected static $rupa_pasiva = [];

    // Mengembalikan saldo kas dan antar bank dalam bentuk array
    public static function all($tahun = null, $bulan = null)
    {
        try {

            $aktiva = collect([
                'kas_tunai' => self::getSaldo(self::$kas_tunai, $tahun, $bulan),
                'antar_bank' => self::getSaldo(self::$bank, $tahun, $bulan),
                'pinjaman' => self::pinjaman($tahun, $bulan),
                'pinjaman_bkd_lain_aktiva' => self::getSaldo(self::$pinjaman_bkd_lain_aktiva, $tahun, $bulan),
                'harta_tetap' => self::getSaldo(self::$harta_tetap, $tahun, $bulan),
                'akumulasi_penyusutan' => self::getSaldo(self::$akumulasi_penyusutan, $tahun, $bulan)
            ]);

            $total_aktiva = $aktiva->sum();

            $pasiva = collect([
                'simpanan' => self::simpanan($tahun, $bulan),
                'antar_bank' => self::getSaldo(self::$bank_pasiva, $tahun, $bulan),
                'pinjaman_bkd_lain' => self::getSaldo(self::$pinjaman_bkd_lain, $tahun, $bulan),
                'pinjaman_lainnya' => self::getSaldo(self::$pinjaman_lainnya, $tahun, $bulan),
                'modal' => self::getSaldo(self::$modal, $tahun, $bulan),
                'rupa_pasiva' => self::getSaldo(self::$rupa_pasiva, $tahun, $bulan),
                'laba_rugi' => LabaRugiBkd::where('tahun', $tahun)->where('bulan', $bulan)->all()
            ]);

            $total_pasiva = $pasiva->map(function($item, $key) {
                if(is_object($item) || is_array($item)){
                    return $item['total'];

                }elseif (is_numeric($item) || is_string($item)) {
                    return $item;
                }else{
                   return 0;
                }
                return $item;
            })->sum();

            return (object) [
                'aktiva' => [...$aktiva, 'total' => $total_aktiva],
                'pasiva' => [...$pasiva, 'total' => $total_pasiva]
            ];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // Fungsi umum untuk mengambil saldo berdasarkan kode rekening
    protected static function getSaldo($rekening, $tahun = null, $bulan = null)
    {
        try {
            $kodeRekening = is_array($rekening) 
                            ? KodeRekening::whereIn('nomor_rekening', $rekening)->get() 
                            : KodeRekening::where('nomor_rekening', $rekening)->first();

            if (!isset($kodeRekening)) {
                return 0;
            }

            return Jurnal::whereIn('id_rekening', $kodeRekening->pluck('id'))
                ->when($tahun, function($query) use($tahun) {
                    return $query->whereYear('tanggal_transaksi', $tahun);
                })
                ->when($bulan, function($query) use($bulan) {
                    return $query->whereMonth('tanggal_transaksi', '<=', $bulan);
                })
                ->sum('jumlah');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function pinjaman($tahun = null, $bulan = null)
    {
        try {
            return Pinjaman::when($tahun, function($query) use($tahun) {
                return $query->whereYear('tanggal_disetujui', $tahun);
            })
            ->when($bulan, function($query) use($bulan) {
                return $query->whereMonth('tanggal_disetujui', '<=', $bulan);
            })
            ->sum('nominal_diterima');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function simpanan($tahun = null, $bulan = null)
    {
        try {
            return Simpanan::when($tahun, function($query) use($tahun) {
                return $query->whereYear('tanggal_setor', $tahun);
            })
            ->when($bulan, function($query) use($bulan) {
                return $query->whereMonth('tanggal_setor', '<=', $bulan);
            })
            ->sum('jumlah_simpanan');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
