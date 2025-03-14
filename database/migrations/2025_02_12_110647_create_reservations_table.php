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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users');
            $table->foreignId('technician_id')->constrained('users');
            $table->foreignId('service_id')->constrained('services');
            $table->dateTime('appointment_date');
            $table->enum('status', ['pending', 'confirmed', 'canceled', 'completed']);
            $table->dateTime('creation_date');
            $table->enum('reservation_type', ['instant', 'quote_request'])->default('instant');
            $table->integer('duration')->nullable(); // Durée en minutes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
