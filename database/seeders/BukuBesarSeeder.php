<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
class BukuBesarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Ambil semua kode rekening dari tabel kode_rekenings
         $kodeRekenings = DB::table('kode_rekenings')->pluck('id');

         $transaksiData = [];
         $saldo = 1000000; // Saldo awal
 
         for ($i = 0; $i < rand(0, 200); $i++) {
             // Pilih kode rekening secara acak
             $kodeRekeningId = $kodeRekenings->random();
 
             // Tentukan apakah transaksi debit atau kredit
             $isDebit = rand(0, 1) === 1;
             $nominal = rand(10000, 500000); // Nilai acak untuk debit/kredit
 
             $debit = $isDebit ? $nominal : 0;
             $kredit = !$isDebit ? $nominal : 0;
 
             // Hitung saldo berdasarkan transaksi
             $saldo += $debit - $kredit;
 
             $transaksiData[] = [
                 'id_kode_rekening' => $kodeRekeningId,
                 'keterangan' => Str::random(10), // Deskripsi acak
                 'nomor_ref' => 'REF-' . Str::upper(Str::random(5)),
                 'komponen_laporan_arus_kas' => 'Komponen-' . rand(1, 5),
                 'buku_pembantu' => 'Pembantu-' . rand(1, 3),
                 'jumlah_unit' => rand(1, 10),
                 'tanggal' => Carbon::now()->subDays(rand(0, 365))->format('Y-m-d'),
                 'debit' => $debit,
                 'kredit' => $kredit,
                 'saldo' => $saldo,
                 'created_at' => now(),
                 'updated_at' => now(),
             ];
         }
 
         // Insert batch data
         DB::table('buku_besars')->insert($transaksiData);
    }
}
