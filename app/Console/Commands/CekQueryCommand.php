<?php

namespace App\Console\Commands;

use App\Models\Mobil;
use App\Models\Pinjam;
use Illuminate\Console\Command;

class CekQueryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cek:query';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $mobil = Mobil::whereModel('Ertiga')->first();
        // $latest = Pinjam::where('mobil_id', $mobil->id)
        //     ->where('tanggal')
        //     ->latest()->first();

        // if ($isLatest) {
        //     $statusMobil = 'tersedia'; // Default

        //     if ($statusSewa === 'berjalan') {
        //         $statusMobil = 'dipinjam';
        //     } elseif ($statusSewa === 'dipinjam') {
        //         $statusMobil = 'dipinjam';
        //     }

        //     $mobil->update([
        //         'status' => $statusMobil
        //     ]);
        // }
        dd(
            // Pinjam::factory()->create([''])
        );
    }
}
