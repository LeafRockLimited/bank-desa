<?php

namespace Tests\Feature;

use App\Models\KodeRekening;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class JurnalControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_store()
    {

        $user = User::first();
        // Data untuk pengujian

        $startDate = now()->startOfMonth(); // 1 Januari 2025
        $endDate = now()->addMonth(2)->endOfMonth();

        $baseData = [
            "debit" => 0,
            "kredit" => 0,
            "keterangan" => "Admin Laku Pandai",
            "komponen_lak" => "Pengeluaran kas untuk pembayaran ke pemasok barang",
            "isDirty" => true,
            "errors" => [],
            "hasErrors" => false,
            "processing" => false,
            "progress" => null,
            "wasSuccessful" => false,
            "recentlySuccessful" => false,
            "__rememberable" => true,
        ];

        $randomValues = [50000, 100000, 150000, 200000];

        $rekening = KodeRekening::find(90);

        $this->actingAs($user);

        // Kirim request POST ke route `jurnal.store`
        $currentDate = $startDate;
           while ($currentDate->lte($endDate)) {
               // Format nomor bukti berdasarkan tanggal transaksi
               $formattedDate = $currentDate->format('dmY'); // Contoh: 01012025
               $noBukti = sprintf('%s/LPE', $formattedDate); // Contoh: 01012025/LPE

               if (rand(0, 1) === 0) {
                   $debit = 0;
                   $kredit = $randomValues[array_rand($randomValues)];
               } else {
                   $debit = $randomValues[array_rand($randomValues)];
                   $kredit = 0;
               }


               // Data transaksi
               $postData = array_merge($baseData, [
                   "no_bukti" => $noBukti,
                   "id_rekening" => $rekening->id,
                   "tanggal_transaksi" => $currentDate->toIso8601String(),
                   "debit" => $debit,
                   "kredit" => $kredit,
               ]);

               // Kirim request POST ke route `jurnal.store`
               $response = $this->postJson(route('jurnal.store'), $postData);

               if ($response->status() === 200) {
                   print_r([
                       'no_bukti' => $noBukti,
                       'tanggal_transaksi' => $currentDate->toIso8601String(),
                       'debit' => $debit,
                       'kredit' => $kredit,
                       'id_rekening' => $rekening->id,
                   ]);
                   $this->assertDatabaseHas('jurnals', [
                       'no_bukti' => $noBukti,
                       'tanggal_transaksi' => $currentDate->toIso8601String(),
                       'debit' => $debit,
                       'kredit' => $kredit,
                       'id_rekening' => $rekening->id,
                   ]);
               }
               else{
                   $this->assertDatabaseMissing('jurnals', [
                       'no_bukti' => $noBukti,
                       'tanggal_transaksi' => $currentDate->toIso8601String(),
                       'debit' => $debit,
                       'kredit' => $kredit,
                       'id_rekening' => $rekening->id,
               ]);}
               usleep(500000);
               $currentDate->addDay();
           }
       }

}
