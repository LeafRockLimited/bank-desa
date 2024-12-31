<?php

namespace App;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait LpeTrait
{

    use LabaRugiTrait;
    protected $validKodeRekening = [
        '3.1.01.01',
        '3.1.02.01',
        '3.3.01',
        '3.3.02',
        '3.2.01.01',
        '3.2.02.01',
        '3.4.01.01',
    ];

    public function createLpe(Request $request)
    {
        $tahun = $request->tahun??date('Y');
        $bulan = $request->bulan??date('m');

        $saldoAwalModalDesa = Jurnal::whereHas('rekening', function ($query) {
            $query->where('nomor_rekening', 'ilike' ,'3.1.01.01%');
        })->where('keterangan', 'Saldo Awal')->sum('jumlah');

        $saldoAwalModalMasyarakat = Jurnal::whereHas('rekening', function ($query) {
            $query->where('nomor_rekening', 'ilike' ,'3.1.02.01%');
        })->where('keterangan', 'Saldo Awal')->sum('jumlah');


        $saldoModalDesa = Jurnal::whereHas('rekening', function ($query) {
            $query->where('nomor_rekening', 'ilike' ,'3.1.01.01%');
        })->sum('jumlah') - $saldoAwalModalDesa;

        $saldoModalMasyarakat = Jurnal::whereHas('rekening', function ($query) {
            $query->where('nomor_rekening', 'ilike' ,'3.1.02.01%');
        })->sum('jumlah') - $saldoAwalModalMasyarakat;


        $penyertaanModalAkhir = $saldoAwalModalDesa + $saldoAwalModalMasyarakat + $saldoModalDesa + $saldoModalMasyarakat;

        $saldoLabaTidakDicadangkan = Jurnal::whereHas('rekening', function ($query) {
            $query->where('nomor_rekening', 'ilike' ,'3.3.01%');
        })->where('keterangan', 'Saldo Awal')->sum('jumlah');


        $saldoLabaDicadangkan = Jurnal::whereHas('rekening', function ($query) {
            $query->where('nomor_rekening', 'ilike' ,'3.1.02%');
        })->where('keterangan', 'Saldo Awal')->sum('jumlah');


        $labaRugi = $this->totalLabaRugi($tahun, $bulan);


        $bagiHasilPenyertaanModalDesa = Jurnal::whereHas('rekening', function ($query) {
            $query->where('nomor_rekening', 'ilike' ,'3.2.01.01%');
        })->where('keterangan', 'Saldo Awal')->sum('jumlah');


        $bagiHasiPenyertaanModalMasyarakat = Jurnal::whereHas('rekening', function ($query) {
            $query->where('nomor_rekening', 'ilike' ,'3.2.02.01%');
        })->where('keterangan', 'Saldo Awal')->sum('jumlah');


        $saldoLaba = ($saldoLabaTidakDicadangkan + $saldoLabaDicadangkan + $labaRugi) - ($bagiHasilPenyertaanModalDesa + $bagiHasiPenyertaanModalMasyarakat);


        $modalDonasiSumbangan = Jurnal::whereHas('rekening', function ($query) {
            $query->where('nomor_rekening', 'ilike' ,'3.4.01.01%');
        })->where('keterangan', 'Saldo Awal')->sum('jumlah');

        $ekuitasAkhir = $penyertaanModalAkhir + $saldoLaba + $modalDonasiSumbangan;

        return [
            'saldoAwalModalDesa' => $saldoAwalModalDesa,
            'saldoAwalModalMasyarakat' => $saldoAwalModalMasyarakat,
            'saldoModalDesa' => $saldoModalDesa,
            'saldoModalMasyarakat' => $saldoModalMasyarakat,
            'penyertaanModalAkhir' => $penyertaanModalAkhir,
            'saldoLabaTidakDicadangkan' => $saldoLabaTidakDicadangkan,
            'saldoLabaDicadangkan' => $saldoLabaDicadangkan,
            'labaRugi' => $labaRugi,
            'bagiHasilPenyertaanModalDesa' => $bagiHasilPenyertaanModalDesa,
            'bagiHasiPenyertaanModalMasyarakat' => $bagiHasiPenyertaanModalMasyarakat,
            'saldoLaba' => $saldoLaba,
            'modalDonasiSumbangan' => $modalDonasiSumbangan,
            'ekuitasAkhir' => $ekuitasAkhir
        ];

    }
}
