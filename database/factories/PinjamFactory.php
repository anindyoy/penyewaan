<?php

namespace Database\Factories;

use App\Models\Mobil;
use App\Models\Peminjam;
use Illuminate\Database\Eloquent\Factories\Factory;

class PinjamFactory extends Factory
{
    public function definition(): array
    {
        $mulai = $this->faker->dateTimeBetween('-1 month', '+1 month');
        // Rencana selesai antara 2 jam sampai 3 hari setelah mulai
        $selesai = (clone $mulai)->modify('+' . rand(2, 72) . ' hours');

        return [
            'peminjam_id' => Peminjam::inRandomOrder()->first() ?? Peminjam::factory(), // Otomatis buat peminjam baru
            'mobil_id' => Mobil::inRandomOrder()->first() ?? Mobil::factory(),       // Otomatis buat mobil baru
            'tipe_sewa' => $this->faker->randomElement(['jam', 'hari']),
            'tanggal_mulai' => $mulai,
            'tanggal_selesai_rencana' => $selesai,
            'tanggal_kembali_aktual' => $this->faker->optional(0.7)->dateTimeInInterval($mulai, '+5 days'),
            'km_awal' => $this->faker->numberBetween(10000, 50000),
            'km_akhir' => function (array $attributes) {
                return $attributes['km_awal'] + $this->faker->numberBetween(10, 500);
            },
            'status_sewa' => $this->faker->randomElement(['dipesan', 'berjalan', 'kembali', 'terlambat', 'dibatalkan']),
            'catatan_kondisi' => $this->faker->sentence(),
        ];
    }
}
