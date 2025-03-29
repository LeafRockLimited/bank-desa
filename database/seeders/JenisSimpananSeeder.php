<?php

namespace Database\Seeders;

use App\Models\JenisSimpanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSimpananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisSimpanan = [
            ['nama_jenis_simpanan' => 'Simpanan Pokok', 'minimal_setoran' => 100000, 'bunga_simpanan' => 0],
            ['nama_jenis_simpanan' => 'Simpanan Wajib', 'minimal_setoran' => 50000, 'bunga_simpanan' => 0],
            ['nama_jenis_simpanan' => 'Simpanan Sukarela', 'minimal_setoran' => 10000, 'bunga_simpanan' => 2.5],
            ['nama_jenis_simpanan' => 'Deposito', 'minimal_setoran' => 1000000, 'bunga_simpanan' => 5],
        ];

        foreach ($jenisSimpanan as $jenis) {
            JenisSimpanan::create($jenis);
        }
    }
}
