<?php

namespace App\Services;

use App\Jobs\ProsesSimpanJob;
use App\Models\BungaSimpanan;
use App\Models\JenisSimpanan;
use App\Models\LaporanSimpanan;
use App\Models\Simpanan;
use App\Models\TransaksiSimpanan;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Worksheet\Validations;

class SimpananService
{
    public function bukaRekeningSimpanan($data): Simpanan
    {
        DB::beginTransaction();
        try {

        
            $jenisSimpanan = JenisSimpanan::find($data['jenis_simpanan_id']);
            if (!$jenisSimpanan) {
                throw new Exception('Jenis Simpanan Tidak Ditemukan');
            }

            if ($jenisSimpanan->minimal_setoran > $data['nominal']) {
                throw new Exception('Minimal Setoran Simpanan ' . $jenisSimpanan->nama_jenis_simpanan . ' adalah ' . (int)$jenisSimpanan->minimal_setoran);
            }

            $simpanan = Simpanan::create([
                'nasabah_id' => $data['nasabah_id'],
                'rekening_simpanan' => NumberGenerator::generateRekeningSimpanan(),
                'jenis_simpanan_id' => $data['jenis_simpanan_id'],
                'tanggal_buka' => $data['tanggal_buka'],
                'saldo_awal' => $data['saldo_awal'],
                'saldo_terkini' => $data['saldo_awal'],
                'status_simpanan' => $data['status_simpanan'],
            ]);

            dispatch(new ProsesSimpanJob($simpanan, 'setoran', $data['nominal'], now(), 'Setoran Awal'));

            DB::commit();
            return $simpanan;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function setoranSimpanan($data)
    {
        $simpanan = Simpanan::where('rekening_simpanan', $data['rekening_simpanan'])->first();
        if (!$simpanan) {
            return new Exception('Simpanan Tidak Ditemukan');
        }


        $simpanan->saldo_terkini = $simpanan->saldo_terkini + $data['nominal'];
        $simpanan->save();
        dispatch(new ProsesSimpanJob($simpanan, 'setoran', $data['nominal'], now(), 'Setoran'));
        return $simpanan;
    }

    public function penarikanSimpanan($data): Simpanan
    {

        $simpanan = Simpanan::where('rekening_simpanan', $data['rekening_simpanan'])->first();
        if (!$simpanan) {
            throw new Exception('Simpanan Tidak Ditemukan');
        }

        if ($simpanan->saldo_terkini < $data['nominal']) {
            throw new Exception('Saldo Tidak Mencukupi');
        }

        DB::beginTransaction();

        try {
            $simpanan->saldo_terkini = $simpanan->saldo_terkini - $data['nominal'];
            $simpanan->save();
            dispatch(new ProsesSimpanJob($simpanan, 'penarikan', $data['nominal'], now(), 'Penarikan'));

            DB::commit();
            return $simpanan;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function tutupRekeningSimpanan($data)
    {
        $validator = Validator::make($data, [
            'simpanan_id' => 'required|exists:simpanans,id',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $data = $validator->validated();

        $simpanan = Simpanan::find($data['simpanan_id']);
        if (!$simpanan) {
            return new Exception('Simpanan Tidak Ditemukan');
        }

        $simpanan->status_simpanan = 'Tutup';
        $simpanan->save();

        return $simpanan;
    }

    public function prosesTransaksiSimpanan(array $data)
    {

        $validator = Validator::make($data, [
            'simpanan_id' => 'required|exists:simpanans,id',
            'jenis_transaksi' => 'required|in:setoran,penarikan',
            'nominal' => 'required|numeric',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $data = $validator->validated();

        $transaksi = TransaksiSimpanan::create([
            'simpanan_id' => $data['simpanan_id'],
            'jenis_transaksi' => $data['jenis_transaksi'],
            'nominal' => $data['nominal'],
            'tanggal_transaksi' => $data['tanggal_transaksi'],
            'keterangan' => $data['keterangan'],
        ]);

        return $transaksi;
    }

    public function hitungBungaSimpanan(Simpanan $simpanan) : ?BungaSimpanan
    {
        $tanggalSekarang = now();
        $tanggalBuka = $simpanan->tanggal_buka;

        // Cek apakah rekening sudah berusia minimal 1 bulan
        if ($tanggalSekarang->diffInMonths($tanggalBuka) < 1) {
            return null; // Tidak menghitung bunga jika belum 1 bulan
        }

        $jumlahHariBulanIni = $tanggalSekarang->daysInMonth; // 28, 29, 30, atau 31
        $jumlahHariDalamTahun = $tanggalSekarang->isLeapYear() ? 366 : 365; // Kabisat atau tidak

        $sukuBunga = $simpanan->jenisSimpanan->bunga_simpanan / 100; // Konversi ke desimal
        $saldoHarian = $simpanan->saldo_terkini; // Anggap saldo terakhir sebagai saldo harian rata-rata

        // Perhitungan bunga sesuai rumus
        $bungaDihitung = ($saldoHarian * $sukuBunga * $jumlahHariBulanIni) / $jumlahHariDalamTahun;

        // Simpan bunga ke dalam tabel bunga_simpanan
        $bunga = BungaSimpanan::create([
            'simpanan_id' => $simpanan->id,
            'tanggal_perhitungan' => $tanggalSekarang,
            'persentase_bunga' => $simpanan->jenisSimpanan->bunga_simpanan,
            'nominal_bunga' => $bungaDihitung,
        ]);

        // Update saldo terkini nasabah
        $simpanan->update(['saldo_terkini' => $simpanan->saldo_terkini + $bungaDihitung]);

        return $bunga;
    }



    public function laporanHarianSimpanan($total_saldo, $setoran, $penarikan, $total_bunga)
    {
        $now = now();

        $laporan = LaporanSimpanan::where('tanggal_laporan', $now)->first();

        if ($laporan) {
            // Jika data laporan sudah ada, lakukan update
            $laporan->update([
                'total_simpanan' => DB::raw("total_simpanan + $setoran - $penarikan"),
                'total_setoran' => DB::raw("total_setoran + $setoran"),
                'total_penarikan' => DB::raw("total_penarikan + $penarikan"),
                'total_bunga' => DB::raw("total_bunga + $total_bunga"),
            ]);
        } else {
            // Jika tidak ada, lakukan insert data baru
            LaporanSimpanan::create([
                'tanggal_laporan' => $now,
                'total_simpanan' => $setoran - $penarikan,
                'total_setoran' => $setoran,
                'total_penarikan' => $penarikan,
                'total_bunga' => $total_bunga,
            ]);
        }
    }

    public function findSimpanan($request){
        $simpanan = Simpanan::where('rekening_simpanan', $request->rekening_simpanan)
        ->orWhere('nasabah_id', $request->nasabah_id)->first();

        return $simpanan;
    }

    public function getTabunganByNasabahId($nasabah_id){
        $simpanans = Simpanan::where('nasabah_id',$nasabah_id);

        return $simpanans;
        
    }
}
