<?php

namespace App;

use App\Models\Jurnal;
use App\Models\KodeRekening;
use App\Models\Neraca;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait NeracaTrait
{
  public function createNeracaPeriodic(Jurnal $jurnal) : void{
      DB::beginTransaction();
      try {
          DB::statement('LOCK TABLE neracas IN EXCLUSIVE MODE');

//          cek neraca periode ini
          $neracaThisPeriode = $this->getNeracaPeriod($jurnal);

          if($neracaThisPeriode){
              $newNeraca = $neracaThisPeriode;
          }else{
              $newNeraca = new Neraca();
              $newNeraca->id_rekening = $jurnal->id_rekening;
              $newNeraca->tahun = $neraca->tahun??date('Y',strtotime($jurnal->tanggal_transaksi));
              $newNeraca->bulan = $neraca->bulan??date('m',strtotime($jurnal->tanggal_transaksi));
          }

          $newNeraca->neraca_debit = $neracaThisPeriode->neraca_debit != null ? $neracaThisPeriode->neraca_debit + $jurnal->debit : $jurnal->debit;
          $newNeraca->neraca_kredit = $neracaThisPeriode->neraca_kredit != null ? $neracaThisPeriode->neraca_kredit + $jurnal->kredit : $jurnal->kredit;

          $neraca = $this->neracaOperation($newNeraca, $neracaThisPeriode, $jurnal);
          $neraca->save();

          DB::commit();
      }
      catch (Throwable $th) {
          DB::rollBack();
          throw $th;
      }

  }

  public function updateNeraca(Jurnal $jurnal){

  }

  public function deleteNeraca(Jurnal $jurnal){
      DB::beginTransaction();
      try {
      DB::statement('LOCK TABLE neracas IN EXCLUSIVE MODE');
          $oldNeraca = $this->getNeracaPeriod($jurnal);

          $newNeraca = $oldNeraca;
          $newNeraca->neraca_debit = $newNeraca->neraca_debit - $jurnal->debit;
          $newNeraca->neraca_kredit = $newNeraca->neraca_kredit - $jurnal->kredit;
          $neraca = $this->neracaOperation($newNeraca, $oldNeraca, $jurnal);
          $neraca->save();
        DB::commit();
      }
      catch (Throwable $th) {
          DB::rollBack();
          throw $th;
      }

  }

  private function neracaOperation(Neraca $insertedNeraca, Neraca $currentNeraca, Jurnal $jurnal){
      $insertedNeraca->saldo_debit = $currentNeraca->neraca_debit > $insertedNeraca->neraca_kredit ? $insertedNeraca->neraca_debit - $insertedNeraca->neraca_kredit : 0;
      $insertedNeraca->saldo_kredit = $currentNeraca->neraca_debit < $insertedNeraca->neraca_kredit ? $insertedNeraca->neraca_kredit - $insertedNeraca->neraca_debit : 0;

      $jumlah = $insertedNeraca->neraca_kredit - $insertedNeraca->neraca_debit;
      $insertedNeraca->jumlah = $jumlah;

      return $insertedNeraca;
  }
    private function getNeracaPeriod(Jurnal $jurnal){
        $neraca = Neraca::where('tahun', date('Y',strtotime($jurnal->tanggal_transaksi)))
            ->where('bulan', date('m',strtotime($jurnal->tanggal_transaksi)))
            ->where('id_rekening', $jurnal->id_rekening)
            ->first();

        return $neraca;
    }
}
