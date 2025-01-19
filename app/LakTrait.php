<?php

namespace App;

use App\Models\Jurnal;
use App\Models\KodeRekening;
use App\Models\Neraca;
use Illuminate\Support\Facades\DB;

trait LakTrait
{
    public function generateLak(int $tahun, int $bulan){
        $this->tahun = $tahun;
        $this->bulan = $bulan;

        // Arus Kas Masuk dari Aktivitas Operasi
        $arusKasMasukOperasi = [
            'penerimaanJasa' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), 'penerimaan kas dari penjualan jasa')
                ->sum('jumlah'),

            'penerimaanDagang' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), 'penerimaan kas dari penjualan barang dagangan')
                ->sum('jumlah'),

            'penerimaanBarangJadi' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), 'penerimaan kas dari penjualan barang jadi')
                ->sum('jumlah'),

            'penerimaanBarangDanJedi' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), 'penerimaan kas dari bunga dan deviden')
                ->sum('jumlah'),

            'penerimaanBungaBank' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), 'penerimaan kas dari bunga bank')
                ->sum('jumlah'),
        ];

// Jumlah Arus Kas Masuk dari Aktivitas Operasi
        $jumlahKasMasukOperasi = array_sum($arusKasMasukOperasi);

// Arus Kas Keluar dari Aktivitas Operasi
        $arusKasKeluarOperasi = [
            'pembayaranPemasok' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Pengeluaran kas untuk pembayaran ke pemasok barang'))
                ->sum('jumlah'),
            'pembayaranGaji' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Pengeluaran kas untuk pembayaran gaji/upah pegawai/karyawan'))
                ->sum('jumlah'),
            'pembayaranPajak' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Pengeluaran kas untku pembayaran pajak'))
                ->sum('jumlah'),
            'pembayaranBunga' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Pengeluaran kas untuk pembayaran bunga'))
                ->sum('jumlah'),
            'pembayaranBebanLain' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi', '<=' ,$bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Pengeluaran kas untuk pembayaran beban-beban yang lain'))
                ->sum('jumlah')
        ];

// Jumlah Arus Kas Keluar dari Aktivitas Operasi
        $jumlahKasKeluarOperasi = array_sum($arusKasKeluarOperasi);

// Arus Kas Bersih dari Aktivitas Operasi
        $arusKasBersihOperasi = $jumlahKasMasukOperasi + $jumlahKasKeluarOperasi;

// Arus Kas Masuk dari Aktivitas Investasi
        $arusKasMasukInvestasi = [
            'penerimaanAsetTetap' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Penerimaan Kas dari Penjualan Aset Tetap'))
                ->sum('jumlah'),
            'penerimaanInvestasi' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Penerimaan Kas dari Penjualan Investasi'))
                ->sum('jumlah'),
        ];

// Jumlah Arus Kas Masuk dari Aktivitas Investasi
        $jumlahKasMasukInvestasi = array_sum($arusKasMasukInvestasi);

// Arus Kas Keluar dari Aktivitas Investasi
        $arusKasKeluarInvestasi = [
            'pembelianAsetTetap' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Pengeluaran Kas untuk Pembelian Aset Tetap'))
                ->sum('jumlah'),
            'pembelianInvestasi' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Pengeluaran Kas untuk Pembelian Investasi'))
                ->sum('jumlah'),
        ];

// Jumlah Arus Kas Keluar dari Aktivitas Investasi
        $jumlahKasKeluarInvestasi = array_sum($arusKasKeluarInvestasi);

// Arus Kas Bersih dari Aktivitas Investasi
        $arusKasBersihInvestasi = $jumlahKasMasukInvestasi + $jumlahKasKeluarInvestasi;

