<?php

namespace App\Exports;

use App\Models\Angsuran;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AngsuranExport implements FromCollection,WithHeadings,WithStyles
{

    private $tahun;
    private $bulan;

    public function __construct($tahun = null, $bulan = null) {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Pinjaman',
            'Jumlah Pinjaman',
            'Tanggal Jatuh Tempo',
            'Tanggal Bayar',
            'Jumlah Bayar',
            'Bunga',
            'Sisa Pinjaman',
            'created_at',
            'updated_at',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $tahun = $this->tahun??Carbon::now()->year;
        $bulan = $this->bulan;

        $data = Angsuran::with('nasabah','pinjaman')->whereYear('tanggal_bayar',$tahun)
        ->when($bulan, function($sub) use($bulan){
                $sub->whereMonth('tanggal_bayar',$bulan);
        })->get();
        return collect(array_map(function($item) {
            return [
                'id' => $item['id'],
                'nasabah' => $item['nasabah']['nama_lengkap'],
                'jumlah_pinjaman' => $item['pinjaman']['jumlah_pinjaman'],
                'tanggal_jatuh_tempo' => $item['pinjaman']['tanggal_jatuh_tempo'],
                'tanggal_bayar' => $item['tanggal_bayar'],
                'jumlah_bayar' => $item['jumlah_bayar'],
                'bunga' => $item['bunga'],
                'sisa_pinjaman' => $item['sisa_pinjaman'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
            ];
        },$data->toArray()));
    }
}
