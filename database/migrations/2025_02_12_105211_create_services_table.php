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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('technicien_id')->constrained('users');  // Liaison avec la table users
            $table->foreignId('categorie_id')->constrained('categories_services');  // Liaison avec categories_services
            $table->string('titre', 150);
            $table->text('description');
            $table->decimal('tarif', 8, 2);
            $table->dateTime('date_creation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
