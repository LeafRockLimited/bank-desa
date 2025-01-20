<?php

namespace App;

use App\Models\Jurnal;
use App\Models\KodeRekening;
use App\Models\LabaRugiLevel1;
use App\Models\LabaRugiLevel2;
use App\Models\LabaRugiLevel3;
use App\Models\Rumus;
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
//            DB::statement('LOCK TABLE laba_rugi_level1s IN EXCLUSIVE MODE');
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


    private function iterProcess(Builder $model,int $month, $to = 12, Jurnal $jurnal, KodeRekening $rekening, int $level = 1,int $jumlah = 0, array $modelBefore = []
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
                    $levelStrColumn => $rekening[$levelStrColumn],
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
                    ->where($levelStrColumn, $rekening[$levelStrColumn])
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
            }
            DB::commit();
            return $insertedData;
        }

        catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }

    public function totalLabaRugi(int $tahun, int $bulan){
        return LabaRugiLevel1::where('tahun', $tahun)->where('bulan', $bulan)->sum('total_till_this_month');
    }

    public function processFormula(array $dataRekening){
        // Anggap kita memiliki semua data rekening ini
        // Template atau validasi untuk memastikan semua akun ada
        $template = [
            // Pendapatan Usaha
            'rekening4_1_01', // Pendapatan Wisata
            'rekening4_1_02', // Pendapatan Pengelolaan Air Bersih
            'rekening4_1_03', // Pendapatan Pengelolaan Sampah
            'rekening4_1_04', // Pendapatan Sewa
            'rekening4_1_05', // Pendapatan Jasa Pelayanan
            'rekening4_2_01', // Pendapatan Penjualan Barang Dagangan
            'rekening4_3_01', // Pendapatan Penjualan Barang Jadi

            // Harga Pokok Penjualan
            'rekening5_1_01', // Harga Pokok Penjualan Barang Dagangan
            'rekening5_2_01', // Harga Pokok Penjualan Barang Jadi

            // Beban-Beban Usaha
            'rekening6_1_01', // Beban Pegawai Bagian Administrasi Umum
            'rekening6_1_02', // Beban Perlengkapan
            'rekening6_2_01', // Beban Pegawai Bagian Operasional
            'rekening6_3_01', // Beban Pegawai Bagian Pemasaran

            // Pendapatan dan Beban Lain-lain
            'rekening7_1_01', // Pendapatan dari Bank
            'rekening7_2_01', // Beban Bank
            'rekening7_3_01', // Beban Pajak
        ];

        // Validasi dan set nilai default 0 jika null
        foreach ($template as $rekening) {
            if (!array_key_exists($rekening, $dataRekening)) {
                // Jika key tidak ada, set ke 0
                $dataRekening[$rekening] = 0;
            } elseif (is_null($dataRekening[$rekening])) {
                // Jika nilainya null, set ke 0
                $dataRekening[$rekening] = 0;
            }
        }


        // Ambil rumus dari database
        $formula = $this->setFormula();
        $slug = $formula->slug;

        $rumus = $slug; // Simpan slug ke dalam rumus awal
        foreach ($dataRekening as $placeholder => $value) {
            $rumus = str_replace('${' . $placeholder . '}', $value, $rumus); // Simpan hasil di rumus
        }

        // Eksekusi rumus dengan eval
        $result = eval("return $rumus;");

        return $result;
    }

    /**
     * @return void
     * rumus default rekening (((4.1 + 4.2 + 4.3) -(5.1 + 5.2)) - (6.1 + 6.2 + 6.3)) + (7.1 - 7.2 - 7.3)
     */
    public function setFormula(){
     $rumusLabaRugi = Rumus::updateOrCreate(
         [
             'name' => 'laba_rugi'
         ],
         [
             'slug' => '(
                (${rekening4_1_01} + ${rekening4_1_02} + ${rekening4_1_03} + ${rekening4_1_05} + ${rekening4_2_01} + ${rekening4_3_01})
                - (${rekening5_1_01} + ${rekening5_2_01})
                - (${rekening6_1_01} + ${rekening6_1_02} + ${rekening6_2_01} + ${rekening6_3_01})
                + (${rekening7_1_01} - ${rekening7_2_01} - ${rekening7_3_01})
            )'
         ]
     );

    return $rumusLabaRugi;
    }

    public function array_search_recursive($needle, $haystack, $strict = false) {
        foreach ($haystack as $key => $value) {
            if ($strict ? $value === $needle : $value == $needle) {
                return [$key];
            }
            if (is_array($value)) {
                $result = $this->array_search_recursive($needle, $value, $strict);
                if ($result !== false) {
                    return [$key] + $result;
                }
            }
        }
        return false;
    }
}
