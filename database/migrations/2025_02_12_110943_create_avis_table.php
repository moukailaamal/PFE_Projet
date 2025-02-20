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
            $table->foreignId('reservation_id')->constrained('reservations');
            $table->foreignId('client_id')->constrained('users');
            $table->foreignId('technicien_id')->constrained('users');
            $table->tinyInteger('rating');
            $table->text('comment');
            $table->dateTime('review_date');

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
