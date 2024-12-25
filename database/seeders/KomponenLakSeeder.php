<?php

namespace Database\Seeders;

use App\Models\KomponenLak;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KomponenLakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            "Penerimaan kas dari penyertaan modal desa",
            "Penerimaan kas dari bunga bank",
            "Pengeluaran kas untuk pembayaran pajak",
            "Pengeluaran kas untuk pembayaran beban-beban yang lain",
            "Pengeluaran kas untuk pembayaran bunga",
            "Penerimaan kas dari penjualan jasa",
            "Pengeluaran kas untuk pembayaran ke pemasok barang",
            "Penerimaan kas dari penjualan barang dagangan",
        ];

        foreach ($data as $name) {
            KomponenLak::create(['name' => $name]);
        }
    }
}
