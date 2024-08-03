<?php

namespace App\Exports;

use App\Models\Pinjaman;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PinjamanExport implements FromCollection,WithHeadings, WithStyles
{
    private $tahun;
    private $bulan;
    private $status;

    public function __construct($tahun = null, $bulan = null, $status = null) {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        $this->status = $status;
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
            'Nasabah',
            'Jenis Pinjaman',
            'Jumlah Pinjaman',
            'Bunga (%)',
            'Tanggal Pengajuam',
            'Tanggal Disetujui',
            'Tanggal Jatuh Tempo',
            'Status Pinjaman',
            'Nominal Diterima',
            'created_at',
            'updated_at'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $tahun = $this->tahun??Carbon::now()->year;
        $bulan = $this->bulan;
        $status = $this->status;

        $data = Pinjaman::with('nasabah')
        ->when($status, function($sub) use($status){
            $sub->where('status_pinjaman',$status);
        })
        ->whereYear('tanggal_pengajuan',$tahun)
        ->when($bulan, function($sub) use($bulan){
                $sub->whereMonth('tanggal_pengajuan',$bulan);
        })->get();

        return collect(array_map(function($item) {
            return [
                'id' => $item['id'],
                'nasabah_id' => $item['nasabah']['nama_lengkap'],
                'jenis_pinjaman' => $item['jenis_pinjaman'],
                'jumlah_pinjaman' => $item['jumlah_pinjaman'],
                'bunga' => $item['bunga'],
                'tanggal_pengajuan' => $item['tanggal_pengajuan'],
                'tanggal_disetujui' => $item['tanggal_disetujui'],
                'tanggal_jatuh_tempo' => $item['tanggal_jatuh_tempo'],
                'status_pinjaman' => $item['status_pinjaman'],
                'nominal_diterima' => $item['nominal_diterima'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at']
            ];
        },$data->toArray()));
    }
}
