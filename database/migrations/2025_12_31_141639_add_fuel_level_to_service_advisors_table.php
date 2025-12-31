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
            $table->string('fuel_level')->nullable(); // Menyimpan: 0, 25, 50, 75, 100
        });
    }

    public function down()
    {
        Schema::table('service_advisors', function (Blueprint $table) {
            $table->dropColumn('fuel_level');
        });
    }
};
