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
            $table->foreignId('user_id')->constrained('users');  // Liaison avec la table users
            $table->string('specialite', 100);
            $table->decimal('tarif', 8, 2);
            $table->text('disponibilite');
            $table->string('certifications', 255);
            $table->text('description');
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
