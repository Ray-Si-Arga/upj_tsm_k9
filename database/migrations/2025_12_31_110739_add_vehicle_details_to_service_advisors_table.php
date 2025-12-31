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
            $table->integer('odometer')->nullable(); // KM
            $table->year('vehicle_year')->nullable(); // Tahun
            $table->string('engine_number')->nullable(); // No Mesin
            $table->string('chassis_number')->nullable(); // No Rangka
            $table->string('customer_email')->nullable();
            $table->string('customer_social')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('service_advisors', function (Blueprint $table) {
            $table->dropColumn(['odometer', 'vehicle_year', 'engine_number', 'chassis_number', 'customer_email', 'customer_social']);
        });
    }
};
