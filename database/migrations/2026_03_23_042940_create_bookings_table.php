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
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained('schedules')->nullOnDelete();
            $table->string('customer_name');
            $table->string('booking_code')->unique();
            $table->date('pickup_date');
            $table->time('pickup_time');
            $table->string('phone_number');
            $table->string('email');
            $table->string('area');
            $table->text('pickup_location');
            $table->integer('total_passengers');
            $table->string('destination');
            $table->decimal('base_price', 12, 2);
            $table->decimal('pickup_fee', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2);
            $table->enum('status', ['pending', 'confirmed','scheduled','on_progress','completed','cancelled', 'cancel_request'])->default('pending');
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
