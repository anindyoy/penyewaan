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

        // 3. Cari mobil yang berstatus 'dipinjam'
        // Logika: Ada booking di masa depan hari ini, dan mobil tidak sedang dipinjam
        $mobilDipesan = Pinjam::where('status_sewa', 'dipinjam')
            ->where('tanggal_mulai', '>', $now)
            ->where('tanggal_mulai', '<=', $now->clone()->endOfDay())
            ->pluck('mobil_id');

        // Update status ke 'dipinjam' hanya jika mobil saat ini 'tersedia'
        Mobil::whereIn('id', $mobilDipesan)
            ->where('status', 'tersedia')
            ->update(['status' => 'dipinjam']);

        $this->info('Update status mobil berhasil diselesaikan.');
    }
}