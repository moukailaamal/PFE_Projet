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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100); 
            $table->string('last_name', 100);
            $table->string('email', 150)->unique();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->enum('role', ['client', 'technician', 'admin','superAdmin']);
            $table->enum('gender', ['male', 'female', 'other']); 
            $table->string('address', 255)->nullable(); 
            $table->string('phone_number', 15)->nullable(); 
            $table->enum('status', ['active', 'rejected', 'pending'])->nullable();
            $table->dateTime('registration_date');
            
            // Email verification
            $table->timestamp('email_verified_at')->nullable();
        
            $table->rememberToken();
            $table->timestamps();
        });
        
        // Rest of your migration remains the same...
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};