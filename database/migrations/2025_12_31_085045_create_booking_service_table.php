<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('booking_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // OOPSIONAL: Hapus kolom service_id dari tabel bookings agar tidak membingungkan
        // Tapi jika takut data lama hilang, biarkan saja dulu, kita hanya tidak akan memakainya lagi.
        /*
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['service_id']);
            $table->dropColumn('service_id');
        });
        */
    }

    public function down()
    {
        Schema::dropIfExists('booking_service');
    }
};
