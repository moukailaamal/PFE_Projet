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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations')->nullable();
            $table->foreignId('client_id')->constrained('users'); // Supposant que clients sont dans la table users
            $table->foreignId('technician_id')->constrained('users'); // Supposant que techniciens sont aussi dans users
            $table->decimal('amount', 8, 2);
            $table->enum('payment_method', ['online', 'cash']);
            $table->enum('status', ['paid', 'pending', 'refunded', 'failed']);
            $table->dateTime('payment_date')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
