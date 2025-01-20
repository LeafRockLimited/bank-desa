<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;

class LakExport implements FromView
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.lak', [
            'tahun' => $this->data['tahun'],
            'bulan' => $this->data['bulan'],
            'arusKasMasukOperasi' => $this->data['arusKasMasukOperasi'],
            'jumlahKasMasukOperasi' => $this->data['jumlahKasMasukOperasi'],
            'arusKasKeluarOperasi' => $this->data['arusKasKeluarOperasi'],
            'jumlahKasKeluarOperasi' => $this->data['jumlahKasKeluarOperasi'],
            'arusKasBersihOperasi' => $this->data['arusKasBersihOperasi'],
            'arusKasMasukInvestasi' => $this->data['arusKasMasukInvestasi'],
            'jumlahKasMasukInvestasi' => $this->data['jumlahKasMasukInvestasi'],
            'arusKasKeluarInvestasi' => $this->data['arusKasKeluarInvestasi'],
            'jumlahKasKeluarInvestasi' => $this->data['jumlahKasKeluarInvestasi'],
            'arusKasBersihInvestasi' => $this->data['arusKasBersihInvestasi'],
            'arusKasMasukPembiayaan' => $this->data['arusKasMasukPembiayaan'],
            'jumlahKasMasukPembiayaan' => $this->data['jumlahKasMasukPembiayaan'],
            'arusKasKeluarPembiayaan' => $this->data['arusKasKeluarPembiayaan'],
            'jumlahKasKeluarPembiayaan' => $this->data['jumlahKasKeluarPembiayaan'],
            'arusKasBersihPembiayaan' => $this->data['arusKasBersihPembiayaan'],
            'kenaikanKas' => $this->data['kenaikanKas'],
            'saldoKasAwal' => $this->data['saldoKasAwal'],
            'saldoKasAkhir' => $this->data['saldoKasAkhir'],
        ]);

}
}
