<?php

namespace App\Jobs;

use App\Models\BungaSimpanan;
use App\Models\Simpanan;
use App\Services\SimpananService;
use Brick\Math\BigInteger;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class ProsesSimpanJob implements ShouldQueue
{
    use Queueable;

    protected $simpanan;
    protected $jenis_transaksi;
    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct(Simpanan $simpanan, string $jenis_transaksi, int $nominal, Carbon $tanggal ,string $keterangan)
    {
        $this->simpanan = $simpanan;
        $this->jenis_transaksi = $jenis_transaksi;
        $this->data = [
            'simpanan_id' => $simpanan->id,
            'jenis_transaksi' => $jenis_transaksi,
            'nominal' => $nominal,
            'tanggal_transaksi' => $tanggal,
            'keterangan' => $keterangan
        ];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // simpan transaksi
        $transaksi = (new SimpananService)->prosesTransaksiSimpanan($this->data);

        // hitung bunga per transaksi
        $bunga = (new SimpananService)->hitungBungaSimpanan($this->simpanan);

        // laporan harian
        if (isset($bunga) && $bunga instanceof BungaSimpanan && $bunga->nominal_bunga > 0) {
            $nominalBunga = $bunga->nominal_bunga;
        } else {
            $nominalBunga = 0;
        }
        $laporan = (new SimpananService)->laporanHarianSimpanan(
            $this->simpanan->saldo_terkini, 
            $this->jenis_transaksi == 'setoran' ? $transaksi->nominal : 0, 
            $this->jenis_transaksi == 'penarikan' ? $transaksi->nominal : 0, 
            $nominalBunga
        );
        
    }
}
