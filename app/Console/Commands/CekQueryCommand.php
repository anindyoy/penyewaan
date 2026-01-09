<?php

namespace App\Console\Commands;

use App\Models\Mobil;
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
        dd(
            fake()->randomElements(['Ketua', 'Karyawan', 'Supir', 'Pemateri'])[0]
        );
    }
}
