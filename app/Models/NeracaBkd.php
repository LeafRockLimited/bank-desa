<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class NeracaBkd
{
    use HasFactory;

    /**
     *aktiva:
        - kas_tunai
        - antar_bank
        - pinjaman
        - piutang
        - investasi
        - harta_tetap
        - akumulasi_penyusutan

    *pasiva:
        - simpanan
        - utang_bank
        - utang_lainnya
        - modal
        - laba_rugi
     */

    protected static $kas_tunai = ['1.1.01.01','1.1.01.06'];
    protected static $bank = [
        '1.1.01.02',
        '1.1.01.03',
        '1.1.01.04',
        '1.1.01.05',
    ];
    protected static $harta_tetap = ['1.3.01.01','1.3.02.01','1.3.03.01','1.3.04.01','1.3.05.01'];
    protected static $pinjaman_bkd_lain_aktiva = ['1.1.03.99'];
    protected static $akumulasi_penyusutan = ['1.3.07.01','1.3.07.02','1.3.07.03','1.3.07.04'];


    protected static $bank_pasiva = ['2.1.05.99','2.2.99.99'];

    protected static $pinjaman_bkd_lain = [];
    protected static $pinjaman_lainnya = [];
    protected static $modal = ['3.1.01.01', '3.1.02.01'];
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
                'simpanan' => self::tabungan($tahun, $bulan),
                'antar_bank' => self::getSaldo(self::$bank_pasiva, $tahun, $bulan),
                'pinjaman_bkd_lain' => self::getSaldo(self::$pinjaman_bkd_lain, $tahun, $bulan),
                'pinjaman_lainnya' => self::getSaldo(self::$pinjaman_lainnya, $tahun, $bulan),
                'modal' => self::getSaldo(self::$modal, $tahun, $bulan),
                'rupa_pasiva' => self::getSaldo(self::$rupa_pasiva, $tahun, $bulan),
                'laba_rugi' => LabaRugiBkd::where('tahun', $tahun)->where('bulan', $bulan)->all()
            ]);

            $total_pasiva = $pasiva->map(function ($item) {
                if (is_array($item) && isset($item['total'])) {
                    return (float) $item['total'];
                }
            
                if (is_object($item) && isset($item->total)) {
                    return (float) $item->total;
                }
            
                if (is_numeric($item)) {
                    return (float) $item;
                }
            
                return 0;
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

            if (is_null($kodeRekening) || (is_array($rekening) && $kodeRekening->isEmpty())) {
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

    public static function tabungan($tahun = null, $bulan = null){
        try {
            return TransaksiSimpanan::when($tahun, function($query) use($tahun) {
                return $query->whereYear('tanggal_transaksi', $tahun);
            })
            ->when($bulan, function($query) use($bulan) {
                return $query->whereMonth('tanggal_transaksi', '<=', $bulan);
            })
            ->sum('nominal');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    
}
