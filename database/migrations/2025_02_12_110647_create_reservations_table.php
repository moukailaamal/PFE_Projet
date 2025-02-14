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
            $table->foreignId('client_id')->constrained('users');  // Liaison avec la table users
        $table->foreignId('technicien_id')->constrained('users');  // Liaison avec la table users
        $table->foreignId('service_id')->constrained('services');  // Liaison avec services
        $table->dateTime('date_rdv');
        $table->enum('statut', ['en_attente', 'confirmée', 'annulée', 'terminée']);
        $table->dateTime('date_creation');
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
