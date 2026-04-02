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
        Schema::create('speakers', function (Blueprint $table) {
           $table->id('speaker_id'); 
           $table->string('full_name', 150);
           $table->string('title', 120)->nullable();
           $table->string('company', 150)->nullable();
            $table->text('bio')->nullable();
            $table->string('email', 190)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('photo_url', 500)->nullable();
            
            // tinyint(1) defaults to boolean in Laravel
            $table->enum('status', ['active', 'inactive'])->default('active');
            
            // Matches the datetime NOT NULL DEFAULT CURRENT_TIMESTAMP behavior
            $table->timestamps(); 
            // Adding the index for full_name
            $table->index('full_name', 'idx_speakers_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speakers');
    }
};
