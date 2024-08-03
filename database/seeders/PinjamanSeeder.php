<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Pinjaman;
use App\Models\Nasabah;

class PinjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Retrieve all nasabah
        $nasabahs = Nasabah::all();

        foreach ($nasabahs as $nasabah) {
            // Create a random number of pinjaman for each nasabah
            $numberOfPinjaman = rand(1, 5);

            for ($i = 0; $i < $numberOfPinjaman; $i++) {
                $jumlahPinjaman = $faker->numberBetween(1000000, 10000000);
                $bunga = $faker->randomFloat(2, 0, 1); // Bunga dalam bentuk desimal (misalnya, 0.05 untuk 5%)
                $nominalDiterima = $jumlahPinjaman * (1 - $bunga); // Mengurangi bunga dari jumlah pinjaman

                Pinjaman::create([
                    'nasabah_id' => $nasabah->id,
                    'jenis_pinjaman' => $faker->randomElement(['mingguan', 'bulanan', 'musiman', 'tahunan']),
                    'jumlah_pinjaman' => $jumlahPinjaman,
                    'bunga' => $bunga,
                    'nominal_diterima' => $nominalDiterima,
                    'tanggal_pengajuan' => $faker->date(),
                    'tanggal_disetujui' => $faker->optional()->date(),
                    'tanggal_jatuh_tempo' => $faker->date(),
                    'status_pinjaman' => $faker->randomElement(['pending', 'approved', 'rejected', 'paid']),
                ]);
            }
        }
    }
}
