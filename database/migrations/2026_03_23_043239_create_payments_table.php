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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->enum('payment_method', ['qris', 'cash', 'transfer']);
            $table->decimal('amount', 12, 2);
            $table->string('payment_proof')->nullable();
            $table->string('driver_proof')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->boolean('driver_received_cash')->default(false);
            $table->timestamp('driver_received_at')->nullable();
            $table->timestamp('settled_to_admin_at')->nullable();
            $table->enum('status', ['unpaid', 'waiting_verification', 'verified', 'rejected', 'waiting_driver_collection', 'cash_received', 'settled'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('driver_proof');
        });
    }
};
