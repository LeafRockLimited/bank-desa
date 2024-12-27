<?php

namespace App;

use App\Models\Jurnal;
use App\Models\KodeRekening;
use App\Models\LabaRugiLevel1;
use App\Models\LabaRugiLevel2;
use App\Models\LabaRugiLevel3;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait LabaRugiTrait
{

    private $lastMonth;

    public function createLabaRugi(Jurnal $jurnal) : void{
        DB::beginTransaction();
        try {
            DB::statement('LOCK TABLE laba_rugi_level1s IN EXCLUSIVE MODE');
            $rekening = KodeRekening::where('id',$jurnal->id_rekening)->first();
            $this->lastMonth = Carbon::create($jurnal->tanggal_transaksi)->subMonth()->format('m');
            $levelOne = $this->levelOneCreate($jurnal, $rekening);
            $levelTwo = $this->levelTwoCreate($jurnal, $rekening, $levelOne);
            $levelThree = $this->levelThreeCreate($jurnal, $rekening, $levelTwo);

            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param Jurnal $jurnal
     * @param KodeRekening $rekening
     * @return array
     */
    private function levelOneCreate(Jurnal $jurnal, KodeRekening $rekening) : array{
        $levelOneBefore = LabaRugiLevel1::where('tahun', date('Y', strtotime($jurnal->tanggal_transaksi)))
            ->where('bulan', $this->lastMonth)
            ->where('level_one', $rekening->level_one)
            ->first();

        $levelOne = LabaRugiLevel1::where('tahun', date('Y', strtotime($jurnal->tanggal_transaksi)))
            ->where('bulan', date('m', strtotime($jurnal->tanggal_transaksi)))
            ->where('level_one', $rekening->level_one)
            ->first();

        if($levelOne == null){
            $levelOne = new LabaRugiLevel1();
            $levelOne->tahun = date('Y', strtotime($jurnal->tanggal_transaksi));
            $levelOne->bulan = date('m', strtotime($jurnal->tanggal_transaksi));
            $levelOne->is_shown = true;
            $levelOne->level_one = $rekening->level_one;
            $levelOne->total_this_month = $jurnal->jumlah;

        }else{
            $levelOne->total_this_month += $jurnal->jumlah;
        }

        if($levelOneBefore != null && isset($levelOne->total_till_this_month)){
            $levelOne->total_till_this_month = intVal($levelOneBefore->total_till_this_month??0) + intVal($levelOne->total_this_month);
        }elseif ($levelOneBefore != null && !isset($levelOne->total_till_this_month)){
            $levelOne->total_till_this_month = intVal($levelOneBefore->total_till_this_month??0) + intVal($levelOne->total_this_month);
        }elseif ($levelOneBefore == null && isset($levelOne->total_till_this_month)){
            $levelOne->total_till_this_month = intVal($levelOne->total_this_month);
        }else{
            $levelOne->total_till_this_month = $levelOne->total_this_month;
        }


        $levelOne->save();

        return [
            'levelOne' => $levelOne,
            'levelOneBefore' => $levelOneBefore
        ];
    }

    /**
     * @param Jurnal $jurnal
     * @param KodeRekening $rekening
     * @param array $levelOne
     * @return array
     */
    private function levelTwoCreate(Jurnal $jurnal, KodeRekening $rekening, array $levelOne) : array{
        $levelTwoBefore = LabaRugiLevel2::where('level_one_id', $levelOne['levelOneBefore']->id??null)
            ->where('tahun', date('Y', strtotime($jurnal->tanggal_transaksi)))
            ->where('bulan', $this->lastMonth)
            ->where('level_two', $rekening->level_two)
            ->first();

        $levelTwo = LabaRugiLevel2::where('level_one_id', $levelOne['levelOne']->id)
            ->where('tahun', date('Y', strtotime($jurnal->tanggal_transaksi)))
            ->where('bulan', date('m', strtotime($jurnal->tanggal_transaksi)))
            ->where('level_two', $rekening->level_two)
            ->first();

        if($levelTwo == null){
            $levelTwo = new LabaRugiLevel2();
            $levelTwo->tahun = date('Y', strtotime($jurnal->tanggal_transaksi));
            $levelTwo->bulan = date('m', strtotime($jurnal->tanggal_transaksi));
            $levelTwo->level_one_id = $levelOne['levelOne']->id;
            $levelTwo->is_shown = true;
            $levelTwo->level_two = $rekening->level_two;
            $levelTwo->total_this_month = $jurnal->jumlah;
        }
        else{
            $levelTwo->total_this_month += $jurnal->jumlah;
        }

        if($levelTwoBefore != null && isset($levelTwo->total_till_this_month)){
            $levelTwo->total_till_this_month = intVal($levelTwoBefore->total_till_this_month??0) + intVal($levelTwo->total_this_month);
        }elseif ($levelTwoBefore != null && !isset($levelTwo->total_till_this_month)){
            $levelTwo->total_till_this_month = intVal($levelTwoBefore->total_till_this_month??0) + intVal($levelTwo->total_this_month);
        }elseif ($levelTwoBefore == null && isset($levelTwo->total_till_this_month)){
            $levelTwo->total_till_this_month = intVal($levelTwo->total_this_month);
        }else{
            $levelTwo->total_till_this_month = $levelTwo->total_this_month;
        }

        $levelTwo->save();

        return [
            'levelTwo' => $levelTwo,
            'levelTwoBefore' => $levelTwoBefore
        ];
    }

    private function levelThreeCreate(Jurnal $jurnal, KodeRekening $rekening, array $levelTwo) : array{
        $levelThreeBefore = LabaRugiLevel3::where('level_two_id', $levelTwo['levelTwoBefore']->id??null)
            ->where('tahun', date('Y', strtotime($jurnal->tanggal_transaksi)))
            ->where('bulan', $this->lastMonth)
            ->where('level_three', $rekening->level_three)
            ->first();

        $levelThree = LabaRugiLevel3::where('level_two_id', $levelTwo['levelTwo']->id)
            ->where('tahun', date('Y', strtotime($jurnal->tanggal_transaksi)))
            ->where('bulan', date('m', strtotime($jurnal->tanggal_transaksi)))
            ->where('level_three', $rekening->level_three)
            ->first();

        if($levelThree == null){
            $levelThree = new LabaRugiLevel3();
            $levelThree->tahun = date('Y', strtotime($jurnal->tanggal_transaksi));
            $levelThree->bulan = date('m', strtotime($jurnal->tanggal_transaksi));
            $levelThree->level_two_id = $levelTwo['levelTwo']->id;
            $levelThree->is_shown = true;
            $levelThree->level_three = $rekening->level_three;
            $levelThree->total_this_month = $jurnal->jumlah;
        }
        else{
            $levelThree->total_this_month += $jurnal->jumlah;
        }

        if($levelThreeBefore != null && isset($levelThree->total_till_this_month)){
            $levelThree->total_till_this_month = intVal($levelThreeBefore->total_till_this_month??0) + intVal($levelThree->total_this_month);
        }elseif ($levelThreeBefore != null && !isset($levelThree->total_till_this_month)){
            $levelThree->total_till_this_month = intVal($levelThreeBefore->total_till_this_month??0) + intVal($levelThree->total_this_month);
        }elseif ($levelThreeBefore == null && isset($levelThree->total_till_this_month)){
            $levelThree->total_till_this_month = intVal($levelThree->total_this_month);
        }else{
            $levelThree->total_till_this_month = $levelThree->total_this_month;
        }

        $levelThree->save();

        return [
            'levelThree' => $levelThree,
            'levelThreeBefore' => $levelThreeBefore
        ];
    }

}
