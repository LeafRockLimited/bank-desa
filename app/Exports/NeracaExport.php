<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class NeracaExport implements FromCollection, WithHeadings, WithColumnFormatting,
WithEvents, WithStyles, WithCustomStartCell
{

    protected $data;
    protected $tahun;
    protected $bulan;
    protected $lastDay;
    public function __construct($data,$tahun, $bulan)
    {
        $this->data = $data;
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        

        $formattedBulan = CarbonImmutable::create(null, $bulan, null)->locale('id');
        $this->bulan = $formattedBulan->translatedFormat('F');

        $this->lastDay = $formattedBulan->endOfMonth()->day; 
    }

    public function headings(): array
    {
        return [
            'No',
            'Keterangan',
            'Saldo',
            'No',
            'Keterangan',
            'Saldo',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => '#,##0;[Red](#,##0)',           // Angka tanpa desimal, merah jika negatif
            'F' => '#,##0;[Red](#,##0)',           // Angka tanpa desimal, merah jika negatif
        ];
    }

    public function startCell(): string
    {
        return 'A6';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = $this->data;

        $aktiva = [
            ['A', 'Aktiva', '', 'B', 'Pasiva', ''],
            ['1', 'Kas', $data['aktiva']['kas_tunai'], '1', 'Tabungan', $data['pasiva']['simpanan']],
            ['2', 'Antar Bank', $data['aktiva']['antar_bank'], '2', 'Antar Bank Pasiva', $data['pasiva']['antar_bank']],
            ['3', 'Pinjaman', $data['aktiva']['pinjaman'], '3', 'Pinjaman BKD Lain', $data['pasiva']['pinjaman_bkd_lain']],
            ['4', 'Pinjaman BKD Lain', $data['aktiva']['pinjaman_bkd_lain_aktiva'], '4', 'Pinjaman Lainnya', $data['pasiva']['pinjaman_lainnya']],
            ['5', 'Harta Tetap', $data['aktiva']['harta_tetap'], '5', 'Modal', $data['pasiva']['modal']],
            ['6', 'Akumulasi Penyusutan', $data['aktiva']['akumulasi_penyusutan'], '6', 'Rupa-Rupa Pasiva', $data['pasiva']['rupa_pasiva']],
            ['', '', '', '7', 'Laba Rugi Tahun Berjalan', $data['pasiva']['laba_rugi']['total']??0],
            ['', 'JUMLAH (=ASSET)', $data['aktiva']['total']??0, '', 'JUMLAH', $data['pasiva']['total']??0],
        ];

        return collect($aktiva);
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                // **Merge Judul (agar lebih di tengah tabel)**
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');
                $sheet->mergeCells('A3:F3');

                // **Set Teks Judul Uppercase**
                $sheet->setCellValue('A1', strtoupper('Neraca'));
                $sheet->setCellValue('A2', strtoupper('Badan Kredit Desa (BKD) Rembang'));
                $sheet->setCellValue('A3', strtoupper("$this->lastDay $this->bulan  $this->tahun"));

                // **Styling Judul**
                $sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
                $sheet->getStyle('A2')->getFont()->setSize(14)->setBold(true);
                $sheet->getStyle('A3')->getFont()->setSize(12);

                $sheet->getStyle('A6:F6')->getFont()->setSize(12)->setBold(true);
                
                // **Rata Tengah Judul**
                $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal('center')->setVertical('center');
                


                $cellRange = "A6:F15";
                $sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'], // Warna hitam
                        ],
                    ],
                ]);

                // **Mengatur lebar kolom otomatis agar fit dengan isi**
                foreach (range('A', 'F') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]], // Bold pada header
            'B1' => ['font' => ['bold' => true, 'size' => 12]], // Bold header Aktiva
            'E1' => ['font' => ['bold' => true, 'size' => 12]], // Bold header Pasiva
        ];
    }

}
