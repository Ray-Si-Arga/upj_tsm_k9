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
            // Data Pembawa
            $table->string('carrier_name')->nullable();
            $table->string('carrier_address')->nullable();
            $table->string('carrier_area')->nullable(); // Kel/Kec
            $table->string('carrier_phone')->nullable();
            $table->string('relationship')->nullable(); // Hubungan

            // Data Pemilik
            $table->string('owner_name')->nullable();
            $table->string('owner_address')->nullable();
            $table->string('owner_area')->nullable();
            $table->string('owner_phone')->nullable();

            // Survey
            $table->boolean('is_own_dealer')->default(false); // Dealer sendiri
            $table->string('visit_reason')->nullable(); // Alasan ke AHASS
        });
    }

    public function down()
    {
        Schema::table('service_advisors', function (Blueprint $table) {
            $table->dropColumn([
                'carrier_name',
                'carrier_address',
                'carrier_area',
                'carrier_phone',
                'relationship',
                'owner_name',
                'owner_address',
                'owner_area',
                'owner_phone',
                'is_own_dealer',
                'visit_reason'
            ]);
        });
    }
};
