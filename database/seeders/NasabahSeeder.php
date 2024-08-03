<?php

namespace Database\Seeders;

use App\Models\Nasabah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class NasabahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            Nasabah::create([
                'nama_lengkap'   => $faker->name,
                'alamat'         => $faker->address,
                'nomor_telepon'  => $faker->phoneNumber,
                'email'          => $faker->unique()->safeEmail,
                'tanggal_lahir'  => $faker->date('Y-m-d', '2000-01-01'),
                'nomor_identitas' => $faker->unique()->numerify('##########'),
                'pekerjaan'      => $faker->jobTitle,
            ]);
        }
    }
}
