<?php

namespace App\Imports;

use App\Models\Jurnal;
use App\Models\KodeRekening;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Ramsey\Uuid\Type\Integer;

class JurnalImport implements ToCollection, ShouldQueue, WithChunkReading, WithStartRow, WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param Collection $collection
    */

    public $tries = 5;
    public function collection(Collection $collection)
    {

        DB::beginTransaction();
//        DB::statement('LOCK TABLE jurnals IN EXCLUSIVE MODE');

        try {

            $tanggal_temp = null;
            foreach ($collection as $key => $resource) {

                $rekening = explode(' ', $resource['kode_dan_nama_akun'],2);
                $kodeRekening = KodeRekening::where('nomor_rekening', $rekening[0])->first();

                if ($kodeRekening && isset($resource['nomor_bukti'])) {

                    if (isset($resource['tanggal'])) {

                        if (strlen($resource['tanggal']) == 8) { // Format dd/mm/yy
                            $tanggal = DateTime::createFromFormat('d/m/y', $tanggal)->format('Y-m-d');
                        } else if (strlen($resource['tanggal']) == 10) { // Format dd/mm/yyyy
                            $tanggal = \DateTime::createFromFormat('d/m/Y', $resource['tanggal'])->format('Y-m-d');
                        }
                        else if(is_int($resource['tanggal'])){
                            $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($resource['tanggal'])->format('Y-m-d');
                        }
                        else {
                            throw new \Exception('Format tanggal tidak valid: ' . $resource['tanggal']);
                        }

                        $tanggal_temp = $tanggal;
                    }else{
                        $tanggal = $tanggal_temp;
                    }


                    $jurnal = Jurnal::create([
                        'tanggal_transaksi' => $tanggal,
                        'id_rekening' => $kodeRekening->id,
                        'no_bukti' => $resource['nomor_bukti'],
                        'debit' => floatVal($resource['sisi_kiri_debit'])??0,
                        'kredit' => floatVal($resource['sisi_kanan_kredit'])??0,
                        'komponen_lak' => $resource['komponen_laporan_arus_kas'],
                        'keterangan' => $resource['keterangan_transaksi']
                    ]);
                }

            }
                    DB::commit();
        }
        catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());
            DB::rollBack();
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function startRow(): int
    {
        return 2;
    }
}
