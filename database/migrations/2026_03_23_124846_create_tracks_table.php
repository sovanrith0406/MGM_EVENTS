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
        Schema::create('tracks', function (Blueprint $table) {
            // Custom Primary Key
            $table->bigIncrements('track_id');
            
            // Foreign Key to Events
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            
            // Track Details
            $table->string('track_name', 120);
            $table->integer('sort_order')->default(0);

            // Unique constraint: Prevent duplicate track names in the same event
            $table->unique(['event_id', 'track_name'], 'uk_tracks_event_name');

            // Optional: Laravel timestamps
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
