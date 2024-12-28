<?php

namespace App;

use App\Models\Jurnal;
use App\Models\KodeRekening;
use App\Models\LabaRugiLevel1;
use App\Models\LabaRugiLevel2;
use App\Models\LabaRugiLevel3;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait LabaRugiTrait
{

    private $lastMonth;

    public function createLabaRugi(Jurnal $jurnal) : void{
        DB::beginTransaction();
        try {
            DB::statement('LOCK TABLE laba_rugi_level1s IN EXCLUSIVE MODE');
            $rekening = KodeRekening::where('id',$jurnal->id_rekening)->first();
            $this->lastMonth = Carbon::create($jurnal->tanggal_transaksi)->subMonth()->format('m');
            $thisMonth = date('m',strtotime($jurnal->tanggal_transaksi));

            $labaRugi1 = $this->iterProcess(LabaRugiLevel1::query(),  $thisMonth , 12, $jurnal, $rekening, 1 ,$jurnal->jumlah);
            $labaRugi2 = $this->iterProcess(LabaRugiLevel2::query(),  $thisMonth , 12, $jurnal, $rekening, 2 ,$jurnal->jumlah, $labaRugi1);
            $labaRugi3 = $this->iterProcess(LabaRugiLevel3::query(),  $thisMonth , 12, $jurnal, $rekening, 3 ,$jurnal->jumlah, $labaRugi2);

            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }


    private function deleteLabaRugi(Jurnal $jurnal){
        DB::beginTransaction();
        $kodeRekening = KodeRekening::find($jurnal->id_rekening);

        $thisYear = date('Y', strtotime($jurnal->tanggal_transaksi));
        $thisMonth = date('m', strtotime($jurnal->tanggal_transaksi));

        try {
            $jumlah = 0 - $jurnal->jumlah;

            $labaRugi1 = $this->iterProcess(LabaRugiLevel1::query(), $thisMonth, 12, $jurnal, $kodeRekening, 1, $jumlah);
            $labaRugi2 = $this->iterProcess(LabaRugiLevel2::query(), $thisMonth, 12, $jurnal, $kodeRekening, 2, $jumlah,$labaRugi1);
            $labaRugi3 = $this->iterProcess(LabaRugiLevel3::query(), $thisMonth, 12, $jurnal, $kodeRekening, 3, $jumlah, $labaRugi2);
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
    }


    private function iterProcess(Builder $model,int $month, $to = 12,
                                 Jurnal $jurnal, KodeRekening $rekening,
                                 int $level = 1,int $jumlah = 0, array $modelBefore = []
    ) : array{

        DB::beginTransaction();
        try {
            $levelArr = ['level_one','level_two','level_three'];
            $levelStrColumn = $levelArr[$level - 1];

            $insertedData = [];
            for ($i = $month; $i <= $to; $i++) {
                $modelQuery = clone $model;

                $whereArray = [
                    'tahun' => date('Y', strtotime($jurnal->tanggal_transaksi)),
                    'bulan' => $i,
                    $levelStrColumn => $rekening->level_one,
                ];

                if ($modelBefore) {
                    $idParent = $modelBefore[$i - $month]->id;
                    $whereArray[$levelArr[$level - 2 ].'_id'] = $idParent;
                }

                $modelQuery = $modelQuery->firstOrCreate(
                    $whereArray,
                    [
                        'is_shown' => true,
                        'total_this_month' => 0
                    ]
                );

                if ($i == $month) {
                    $modelQuery->total_this_month += $jumlah;
                }

                $modelQueryBefore = clone $model;
                $modelQueryBefore = $modelQueryBefore->where('tahun', date('Y',strtotime($jurnal->tanggal_transaksi)))
                    ->where('bulan', $i - 1)
                    ->where($levelStrColumn, $rekening->level_one)
                    ->first();

                if(isset($modelQueryBefore)){
                    $modelQuery->total_till_this_month = intVal($modelQueryBefore->total_till_this_month??0) + intVal($modelQuery->total_this_month??0);
                }
                elseif(isset($modelQuery->total_till_this_month)){
                    $modelQuery->total_till_this_month += $jumlah;

                    if($modelQuery->total_till_this_month != $modelQuery->total_this_month){
                        $modelQuery->total_till_this_month = $modelQuery->total_this_month;
                    }

                }
                else{
                    $modelQuery->total_till_this_month = $modelQuery->total_this_month;
                }

                $modelQuery->save();

                $insertedData[] = $modelQuery;
                Log::info('DATA INSERTED',[
                    'bulan' => $i,
                    $modelQuery
                ]);
            }
            DB::commit();
            return $insertedData;
        }

        catch (\Exception $e) {
            Log::error($e->getMessage(),[
                'level' => $level,
                'bulan' => $month,
                'jumlah' => $jumlah,
                'trace' => $e->getTraceAsString()
            ]);
            DB::rollBack();
            throw $e;
        }

    }

}
