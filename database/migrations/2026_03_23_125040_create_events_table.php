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
        Schema::create('events', function (Blueprint $table) {
            // Primary Key
            $table->bigIncrements('event_id');
            
            // Relationship to Venue
            $table->foreignId('venue_id')->nullable()->constrained('venues');
            
            // Basic Info
            $table->string('event_name', 180);
            $table->text('description')->nullable();
            
            // Timing & Locality
            $table->date('start_date');
            $table->date('end_date');
            $table->string('timezone', 64)->default('UTC');

            // Status
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');

            // Audit Trail
            $table->foreignId('created_by')->constrained('users'); // Assuming a users table
            
            // Timestamps (matches your DEFAULT CURRENT_TIMESTAMP ON UPDATE logic)
            $table->timestamps();

            // Indexes
            $table->index(['start_date', 'end_date'], 'idx_events_dates');
            $table->index('status', 'idx_events_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
