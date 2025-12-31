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
        Schema::table('bookings', function (Blueprint $table) {
            // Ubah kolom service_id agar boleh kosong (NULL)
            // Karena kita sekarang pakai tabel pivot (booking_service)
            $table->unsignedBigInteger('service_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Kembalikan jadi wajib diisi (jika di-rollback)
            $table->unsignedBigInteger('service_id')->nullable(false)->change();
        });
    }
};

