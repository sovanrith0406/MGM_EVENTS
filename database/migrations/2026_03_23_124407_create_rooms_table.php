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
        Schema::create('rooms', function (Blueprint $table) {
           $table->bigIncrements('room_id');
        
            // Foreign Key to Venues
            $table->foreignId('venue_id')->constrained('venues')->onDelete('cascade');
            
            // Room Details
            $table->string('room_name', 120);
            $table->integer('capacity')->nullable();

            // Unique constraint: No duplicate room names within the same venue
            $table->unique(['venue_id', 'room_name'], 'uk_rooms_venue_name');
            
            // Optional: Adding timestamps if you want Laravel's standard tracking
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
