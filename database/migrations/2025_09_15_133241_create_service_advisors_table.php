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
       Schema::create('service_advisors', function (Blueprint $table) {
    $table->id();
    $table->foreignId('booking_id')->constrained()->onDelete('cascade');
    $table->string('jobs')->nullable(); // list pekerjaan
    $table->decimal('estimation_cost', 12, 2)->default(0);
    $table->json('spareparts')->nullable(); // array sparepart [name, price]
    $table->decimal('estimation_parts', 12, 2)->default(0);
    $table->decimal('total_estimation', 12, 2)->default(0);
    $table->text('customer_complaint')->nullable();
    $table->text('advisor_notes')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_advisors');
    }
};