// Arus Kas Masuk dari Aktivitas Pembiayaan
        $arusKasMasukPembiayaan = [
            'penerimaanModalDesa' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Penerimaan kas dari penyertaan modal desa'))
                ->sum('jumlah'),
            'penerimaanModalMasyarakat' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Penerimaan kas dari penyertaan modal masyarakat'))
                ->sum('jumlah'),
            'penerimaanDonasi' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Penerimaan kas dari Donasi/Sumbangan'))
                ->sum('jumlah'),
            'penerimaanJangkaPanjang' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Penerimaan kas dari utang jangka panjang'))
                ->sum('jumlah'),
        ];

// Jumlah Arus Kas Masuk dari Aktivitas Pembiayaan
        $jumlahKasMasukPembiayaan = array_sum($arusKasMasukPembiayaan);

// Arus Kas Keluar dari Aktivitas Pembiayaan
        $arusKasKeluarPembiayaan = [
            'pembayaranBagiHasilModalDesa' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Pembayaran bagi hasil penyertaan modal desa'))
                ->sum('jumlah'),
            'pembayaranBagiHasilModalMasyarakat' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Pembayaran bagi hasil penyertaan modal masyarakat'))
                ->sum('jumlah'),
            'pembayaranUtangJangkaPanjang' => Jurnal::whereYear('tanggal_transaksi', '<=' , $tahun)
                ->whereMonth('tanggal_transaksi' , $bulan)
                ->where(DB::raw('LOWER(komponen_lak)'), strtolower('Pembayaran pokok utang jangka panjang'))
                ->sum('jumlah'),
        ];

// Jumlah Arus Kas Keluar dari Aktivitas Pembiayaan
        $jumlahKasKeluarPembiayaan = array_sum($arusKasKeluarPembiayaan);

// Arus Kas Bersih dari Aktivitas Pembiayaan
        $arusKasBersihPembiayaan = $jumlahKasMasukPembiayaan + $jumlahKasKeluarPembiayaan;


  $rekeningData = KodeRekening::where('level_one','1')
      ->where('level_two','1')
      ->where('level_three','01')
      ->pluck('id')
    ->toArray();

// Kenaikan (Penurunan) Kas
        $kenaikanKas = $arusKasBersihInvestasi + $arusKasBersihOperasi + $arusKasBersihPembiayaan; // Kenaikan kas
        $saldoKasAwal =Neraca::whereIn('id_rekening', $rekeningData)
            ->where('tahun', $tahun)
            ->where('bulan', '<=', $bulan)
            ->sum('jumlah'); // Saldo kas awal tahun
        $saldoKasAkhir = $kenaikanKas + $saldoKasAwal; // Saldo kas akhir tahun

        return [
            'arusKasMasukOperasi' => $arusKasMasukOperasi,
            'jumlahKasMasukOperasi' => $jumlahKasMasukOperasi,
            'arusKasKeluarOperasi' => $arusKasKeluarOperasi,
            'jumlahKasKeluarOperasi' => $jumlahKasKeluarOperasi,
            'arusKasBersihOperasi' => $arusKasBersihOperasi,
            'arusKasMasukInvestasi' => $arusKasMasukInvestasi,
            'jumlahKasMasukInvestasi' => $jumlahKasMasukInvestasi,
            'arusKasKeluarInvestasi' => $arusKasKeluarInvestasi,
            'jumlahKasKeluarInvestasi' => $jumlahKasKeluarInvestasi,
            'arusKasBersihInvestasi' => $arusKasBersihInvestasi,
            'arusKasMasukPembiayaan' => $arusKasMasukPembiayaan,
            'jumlahKasMasukPembiayaan' => $jumlahKasMasukPembiayaan,
            'arusKasKeluarPembiayaan' => $arusKasKeluarPembiayaan,
            'jumlahKasKeluarPembiayaan' => $jumlahKasKeluarPembiayaan,
            'arusKasBersihPembiayaan' => $arusKasBersihPembiayaan,
            'kenaikanKas' => $kenaikanKas,
            'saldoKasAwal' => $saldoKasAwal,
            'saldoKasAkhir' => $saldoKasAkhir,
        ];
    }
}
