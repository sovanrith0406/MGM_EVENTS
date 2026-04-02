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
        Schema::create('attendees', function (Blueprint $table) {
            // Primary Key
            $table->id('attendee_id');
            
            // Columns
            $table->unsignedBigInteger('order_item_id');
            $table->string('full_name', 150);
            $table->string('email', 190)->nullable();
            $table->string('phone', 50)->nullable();
            
            $table->enum('checkin_status', ['not_checked_in', 'checked_in'])
                  ->default('not_checked_in');
                  
            $table->dateTime('checkin_time')->nullable();

            // Indexes
            $table->index('order_item_id', 'fk_attendees_orderitem');
            $table->index('full_name', 'idx_attendees_name');
            $table->index('checkin_status', 'idx_attendees_checkin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendees');
    }
};