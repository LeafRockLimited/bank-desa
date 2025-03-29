<?php

namespace Database\Factories;

use App\Models\JenisSimpanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JenisSimpanan>
 */
class JenisSimpananFactory extends Factory
{
    protected $model = JenisSimpanan::class;

    public function definition()
    {
        return [
            'nama_jenis_simpanan' => $this->faker->randomElement(['Simpanan Pokok', 'Simpanan Wajib', 'Simpanan Sukarela']),
            'minimal_setoran' => $this->faker->randomFloat(2, 10000, 500000),
            'bunga_simpanan' => $this->faker->randomFloat(2, 1, 5),
        ];
    }
}
