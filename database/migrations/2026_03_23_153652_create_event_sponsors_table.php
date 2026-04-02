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
        Schema::create('event_sponsors', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('sponsor_id');
            
            // Enum for the sponsorship tier
            $table->enum('tier', ['platinum', 'gold', 'silver', 'bronze', 'partner'])
                ->default('partner');
            
            // Decimal for the money amount (12 digits total, 2 after the decimal)
            $table->decimal('amount', 12, 2)->nullable();

            // Defining the Composite Primary Key
            $table->primary(['event_id', 'sponsor_id']);

            // Adding an index for the tier for faster filtering
            $table->index('tier', 'idx_es_tier');

            /* Optional: Add Foreign Key constraints if your 'events' 
            and 'sponsors' tables already exist.
            */
            // $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            // $table->foreign('sponsor_id')->references('sponsor_id')->on('sponsors')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_sponsors');
    }
};
