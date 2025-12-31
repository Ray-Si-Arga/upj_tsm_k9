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
        Schema::table('service_advisors', function (Blueprint $table) {
            // Pilihan: 'hubungi' atau 'langsung'
            $table->string('pkb_approval')->default('hubungi');
            // Pilihan: Part bekas dibawa pulang? (1=Ya, 0=Tidak)
            $table->boolean('part_bekas_dibawa')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_advisors', function (Blueprint $table) {
            //
        });
    }
};
