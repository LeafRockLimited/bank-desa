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
            DB::statement('LOCK TABLE buku_besars IN EXCLUSIVE MODE');
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
