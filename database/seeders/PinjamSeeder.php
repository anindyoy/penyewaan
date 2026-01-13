<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mobil;
use App\Models\Pinjam;
use App\Models\Peminjam;
use Illuminate\Database\Seeder;

class PinjamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Pastikan ada data Mobil dan Peminjam
        $mobils = Mobil::all();
        if ($mobils->isEmpty()) {
            $mobils = Mobil::factory(5)->create();
        }

        $peminjams = Peminjam::all();
        if ($peminjams->isEmpty()) {
            $peminjams = Peminjam::factory(10)->create();
        }

        // 2. Loop untuk membuat 10 data pinjam yang valid
        for ($i = 0; $i < 10; $i++) {
            $mobil = $mobils->random();
            $peminjam = $peminjams->random();

            // Mencari waktu terakhir mobil ini selesai digunakan
            $lastBooking = Pinjam::where('mobil_id', $mobil->id)
                ->orderBy('tanggal_selesai_rencana', 'desc')
                ->first();

            // Logika penentuan tanggal mulai
            $mulai = $lastBooking
                ? Carbon::parse($lastBooking->tanggal_selesai_rencana)->addDays(1)
                : Carbon::now()->addDays(rand(-10, 0));

            $tipeSewa = collect(['jam', 'hari'])->random();

            // Tentukan durasi
            $selesai = $tipeSewa === 'jam'
                ? (clone $mulai)->addHours(rand(2, 12))
                : (clone $mulai)->addDays(rand(1, 5));

            // Logika status pinjam
            $statusSewa = $mulai->isFuture()
                ? 'dipinjam'
                : (($mulai->isPast() && $selesai->isFuture()) ? 'dipinjam' : 'kembali');

            $pinjam = Pinjam::create([
                'peminjam_id' => $peminjam->id,
                'mobil_id' => $mobil->id,
                'user_id' => User::inRandomOrder()->first()->id,
                'tipe_sewa' => $tipeSewa,
                'tanggal_mulai' => $mulai,
                'tanggal_selesai_rencana' => $selesai,
                'tanggal_kembali_aktual' => $mulai->isPast() && $statusSewa === 'kembali' ? (clone $selesai)->addHours(rand(0, 5)) : null,
                'km_awal' => rand(10000, 20000),
                'km_akhir' => $mulai->isPast() && $statusSewa === 'kembali' ? rand(20100, 21000) : null,
                'status_sewa' => $statusSewa,
                'tujuan' => $this->faker->optional()->sentence(),
                'catatan_kondisi' => 'Kondisi fisik mulus hasil seeder.',
            ]);

            // 3. UPDATE STATUS MOBIL berdasarkan peminjaman terakhir (Hanya jika ini data terbaru)
            // Cek apakah data yang baru dibuat adalah jadwal yang paling terakhir untuk mobil ini
            $isLatest = !Pinjam::where('mobil_id', $mobil->id)
                ->where('tanggal_mulai', '>', $pinjam->tanggal_mulai)
                ->exists();

            if ($isLatest) {
                $statusMobil = 'tersedia'; // Default

                if ($statusSewa === 'dipinjam') {
                    $statusMobil = 'dipinjam';
                }

                $mobil->update([
                    'status' => $statusMobil
                ]);
            }
        }
    }
}
