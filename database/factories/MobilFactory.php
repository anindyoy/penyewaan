<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MobilFactory extends Factory
{
    public function definition(): array
    {
        $mobilData = [
            ['Toyota', 'Avanza'],
            ['Toyota', 'Innova Reborn'],
            ['Toyota', 'Agya'],
            ['Toyota', 'Hilux Pickup'],
            ['Honda', 'Brio'],
            ['Honda', 'Mobilio'],
            ['Daihatsu', 'Xenia'],
            ['Daihatsu', 'Ayla'],
            ['Daihatsu', 'Luxio'],
            ['Daihatsu', 'Gran Max Pickup'],
            ['Suzuki', 'Ertiga'],
            ['Suzuki', 'Carry Pickup'],
            ['Mitsubishi', 'Xpander'],
            ['Mitsubishi', 'L300 Pickup'],
            ['Toyota', 'Hiace'],
        ];

        $pilih = $this->faker->randomElement($mobilData);

        return [
            'merek' => $pilih[0],
            'model' => $pilih[1],
            'nomor_plat' => strtoupper($this->faker->unique()->bothify('f #### ???')), // Contoh Plat B
            'warna' => $this->faker->randomElement(['hitam', 'silver', 'putih', 'merah', 'biru']),
            'tahun_produksi' => $this->faker->year(),
            'status' => 'tersedia',
        ];
    }
}
