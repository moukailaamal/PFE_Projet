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
        Schema::create('techniciens_details', function (Blueprint $table) {
            $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Clé étrangère vers la table users
        $table->string('specialty', 100)->nullable();
        $table->decimal('rate', 10, 2)->nullable();
        $table->text('availability')->nullable();
        $table->text('description')->nullable();
        $table->string('certificat_path')->nullable();
        $table->string('identite_path')->nullable(); // Stocke le chemin de la pièce d'identité
        $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending'); // État de la vérification
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('techniciens_details');
    }
};
