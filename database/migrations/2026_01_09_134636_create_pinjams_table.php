<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pinjam', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjam_id')->constrained('peminjam')->onDelete('cascade');
            $table->foreignId('mobil_id')->constrained('mobil')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Tipe sewa untuk menentukan perhitungan harga
            $table->enum('tipe_sewa', ['jam', 'hari']);

            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai_rencana');
            $table->dateTime('tanggal_kembali_aktual')->nullable();

            // Pemantauan Kilometer
            $table->integer('km_awal')->nullable();
            $table->integer('km_akhir')->nullable();

            $table->enum('status_sewa', ['dipinjam', 'kembali', 'terlambat', 'dibatalkan'])->default('dipinjam');
            $table->string('tujuan', 150)->nullable();
            $table->text('catatan_kondisi')->nullable(); // Contoh: lecet di pintu kanan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjam');
    }
};
