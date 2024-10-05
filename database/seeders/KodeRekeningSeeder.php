<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KodeRekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kode_rekenings')->insert([
            // Kas
            [
                'jenis_rekening_id' => 1,
                'nomor_rekening' => '1001',
                'nama_rekening' => 'Kas Umum',
                'tipe' => 'pendapatan',
                'sub_tipe' => 'kas',
                'status' => 'aktif',
                'deskripsi' => 'Kas utama untuk transaksi umum',
            ],
            [
                'jenis_rekening_id' => 1,
                'nomor_rekening' => '1002',
                'nama_rekening' => 'Kas Kecil',
                'tipe' => 'pengeluaran',
                'sub_tipe' => 'kas kecil',
                'status' => 'aktif',
                'deskripsi' => 'Kas kecil untuk pengeluaran harian',
            ],

            // Tabungan Anggota
            [
                'jenis_rekening_id' => 2,
                'nomor_rekening' => '2001',
                'nama_rekening' => 'Tabungan Anggota Reguler',
                'tipe' => 'pembiayaan',
                'sub_tipe' => 'tabungan anggota',
                'status' => 'aktif',
                'deskripsi' => 'Tabungan dasar untuk anggota',
            ],

            // Simpanan Pokok
            [
                'jenis_rekening_id' => 3,
                'nomor_rekening' => '3001',
                'nama_rekening' => 'Simpanan Pokok Anggota',
                'tipe' => 'pembiayaan',
                'sub_tipe' => 'simpanan pokok',
                'status' => 'aktif',
                'deskripsi' => 'Simpanan pokok wajib anggota',
            ],

            // Simpanan Wajib
            [
                'jenis_rekening_id' => 4,
                'nomor_rekening' => '3002',
                'nama_rekening' => 'Simpanan Wajib',
                'tipe' => 'pembiayaan',
                'sub_tipe' => 'simpanan wajib',
                'status' => 'aktif',
                'deskripsi' => 'Simpanan wajib bulanan',
            ],

            // Simpanan Sukarela
            [
                'jenis_rekening_id' => 5,
                'nomor_rekening' => '3003',
                'nama_rekening' => 'Simpanan Sukarela',
                'tipe' => 'pembiayaan',
                'sub_tipe' => 'simpanan sukarela',
                'status' => 'aktif',
                'deskripsi' => 'Simpanan tambahan anggota',
            ],

            // Pinjaman Anggota
            [
                'jenis_rekening_id' => 6,
                'nomor_rekening' => '4001',
                'nama_rekening' => 'Pinjaman Anggota',
                'tipe' => 'pembiayaan',
                'sub_tipe' => 'pinjaman anggota',
                'status' => 'aktif',
                'deskripsi' => 'Pinjaman diberikan kepada anggota',
            ],

            // Bunga Pinjaman
            [
                'jenis_rekening_id' => 7,
                'nomor_rekening' => '4002',
                'nama_rekening' => 'Bunga Pinjaman',
                'tipe' => 'pendapatan',
                'sub_tipe' => 'bunga pinjaman',
                'status' => 'aktif',
                'deskripsi' => 'Pendapatan dari bunga pinjaman',
            ],

            // Pendapatan Lain-lain
            [
                'jenis_rekening_id' => 8,
                'nomor_rekening' => '5001',
                'nama_rekening' => 'Pendapatan Lain-lain',
                'tipe' => 'pendapatan',
                'sub_tipe' => 'pendapatan lainnya',
                'status' => 'aktif',
                'deskripsi' => 'Pendapatan dari sumber lain-lain',
            ],

            // Beban Operasional
            [
                'jenis_rekening_id' => 9,
                'nomor_rekening' => '6001',
                'nama_rekening' => 'Beban Operasional',
                'tipe' => 'pengeluaran',
                'sub_tipe' => 'operasional',
                'status' => 'aktif',
                'deskripsi' => 'Biaya operasional harian',
            ],

            // Cadangan Kerugian
            [
                'jenis_rekening_id' => 10,
                'nomor_rekening' => '7001',
                'nama_rekening' => 'Cadangan Kerugian',
                'tipe' => 'pengeluaran',
                'sub_tipe' => 'cadangan kerugian',
                'status' => 'aktif',
                'deskripsi' => 'Dana cadangan untuk kerugian',
            ],

            // Investasi
            [
                'jenis_rekening_id' => 11,
                'nomor_rekening' => '8001',
                'nama_rekening' => 'Investasi Jangka Panjang',
                'tipe' => 'pendapatan',
                'sub_tipe' => 'investasi',
                'status' => 'aktif',
                'deskripsi' => 'Investasi jangka panjang',
            ],

            // Pendapatan Jasa
            [
                'jenis_rekening_id' => 12,
                'nomor_rekening' => '8002',
                'nama_rekening' => 'Pendapatan Jasa',
                'tipe' => 'pendapatan',
                'sub_tipe' => 'jasa',
                'status' => 'aktif',
                'deskripsi' => 'Pendapatan dari jasa layanan simpan pinjam',
            ],

            // Tabungan Berjangka
            [
                'jenis_rekening_id' => 13,
                'nomor_rekening' => '3004',
                'nama_rekening' => 'Tabungan Berjangka',
                'tipe' => 'pembiayaan',
                'sub_tipe' => 'tabungan berjangka',
                'status' => 'aktif',
                'deskripsi' => 'Tabungan dengan jangka waktu tertentu',
            ],

            // Rekening Cadangan
            [
                'jenis_rekening_id' => 14,
                'nomor_rekening' => '7002',
                'nama_rekening' => 'Rekening Cadangan Umum',
                'tipe' => 'pengeluaran',
                'sub_tipe' => 'cadangan umum',
                'status' => 'aktif',
                'deskripsi' => 'Dana cadangan umum',
            ],

            // Modal Koperasi
            [
                'jenis_rekening_id' => 15,
                'nomor_rekening' => '9001',
                'nama_rekening' => 'Modal Koperasi',
                'tipe' => 'pendapatan',
                'sub_tipe' => 'modal',
                'status' => 'aktif',
                'deskripsi' => 'Modal pokok koperasi',
            ],

            // Pendapatan Administrasi
            [
                'jenis_rekening_id' => 16,
                'nomor_rekening' => '5002',
                'nama_rekening' => 'Pendapatan Administrasi',
                'tipe' => 'pendapatan',
                'sub_tipe' => 'administrasi',
                'status' => 'aktif',
                'deskripsi' => 'Pendapatan dari biaya administrasi',
            ],

            // Beban Penyusutan Aset
            [
                'jenis_rekening_id' => 17,
                'nomor_rekening' => '6002',
                'nama_rekening' => 'Beban Penyusutan Aset',
                'tipe' => 'pengeluaran',
                'sub_tipe' => 'penyusutan aset',
                'status' => 'aktif',
                'deskripsi' => 'Beban penyusutan aset tetap',
            ],

            // Pembayaran Pinjaman
            [
                'jenis_rekening_id' => 18,
                'nomor_rekening' => '4003',
                'nama_rekening' => 'Pembayaran Pinjaman',
                'tipe' => 'pengeluaran',
                'sub_tipe' => 'pembayaran pinjaman',
                'status' => 'aktif',
                'deskripsi' => 'Pembayaran angsuran pinjaman',
            ],

            // Pendapatan Bunga Simpanan
            [
                'jenis_rekening_id' => 19,
                'nomor_rekening' => '5003',
                'nama_rekening' => 'Pendapatan Bunga Simpanan',
                'tipe' => 'pendapatan',
                'sub_tipe' => 'bunga simpanan',
                'status' => 'aktif',
                'deskripsi' => 'Pendapatan bunga dari simpanan',
            ],

            // Biaya Lain-lain
            [
                'jenis_rekening_id' => 20,
                'nomor_rekening' => '6003',
                'nama_rekening' => 'Biaya Lain-lain',
                'tipe' => 'pengeluaran',
                'sub_tipe' => 'biaya lainnya',
                'status' => 'aktif',
                'deskripsi' => 'Biaya yang tidak termasuk kategori lain',
            ],
        ]);
    }
}
