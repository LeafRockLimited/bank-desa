<?php

namespace Database\Seeders;

use App\Models\KeteranganTransaksiJurnal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeteranganTransaksiJurnalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Admin Bank',
            'Admin Laku Pandai',
            'Bunga Bank',
            'Fee Laku Pandai',
            'fotocopy',
            'Konsumsi Rapat',
            'Konsumsi rapat BUMDES',
            'Modal Awal',
            'Pajak Bunga',
            'Pembayaran PBB',
            'Pembayaran PLN',
            'Pembayaran Transfer',
            'Pembayaran Materai',
            'Pembelian Bensin',
            'Pembelian Etalase Kantor',
            'Pembelian Lampu',
            'Pembelian persediaan toko',
            'Pembelian barang toko',
            'Pembayaran BPJS',
            'Stopmap',
        ];

        foreach ($data as $name) {
            KeteranganTransaksiJurnal::create(['name' => $name]);
        }
    }
}
