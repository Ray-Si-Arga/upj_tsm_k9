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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->enum('vehicle_type', ['matic', 'bebek', 'cup', 'sport']);
        $table->string('plate_number');
        $table->dateTime('booking_date');
         $table->integer('queue_number')->nullable();
        $table->integer('quota')->default(1);
        $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
        $table->string('customer_name');
        $table->string('customer_whatsapp');
        $table->enum('status', ['pending', 'approved', 'on_progress', 'done', 'cancelled'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
