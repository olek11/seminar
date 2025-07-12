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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruang_id')->constrained('ruang')->onDelete('cascade'); // Relasi ke tabel ruang
            $table->string('Name'); // Nama pemesan (opsional)
            $table->string('NIM'); // nim pemesan (opsional)
            $table->date('tanggal_peminjaman'); // Tanggal peminjaman
            $table->time('waktu_mulai'); // Waktu mulai
            $table->time('waktu_selesai'); // Waktu selesai
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu'); // Status peminjaman
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
