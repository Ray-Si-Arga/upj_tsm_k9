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
            // Kolom untuk menyimpan durasi dalam MENIT (misal: 60)
            // Boleh kosong (nullable) kalau admin malas isi
            $table->integer('estimation_duration')->nullable()->after('queue_number');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('estimation_duration');
        });
    }
};
