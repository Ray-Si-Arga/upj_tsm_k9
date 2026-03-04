<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->dropColumn('event_id');
            // Pastikan kolom date unik (satu jadwal per tanggal)
            $table->unique('date');
        });
    }

    public function down(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->dropUnique(['date']);
            $table->string('event_id')->nullable()->comment('ID dari bengkel-calendar widget');
        });
    }
};
