<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabaRugiBkd
{
    use HasFactory;

    protected static $tahun;
    protected static $bulan;
    protected $data = [];
    protected static $instance;
    protected static $bungaGiro = [];
    protected static $bungaBritama = [];
    protected static $bungaSimpedes = [];
    protected static $pendapatanLainnya = [];
    protected static $pendapatanPinjamanPh = [];
    

    // pegeluaran
    protected static $biayaPengawasan = [];
    protected static $pinjamanBri = [];
    protected static $pinjamanBkdLain = [];
    protected static $bungaLainnya = [];
    protected static $bungaTabanas = [];
    protected static $gajiKomisi = [];
    protected static $gajiJtu = [];
    protected static $phAktivaTetap = [];
    protected static $penyisihanPhPinjaman = [];
    protected static $biayaLainnya = [];
    protected static $premiAsuransi = [];


    public static function where($key, $value)
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        if ($key == 'tahun') {
            self::$tahun = $value;
        } elseif ($key == 'bulan') {
            self::$bulan = $value;
        }

        return self::$instance;
    }

    public function all()
    {
        try {

            $bungaMingguan = self::bungaMingguan();
            $bungaBulanan = self::bungaBulanan();
            $bungaTahunan = self::bungaTahunan();
            $bungaMusiman = self::bungaMusiman();
            

            $bungaGiro = self::getSaldo(self::$bungaGiro, self::$tahun, self::$bulan);
            $bungaBritama = self::getSaldo(self::$bungaBritama, self::$tahun, self::$bulan);
            $bungaSimpedes = self::getSaldo(self::$bungaSimpedes, self::$tahun, self::$bulan);

            $pendapatanLainnya = self::getSaldo(self::$pendapatanLainnya, self::$tahun, self::$bulan);
            $pendapatanPinjPh = self::getSaldo(self::$pendapatanPinjamanPh, self::$tahun, self::$bulan);


            // pengeluaran 
            $bungaPengawasan = self::getSaldo(self::$biayaPengawasan, self::$tahun, self::$bulan);
            $bungaPinjamanBri = self::getSaldo(self::$pinjamanBri, self::$tahun, self::$bulan);
            $bungainjamanBkdLain = self::getSaldo(self::$pinjamanBkdLain, self::$tahun, self::$bulan);
            $bungaLainnya = self::getSaldo(self::$bungaLainnya, self::$tahun, self::$bulan);
            $bungaTabanas = self::getSaldo(self::$bungaTabanas, self::$tahun, self::$bulan);
            $gajiKomisi = self::getSaldo(self::$gajiKomisi, self::$tahun, self::$bulan);
            $gajiJtu = self::getSaldo(self::$gajiJtu, self::$tahun, self::$bulan);
            $phAktivaTetap = self::getSaldo(self::$phAktivaTetap, self::$tahun, self::$bulan);
            $penyisihanPhPinjaman = self::getSaldo(self::$penyisihanPhPinjaman, self::$tahun, self::$bulan);
            $biayaLainnya = self::getSaldo(self::$biayaLainnya, self::$tahun, self::$bulan);
            $premiAsuransi = self::getSaldo(self::$premiAsuransi, self::$tahun, self::$bulan);

            $bunga =  [
                'bunga_mingguan' => $bungaMingguan,
                'bunga_bulanan' => $bungaBulanan,
                'bunga_tahunan' => $bungaTahunan,
                'bunga_musiman' => $bungaMusiman,
                'jumlah' => $bungaMingguan + $bungaBulanan + $bungaTahunan + $bungaMusiman
            ];

            $giro = [
                'bunga_giro' => $bungaGiro,
                'bunga_britama' => $bungaBritama,
                'bunga_simpedes' => $bungaSimpedes,
                'jumlah' => $bungaGiro + $bungaBritama + $bungaSimpedes
            ];

            $pendapatanLainnya = [
                'pendapatan_lainnya' => $pendapatanLainnya,
                'pendaptan_pinj_ph' => $pendapatanPinjPh,
                'jumlah' => $pendapatanLainnya + $pendapatanPinjPh
            ];

            $totalPendapatan = $totalPendapatan = array_reduce(array_keys($bunga), function ($total, $key) use ($bunga) {
                if($key == 'jumlah') return $total;
                return $total + $bunga[$key];
            }, 0)
             + array_reduce(array_keys($giro), function ($total, $key) use ($giro) {
                if($key == 'jumlah') return $total;
                return $total + $giro[$key];
            }, 0)
            + array_reduce(array_keys($pendapatanLainnya), function ($total, $key) use ($pendapatanLainnya) {
                if($key == 'jumlah') return $total;
                return $total + $pendapatanLainnya[$key];
            }, 0);

            $pengeluaran =  [
                    'biaya_pengawasan' => $bungaPengawasan,
                    'bunga_pinjaman_bri' => $bungaPinjamanBri,
                    'bunga_pinjaman_bkd_lain' => $bungainjamanBkdLain,
                    'bunga_lainnya' => $bungaLainnya,
                    'bunga_tabanas' => $bungaTabanas,
                    'gaji_komisi' => $gajiKomisi,
                    'gaji_jtu' => $gajiJtu,
                    'ph_aktiva_tetap' => $phAktivaTetap,
                    'penyisihan_ph_pinjaman' => $penyisihanPhPinjaman,
                    'biaya_lainnya' => $biayaLainnya,
                    'premi_asuransi' => $premiAsuransi
            ];

            $totalPengeluaran = array_sum($pengeluaran);

            $this->data = [
                'pendapatan' => [
                    'bunga' => $bunga,
                    'giro' => $giro,
                    'pendapatan' => $pendapatanLainnya,
                    'total' => $totalPendapatan
                ],
                'pengeluaran' => [...$pengeluaran, 'total' => $totalPengeluaran],
                'total' => $totalPendapatan - $totalPengeluaran
            ];

            return $this->data; // Mengembalikan instance yang sudah memiliki data
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function bungaMingguan()
    {
        try {
            return Pinjaman::where('jenis_pinjaman', 'mingguan')
                ->when(self::$tahun, function ($query) {
                    return $query->whereYear('created_at', self::$tahun);
                })
                ->when(self::$bulan, function ($query) {
                    return $query->whereMonth('created_at', '<=', self::$bulan);
                })
                ->sum('nominal_bunga');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public static function bungaBulanan()
    {
        try {
            return Pinjaman::where('jenis_pinjaman', 'bulanan')
                ->when(self::$tahun, function ($query) {
                    return $query->whereYear('created_at', self::$tahun);
                })
                ->when(self::$bulan, function ($query) {
                    return $query->whereMonth('created_at', '<=', self::$bulan);
                })
                ->sum('nominal_bunga');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public static function bungaTahunan()
    {
        try {
            return Pinjaman::where('jenis_pinjaman', 'tahunan')
                ->when(self::$tahun, function ($query) {
                    return $query->whereYear('created_at', self::$tahun);
                })
                ->when(self::$bulan, function ($query) {
                    return $query->whereMonth('created_at', '<=', self::$bulan);
                })
                ->sum('nominal_bunga');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public static function bungaMusiman()
    {
        try {
            return Pinjaman::where('jenis_pinjaman', 'musiman')
                ->when(self::$tahun, function ($query) {
                    return $query->whereYear('created_at', self::$tahun);
                })
                ->when(self::$bulan, function ($query) {
                    return $query->whereMonth('created_at', '<=', self::$bulan);
                })
                ->sum('nominal_bunga');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function sum()
    {
        
        return array_sum($this->all());
    }

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
}

