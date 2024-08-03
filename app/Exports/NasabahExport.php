<?php

namespace App\Exports;

use App\Models\Nasabah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class NasabahExport implements FromCollection, WithHeadings, WithStyles
{
    private $tahun;
    private $bulan;
    public function __construct(int $tahun = null, int $bulan = null) {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            // Styling an entire column.
            'C'  => ['font' => ['bold' => true]],
            'D'  => ['font' => ['bold' => true]],
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Nama nasabah',
            'Alamat',
            'Nomor Telepon',
            'Email',
            'Tanggal Lahir',
            'Nomor Identitas',
            'Pekerjaan',
            'created_at',
            'updated_at',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Nasabah::orderBy('created_at','DESC')->get();
    }
}
