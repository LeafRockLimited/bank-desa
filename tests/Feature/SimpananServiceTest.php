<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Nasabah;
use App\Models\JenisSimpanan;
use App\Models\Simpanan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\DB;
use App\Services\SimpananService;
use App\Jobs\ProsesSimpanJob;

class SimpananServiceTest extends TestCase
{
    protected $simpananService;

    public function setUp(): void
    {
        parent::setUp();
        $this->simpananService = app(SimpananService::class);
    }

    /** @test */
    public function it_can_create_savings_account_and_deposit()
    {
        // Nonaktifkan RefreshDatabase agar data tetap ada
       

        DB::beginTransaction(); // Pastikan transaksi aman

        // 🔹 1. Buat Nasabah
        $nasabah = Nasabah::factory()->create();

        // 🔹 2. Buat Jenis Simpanan
        $jenisSimpanan = JenisSimpanan::factory()->create([
            'minimal_setoran' => 50000, // Minimal setoran Rp 50.000
            'bunga_simpanan' => 5, // 5% per tahun
        ]);

        // 🔹 3. Data untuk Membuka Rekening
        $dataRekening = [
            'nasabah_id' => $nasabah->id,
            'jenis_simpanan_id' => $jenisSimpanan->id,
            'nominal' => 50000,
            'tanggal_buka' => now()->toDateString(),
            'saldo_awal' => 50000,
            'status_simpanan' => 'Aktif',
        ];

        // 🔹 4. Buka Rekening Simpanan
        $simpanan = $this->simpananService->bukaRekeningSimpanan($dataRekening);
        $this->assertNotNull($simpanan, "Rekening Simpanan berhasil dibuat!");

        // 🔹 5. Data untuk Setoran
        $dataSetoran = [
            'rekening_simpanan' => $simpanan->rekening_simpanan,
            'nominal' => 100000, // Setor Rp 100.000
        ];

        // 🔹 6. Lakukan Setoran
        $simpanan = $this->simpananService->setoranSimpanan($dataSetoran);
        $this->assertNotNull($simpanan, "Setoran berhasil dilakukan!");

        // 🔹 7. Pastikan Saldo Bertambah
        DB::commit(); // Simpan data ke database
        $this->assertEquals(150000, $simpanan->saldo_terkini, "Saldo terkini harus Rp 150.000");

    }
}
