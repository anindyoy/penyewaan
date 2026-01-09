<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mobil;
use App\Models\Pinjam;
use App\Models\Peminjam;
use Illuminate\Database\Seeder;
use Database\Seeders\PinjamSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!User::count()) {
            $this->command->info('Creating admin user');
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now()
            ]);
        }

        if (!Mobil::count()) {
            $this->command->info('Creating 10 mobil');
            \App\Models\Mobil::factory(10)->create(['status' => 'tersedia']);
        }

        if (!Peminjam::count()) {
            $this->command->info('Creating 20 peminjam');
            \App\Models\Peminjam::factory(20)->create();
        }

        $this->call([PinjamSeeder::class]);
    }
}
