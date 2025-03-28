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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations')->nullable()->constrained(); 
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade'); // Nouveau champ : receiver_id
            $table->text('content');
            $table->dateTime('send_date')->useCurrent(); // Utilisation de useCurrent() pour la date actuelle par défaut
            $table->boolean('is_read')->default(false); // Nouveau champ : is_read
            $table->enum('message_type', ['text', 'file', 'image', 'pdf'])->default('text'); // Type de message
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};