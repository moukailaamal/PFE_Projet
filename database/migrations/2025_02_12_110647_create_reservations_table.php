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
            $table->foreignId('client_id')->constrained('users') ->onDelete('cascade');
            $table->foreignId('technician_id')->constrained('users') ->onDelete('cascade');
            $table->dateTime('appointment_date');
            $table->string('address')->nullable(); 
            $table->string('notes')->nullable(); 
            $table->enum('status', ['pending', 'confirmed', 'canceled', 'completed']);
            $table->dateTime('creation_date');
            $table->enum('reservation_type', ['instant', 'quote_request'])->default('instant');
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
