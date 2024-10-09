<?php

namespace App;

use App\Models\KodeRekening;
use Carbon\Carbon;

trait NeracaTrait
{
   /**
     * Mendapatkan rekap total debit, kredit, dan saldo untuk setiap kode rekening yang difilter berdasarkan tahun.
     *
     * @param int|null $tahun
     * @return \Illuminate\Support\Collection
     */
    public function getRekapNeracaPerTahun($tahun = null, $page = 1 , $perPage = 10, $search = null)
    {
        // Jika tahun tidak disediakan, gunakan tahun sekarang
        $tahun = $tahun ?? Carbon::now()->year;

        // Ambil semua kode rekening beserta total debit, kredit, dan saldo dari buku besar berdasarkan tahun
        $rekap = KodeRekening::with(['bukuBesars' => function($query) use ($tahun) {
            $query->whereYear('tanggal', $tahun) // Filter berdasarkan tahun
                ->selectRaw('id_kode_rekening, SUM(debit) as total_debit, SUM(kredit) as total_kredit, MAX(saldo) as total_saldo')
                ->groupBy('id_kode_rekening');
        }])
        ->when($search, function ($query) use ($search) {
            $query->where('nomor_rekening', 'ilike', "%$search%")
                ->orWhere('nama_rekening', 'ilike', "%$search%");
        })
        ->paginate($perPage, ['*'], 'page', $page);  // Menggunakan paginate() dengan jumlah item per halaman

        // Format hasil dan kembalikan dalam bentuk LengthAwarePaginator
        return $rekap->through(function ($kodeRekening) {
            $bukuBesar = $kodeRekening->bukuBesars->first();
            return [
                'kode_rekening' => $kodeRekening->nomor_rekening,
                'nama_rekening' => $kodeRekening->nama_rekening,
                'total_debit' => $bukuBesar->total_debit ?? 0,
                'total_kredit' => $bukuBesar->total_kredit ?? 0,
                'total_saldo' => $bukuBesar->total_saldo ?? 0,
            ];
        });
    }
}
