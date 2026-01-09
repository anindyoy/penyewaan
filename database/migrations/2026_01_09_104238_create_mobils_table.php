<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->id();
            $table->string('merek');            // Toyota, Honda
            $table->string('model');            // Avanza, Civic
            $table->string('nomor_plat')->unique();
            $table->string('warna');
            $table->year('tahun_produksi');
            $table->enum('status', ['tersedia', 'dipinjam', 'perbaikan', 'dipesan'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};
