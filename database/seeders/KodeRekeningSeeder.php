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
            [
                'module' => 'general',
                'nomor_rekening' => '1.1.0',
                'nama_rekening' => 'Kas',
                'deskripsi' => 'Akun kas utama',
                'parent_id' => null,
                'saldo_normal' => 'debit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module' => 'tabungan',
                'nomor_rekening' => '1.1.1',
                'nama_rekening' => 'Kas Tabungan',
                'deskripsi' => 'Kas yang berasal dari tabungan nasabah',
                'parent_id' => 1, // Mengacu ke ID Kas (1.1.0)
                'saldo_normal' => 'debit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module' => 'pinjaman',
                'nomor_rekening' => '1.2.0',
                'nama_rekening' => 'Piutang Pinjaman',
                'deskripsi' => 'Piutang dari pinjaman yang diberikan',
                'parent_id' => null,
                'saldo_normal' => 'debit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module' => 'operasional',
                'nomor_rekening' => '2.1.0',
                'nama_rekening' => 'Modal',
                'deskripsi' => 'Modal yang dimiliki perusahaan',
                'parent_id' => null,
                'saldo_normal' => 'kredit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
