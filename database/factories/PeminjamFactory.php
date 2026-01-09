<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peminjam>
 */
class PeminjamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'organisasi' => $this->faker->company(),
            'jabatan' => $this->faker->randomElements(['Ketua', 'Karyawan', 'Supir', 'Pemateri'])[0],
            'hp' => $this->faker->phoneNumber(),
        ];
    }
}
