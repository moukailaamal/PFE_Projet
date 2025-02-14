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
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations');  // Liaison avec reservations
            $table->foreignId('client_id')->constrained('users');  // Liaison avec la table users
            $table->foreignId('technicien_id')->constrained('users');  // Liaison avec la table users
            $table->tinyInteger('note');
            $table->text('commentaire');
            $table->dateTime('date_avis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
