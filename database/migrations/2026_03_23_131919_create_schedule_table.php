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
        Schema::create('schedule', function (Blueprint $table) {
            // Use increments or bigIncrements to set a custom PK name
            $table->bigIncrements('schedule_id'); 
            
            // Foreign Keys
            $table->foreignId('event_id')->index();
            $table->foreignId('track_id')->nullable()->constrained('tracks');
            $table->foreignId('room_id')->nullable()->constrained('rooms');

            // Content
            $table->string('title', 200);
            $table->text('description')->nullable();
            
            // Timing
            $table->dateTime('start_time');
            $table->dateTime('end_time');

            // Enums
            $table->enum('session_type', ['talk', 'workshop', 'panel', 'break', 'other'])
                ->default('talk');
            $table->enum('status', ['draft', 'published', 'cancelled'])
                ->default('draft');

            // Capacity
            $table->integer('capacity')->nullable();

            // Timestamps (matches your DEFAULT CURRENT_TIMESTAMP logic)
            $table->timestamps();

            // Manual Indexes
            // This handles your idx_sessions_event_time (event_id, start_time)
            $table->index(['event_id', 'start_time'], 'idx_sessions_event_time');
            $table->index('status', 'idx_sessions_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule');
    }
};
