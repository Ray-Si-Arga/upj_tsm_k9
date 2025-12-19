<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Ubah dari ENUM menjadi STRING (Teks Bebas)
            // Note: Kita butuh paket doctrine/dbal. Jika error, jalankan: composer require doctrine/dbal
            $table->string('vehicle_type')->change();
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Kembalikan ke ENUM jika di-rollback
            $table->enum('vehicle_type', ['matic', 'bebek', 'cup', 'sport'])->change();
        });
    }
};
