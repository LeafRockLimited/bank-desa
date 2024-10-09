<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisRekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_rekenings')->insert([
            ['id_jenis' => 1, 'nama' => 'Kas'],
            ['id_jenis' => 2, 'nama' => 'Tabungan Anggota'],
            ['id_jenis' => 3, 'nama' => 'Simpanan Pokok'],
            ['id_jenis' => 4, 'nama' => 'Simpanan Wajib'],
            ['id_jenis' => 5, 'nama' => 'Simpanan Sukarela'],
            ['id_jenis' => 6, 'nama' => 'Pinjaman Anggota'],
            ['id_jenis' => 7, 'nama' => 'Bunga Pinjaman'],
            ['id_jenis' => 8, 'nama' => 'Pendapatan Lain-lain'],
            ['id_jenis' => 9, 'nama' => 'Beban Operasional'],
            ['id_jenis' => 10, 'nama' => 'Cadangan Kerugian'],
            ['id_jenis' => 11, 'nama' => 'Investasi'],
            ['id_jenis' => 12, 'nama' => 'Pendapatan Jasa'],
            ['id_jenis' => 13, 'nama' => 'Tabungan Berjangka'],
            ['id_jenis' => 14, 'nama' => 'Rekening Cadangan'],
            ['id_jenis' => 15, 'nama' => 'Modal Koperasi'],
            ['id_jenis' => 16, 'nama' => 'Pendapatan Administrasi'],
            ['id_jenis' => 17, 'nama' => 'Beban Penyusutan Aset'],
            ['id_jenis' => 18, 'nama' => 'Pembayaran Pinjaman'],
            ['id_jenis' => 19, 'nama' => 'Pendapatan Bunga Simpanan'],
            ['id_jenis' => 20, 'nama' => 'Biaya Lain-lain'],
        ]);
    }
}
