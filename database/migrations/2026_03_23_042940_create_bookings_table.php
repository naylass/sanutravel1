<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->string('booking_code')->unique();
            $table->date('pickup_date')->nullable();
            $table->enum('pickup_type', ['reguler', 'eksklusif']);
            $table->time('pickup_time')->nullable();
            $table->string('phone_number');
            $table->unique(['phone_number', 'booking_code']);
            $table->string('pickup_location');
            $table->integer('total_passengers');
            $table->string('destination');
            $table->decimal('price', 12, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
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