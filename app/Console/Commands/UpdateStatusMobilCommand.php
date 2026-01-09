<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Mobil;
use App\Models\Pinjam;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateStatusMobilCommand extends Command
{
    // Nama command yang akan dipanggil di terminal
    protected $signature = 'mobil:update-status';

    // Deskripsi command
    protected $description = 'Update status mobil berdasarkan jadwal peminjaman saat ini';

    public function handle()
    {
        $now = Carbon::now();
        $this->info("Memulai update status mobil pada: " . $now->toDateTimeString());

        // 1. Set semua mobil ke 'tersedia' terlebih dahulu sebagai default
        // Kecuali mobil yang sedang dalam 'perbaikan'
        Mobil::where('status', '!=', 'perbaikan')->update(['status' => 'tersedia']);

        // 2. Cari mobil yang HARUSNYA berstatus 'dipinjam' (status_sewa berjalan)
        // Logika: Sekarang berada di antara tanggal mulai dan rencana selesai
        $mobilDipinjam = Pinjam::where('status_sewa', 'berjalan')
            ->where('tanggal_mulai', '<=', $now)
            ->where(function($query) use ($now) {
                $query->whereNull('tanggal_kembali_aktual')
                      ->orWhere('tanggal_kembali_aktual', '>', $now);
            })
            ->pluck('mobil_id');

        Mobil::whereIn('id', $mobilDipinjam)->update(['status' => 'dipinjam']);

        // 3. Cari mobil yang berstatus 'dipesan'
        // Logika: Ada booking di masa depan hari ini, dan mobil tidak sedang dipinjam
        $mobilDipesan = Pinjam::where('status_sewa', 'dipesan')
            ->where('tanggal_mulai', '>', $now)
            ->where('tanggal_mulai', '<=', $now->clone()->endOfDay())
            ->pluck('mobil_id');

        // Update status ke 'dipesan' hanya jika mobil saat ini 'tersedia'
        Mobil::whereIn('id', $mobilDipesan)
            ->where('status', 'tersedia')
            ->update(['status' => 'dipesan']);

        $this->info('Update status mobil berhasil diselesaikan.');
    }
}