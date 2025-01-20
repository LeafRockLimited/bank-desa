<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Arus Kas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            font-weight: bold;
            font-size: 16px;
            text-align: center;
        }
    </style>
</head>
<body>
<h2 class="header">Laporan Arus Kas</h2>
<h3>Tahun: {{ $tahun }}, Bulan: {{ $bulan }}</h3>

<table>
    <tr>
        <th>ARUS KAS DARI AKTIVITAS OPERASI</th>
        <th></th>
    </tr>
    <tr>
        <th>Arus Kas Masuk</th>
        <th></th>
    </tr>
    <tr>
        <td>Penerimaan kas dari penjualan jasa</td>
        <td>Rp {{ number_format($arusKasMasukOperasi['penerimaanJasa'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Penerimaan kas dari penjualan barang dagangan</td>
        <td>Rp {{ number_format($arusKasMasukOperasi['penerimaanDagang'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Penerimaan kas dari penjualan barang jadi</td>
        <td>Rp {{ number_format($arusKasMasukOperasi['penerimaanBarangJadi'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Penerimaan kas dari bunga bank</td>
        <td>Rp {{ number_format($arusKasMasukOperasi['penerimaanBungaBank'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td><strong>Jumlah arus kas masuk dari aktivitas operasi</strong></td>
        <td><strong>Rp {{ number_format($jumlahKasMasukOperasi, 0, ',', '.') }}</strong></td>
    </tr>

    <tr>
        <th>Arus Kas Keluar</th>
        <th></th>
    </tr>
    <tr>
        <td>Pengeluaran kas untuk pembayaran ke pemasok barang</td>
        <td>Rp {{ number_format($arusKasKeluarOperasi['pembayaranPemasok'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Pengeluaran kas untuk pembayaran gaji/upah pegawai/karyawan</td>
        <td>Rp {{ number_format($arusKasKeluarOperasi['pembayaranGaji'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Pengeluaran kas untuk pembayaran pajak</td>
        <td>Rp {{ number_format($arusKasKeluarOperasi['pembayaranPajak'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Pengeluaran kas untuk pembayaran bunga</td>
        <td>Rp {{ number_format($arusKasKeluarOperasi['pembayaranBunga'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Pengeluaran kas untuk pembayaran beban-beban yang lain</td>
        <td>Rp {{ number_format($arusKasKeluarOperasi['pembayaranBebanLain'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td><strong>Jumlah arus kas keluar dari aktivitas operasi</strong></td>
        <td><strong>Rp {{ number_format($jumlahKasKeluarOperasi, 0, ',', '.') }}</strong></td>
    </tr>
    <tr>
        <th>Arus Kas Bersih dari Aktivitas Operasi</th>
        <td>Rp {{ number_format($arusKasBersihOperasi, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <th>ARUS KAS DARI AKTIVITAS INVESTASI</th>
        <th></th>
    </tr>
    <tr>
        <th>Arus Kas Masuk</th>
        <th></th>
    </tr>
    <tr>
        <td>Penerimaan kas dari penjualan Aset Tetap</td>
        <td>Rp {{ number_format($arusKasMasukInvestasi['penerimaanAsetTetap'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Penerimaan kas dari penjualan Investasi</td>
        <td>Rp {{ number_format($arusKasMasukInvestasi['penerimaanInvestasi'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td><strong>Jumlah arus kas masuk dari aktivitas Investasi</strong></td>
        <td><strong>Rp {{ number_format($jumlahKasMasukInvestasi, 0, ',', '.') }}</strong></td>
    </tr>
    <tr>
        <th>Arus Kas Keluar</th>
        <th></th>
    </tr>
    <tr>
        <td>Pengeluaran kas untuk pembelian Aset Tetap</td>
        <td>Rp {{ number_format($arusKasKeluarInvestasi['pembelianAsetTetap'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Pengeluaran kas untuk Pembelian Investasi</td>
        <td>Rp {{ number_format($arusKasKeluarInvestasi['pembelianInvestasi'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td><strong>Jumlah arus kas keluar dari aktivitas Investasi</strong></td>
        <td><strong>Rp {{ number_format($jumlahKasKeluarInvestasi, 0, ',', '.') }}</strong></td>
    </tr>
    <tr>
        <td>Arus Kas Bersih dari Aktivitas Investasi</td>
        <td>Rp {{ number_format($arusKasBersihInvestasi, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <th>ARUS KAS DARI AKTIVITAS PEMBIAYAAN</th>
        <th></th>
    </tr>
    <tr>
        <th>Arus Kas Masuk</th>
        <th></th>
    </tr>
    <tr>
        <td>Penerimaan kas dari penyertaan modal desa</td>
        <td>Rp {{ number_format($arusKasMasukPembiayaan['penerimaanModalDesa'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Penerimaan kas dari penyertaan modal masyarakat</td>
        <td>Rp {{ number_format($arusKasMasukPembiayaan['penerimaanModalMasyarakat'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Penerimaan kas dari Donasi/Sumbangan</td>
        <td>Rp {{ number_format($arusKasMasukPembiayaan['penerimaanDonasi'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Penerimaan kas dari utang jangka panjang</td>
        <td>Rp {{ number_format($arusKasMasukPembiayaan['penerimaanJangkaPanjang'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td><strong>Jumlah arus kas masuk dari aktivitas Pembiayaan</strong></td>
        <td><strong>Rp {{ number_format($jumlahKasMasukPembiayaan, 0, ',', '.') }}</strong></td>
    </tr>
    <tr>
        <th>Arus Kas Keluar</th>
        <th></th>
    </tr>
    <tr>
        <td>Pembayaran bagi hasil penyertaan modal desa</td>
        <td>Rp {{ number_format($arusKasKeluarPembiayaan['pembayaranBagiHasilModalDesa'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Pembayaran bagi hasil penyertaan modal masyarakat</td>
        <td>Rp {{ number_format($arusKasKeluarPembiayaan['pembayaranBagiHasilModalMasyarakat'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Pembayaran pokok utang jangka panjang</td>
        <td>Rp {{ number_format($arusKasKeluarPembiayaan['pembayaranUtangJangkaPanjang'], 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td><strong>Jumlah arus kas keluar dari aktivitas Pembiayaan</strong></td>
        <td><strong>Rp {{ number_format($jumlahKasKeluarPembiayaan, 0, ',', '.') }}</strong></td>
    </tr>
    <tr>
        <td>Arus Kas Bersih dari Aktivitas Pembiayaan</td>
        <td>Rp {{ number_format($arusKasBersihPembiayaan, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
<tr>
    <td>Kenaikan (Penurunan) Kas</td>
    <td>Rp {{ number_format($kenaikanKas, 0, ',', '.') }}</td>
</tr>
    <tr>
<td>Saldo Kas Awal</td>
    <td>Rp {{ number_format($saldoKasAwal, 0, ',', '.') }}</td>

    </tr>
    <tr>
        <th>Saldo Kas Akhir</th>
        <th>Rp {{ number_format($saldoKasAkhir, 0, ',', '.') }}</th>

    </tr>
</table>



</body>
</html>
