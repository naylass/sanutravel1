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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('name');
             $table->string('email')->nullable();
            $table->string('phone');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->text('address');
            $table->text('medical_history');
            $table->string('license_number', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};