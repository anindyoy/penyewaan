<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Mobil;
use App\Models\Pinjam;
use App\Models\Peminjam;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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

            // Jika pernah dipinjam, mulai sewa berikutnya 1 hari setelah selesai sebelumnya
            // Jika belum pernah, mulai dari hari ini
            $mulai = $lastBooking
                ? Carbon::parse($lastBooking->tanggal_selesai_rencana)->addDays(1)
                : Carbon::now()->addDays(rand(-10, 0));

            $tipeSewa = collect(['jam', 'hari'])->random();

            // Tentukan durasi: jika jam (2-12 jam), jika hari (1-5 hari)
            $selesai = $tipeSewa === 'jam'
                ? (clone $mulai)->addHours(rand(2, 12))
                : (clone $mulai)->addDays(rand(1, 5));

            Pinjam::create([
                'peminjam_id' => $peminjam->id,
                'mobil_id' => $mobil->id,
                'tipe_sewa' => $tipeSewa,
                'tanggal_mulai' => $mulai,
                'tanggal_selesai_rencana' => $selesai,
                'tanggal_kembali_aktual' => $mulai->isPast() ? (clone $selesai)->addHours(rand(0, 5)) : null,
                'km_awal' => rand(10000, 20000),
                'km_akhir' => $mulai->isPast() ? rand(20100, 21000) : null,
                'status_sewa' => $mulai->isFuture() ? 'dipesan' : ($mulai->isPast() && $selesai->isFuture() ? 'berjalan' : 'kembali'),
                'catatan_kondisi' => 'Kondisi fisik mulus hasil seeder.',
            ]);
        }
    }
}
