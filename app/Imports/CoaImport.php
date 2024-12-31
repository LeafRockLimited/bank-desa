<?php

namespace App\Imports;

use App\Models\KodeRekening;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CoaImport implements ToCollection, WithChunkReading,ShouldQueue, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        foreach ($collection as $resource) {

            $parseName = explode(' ', $resource['kode_dan_nama_akun'],2);
            $rekeningLevels = explode('.', $parseName[0]);

            $data = [
                'nomor_rekening' => $parseName[0]??'',
                'nama_rekening' => $parseName[1]??'',
                'saldo_normal' => $resource['saldo_normal'],
                'deskripsi' => null,
                'level_one' => $rekeningLevels[0]??null,
                'uraian_level_one' => null,
                'level_two' => $rekeningLevels[1]??null,
                'uraian_level_two' => null,
                'level_three' => $rekeningLevels[2]??null,
                'uraian_level_three' => null,
                'level_four' => $rekeningLevels[3]??null,
                'uraian_level_four' => null,
                'level_five' => $rekeningLevels[4]??null,
                'uraian_level_five' => null,
                'level_six' => $rekeningLevels[5]??null,
                'uraian_level_six' => null,
            ];

            KodeRekening::updateOrCreate([
                'nomor_rekening' => $data['nomor_rekening']
            ],$data);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
