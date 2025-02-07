<?php

namespace App;

use App\Models\BukuBesar;
use App\Models\Jurnal;
use Illuminate\Support\Facades\DB;

trait BukuBesarTrait
{
    public function createBukuBesar(Jurnal $jurnal):void{
        DB::beginTransaction();
        try {
//            DB::statement('LOCK TABLE buku_besars IN EXCLUSIVE MODE');
            $bukuBesar = new BukuBesar();
            $bukuBesar->id_jurnal = $jurnal->id;
            $bukuBesar->id_rekening = $jurnal->id_rekening;
            $bukuBesar->debit = $jurnal->debit;
            $bukuBesar->kredit = $jurnal->kredit;
            $latestBukuBesar = $this->getLatestBukuBesarByAccount($jurnal);

            if($latestBukuBesar){
                $bukuBesar->saldo = $latestBukuBesar->saldo + ($bukuBesar->debit - $bukuBesar->kredit);
            }else{
                $bukuBesar->saldo = $bukuBesar->debit - $bukuBesar->kredit;
            }
            $bukuBesar->save();
            DB::commit();
        }
        catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

/*************  ✨ Codeium Command ⭐  *************/
/**
 * Updates the BukuBesar record associated with the given Jurnal.
 * 
 * Retrieves the BukuBesar related to the Jurnal, updates its debit and kredit
 * values to match those of the Jurnal, and calculates the new saldo based on
 * the latest BukuBesar for the same account. Saves the updated BukuBesar to
 * the database.
 * 
 * @param  \App\Models\Jurnal  $jurnal  The journal entry containing updated
 *                                      transaction details.
 * @return void
 */

/******  ea74f56d-f431-4cd3-b724-9baaf0f44c25  *******/    public function updateBukuBesar(Jurnal $jurnal){
        $bukuBesar = $jurnal->buku_besar;
        $bukuBesar->debit = $jurnal->debit;
        $bukuBesar->kredit = $jurnal->kredit;
        $latestBukuBesar = $this->getLatestBukuBesarByAccount($jurnal);
        $bukuBesar->saldo = ($latestBukuBesar->saldo??0) + ($bukuBesar->debit - $bukuBesar->kredit);
        $bukuBesar->save();
    }

    public function getLatestBukuBesarByAccount(Jurnal $jurnal){
        $rekening = $jurnal->rekening;
        $latestJurnals = Jurnal::where('id_rekening', $rekening->id)->latest()->take(2)->get();
        $latestSecond = isset($latestJurnals[1]) ? $latestJurnals[1] : null;
        if (!$latestSecond) {
            return null;
        }else{
            return $latestSecond->buku_besar;
        }
    }
}
