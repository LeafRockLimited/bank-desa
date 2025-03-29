<?php

namespace Database\Factories;

use App\Models\JenisSimpanan;
use App\Models\Simpanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Simpanan>
 */
class SimpananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Simpanan::class;
    public function definition(): array
    {
        return [
            'nasabah_id' => NasabahFactory::new()->create()->id,
            'jenis_simpanan_id' => JenisSimpanan::inRandomOrder()->first()->id,
            'tanggal_buka' => $this->faker->date(),
            'saldo_awal' => $this->faker->numberBetween(100000, 100000000),
            'saldo_terkini' => $this->faker->numberBetween(100000, 100000000),
            'status_simpanan' => $this->faker->randomElement(['Aktif', 'Tutup']),
        ];
    }
}
