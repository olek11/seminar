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
        Schema::create('ruang', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama ruang seminar, harus unik
            $table->string('kode'); // Kapasitas maksimum orang
            $table->string('lokasi'); // Lokasi ruang seminar
            $table->enum('status', ['tersedia', 'ada permintaan', 'sedang dipakai'])->default('tersedia'); // Status ruang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruang');
    }
};
