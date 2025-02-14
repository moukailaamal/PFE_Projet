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
            $table->foreignId('reservation_id')->constrained('reservations');  // Liaison avec reservations
            $table->decimal('montant', 8, 2);
            $table->enum('moyen_paiement', ['en_ligne', 'espèces']);
            $table->enum('statut', ['payé', 'en_attente', 'remboursé']);
            $table->dateTime('date_paiement');
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
