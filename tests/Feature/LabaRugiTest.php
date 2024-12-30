<?php

namespace Tests\Feature;

use App\LabaRugiTrait;
use App\Models\LabaRugiLevel1;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LabaRugiTest extends TestCase
{
    use LabaRugiTrait;
    /**
     * A basic feature test example.
     */
    public function test_formula(): void
    {

        $tahun = date('Y');
        $month = date('m');
        $labaRugiLevel1s = LabaRugiLevel1::where('tahun', $tahun)->where('bulan', $month)->get();
        $dataRekening = [];
        foreach ($labaRugiLevel1s as $level1) {
            $level2s = $level1->level_2;

            foreach ($level2s as $level2) {
                $level3s = $level2->level_3;
                foreach ($level3s as $level3) {
                    $dataRekening["rekening{$level1->level_one}_{$level2->level_two}_{$level3->level_three}"] = $level3->total_till_this_month;

                }
            }
        }

        $result = $this->processFormula($dataRekening);

        dd($result);


        $dataRekening = [
            // Pendapatan Usaha
            'rekening4_1_01' => 0, // Pendapatan Wisata
            'rekening4_1_02' => 0, // Pendapatan Pengelolaan Air Bersih
            'rekening4_1_03' => 0, // Pendapatan Pengelolaan Sampah
            'rekening4_1_04' => 0, // Pendapatan Sewa
            'rekening4_1_05' => 6492202, // Pendapatan Jasa Pelayanan
            'rekening4_2_01' => 0, // Pendapatan Penjualan Barang Dagangan
            'rekening4_3_01' => 0, // Pendapatan Penjualan Barang Jadi

            // Harga Pokok Penjualan
            'rekening5_1_01' => 6429735, // Harga Pokok Penjualan Barang Dagangan
            'rekening5_2_01' => 0, // Harga Pokok Penjualan Barang Jadi

            // Beban-Beban Usaha
            'rekening6_1_01' => 0, // Beban Pegawai Bagian Administrasi Umum
            'rekening6_1_02' => 96000, // Beban Perlengkapan
            'rekening6_2_01' => 0, // Beban Pegawai Bagian Operasional
            'rekening6_3_01' => 0, // Beban Pegawai Bagian Pemasaran

            // Pendapatan dan Beban Lain-lain
            'rekening7_1_01' => 165803, // Pendapatan dari Bank
            'rekening7_2_01' => 48500, // Beban Bank
            'rekening7_3_01' => 32711, // Beban Pajak
        ];

        $result = $this->processFormula($dataRekening);
        echo $result;
        $this->assertEquals(51059, $result);
    }
}
