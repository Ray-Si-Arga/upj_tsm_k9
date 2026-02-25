<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();

            // Tipe transaksi: 'pemasukan' atau 'pengeluaran'
            $table->enum('tipe', ['pemasukan', 'pengeluaran']);

            // Judul / label singkat transaksi
            $table->string('judul');

            // Nominal transaksi
            $table->decimal('nominal', 15, 2);

            // Sumber asal transaksi: 'service', 'inventory', 'manual'
            $table->string('sumber')->default('manual');

            // Kategori lebih spesifik: 'service', 'inventory', 'gaji', 'listrik', dll
            $table->string('kategori')->nullable();

            // Keterangan tambahan (opsional)
            $table->text('keterangan')->nullable();

            // Referensi ke tabel lain (opsional, untuk traceability)
            $table->unsignedBigInteger('referensi_id')->nullable();

            $table->timestamps();

            // Index untuk query performa
            $table->index(['tipe', 'created_at']);
            $table->index('sumber');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};