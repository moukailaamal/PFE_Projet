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
            $table->foreignId('client_id')->constrained('users') ->onDelete('cascade');
            $table->foreignId('technician_id')->constrained('users') ->onDelete('cascade');
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
