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
        Schema::create('venues', function (Blueprint $table) {
            // Custom Primary Key: venue_id
            $table->bigIncrements('venue_id');
            
            // Location & Name Details
            $table->string('venue_name', 150);
            $table->string('address', 255)->nullable();
            $table->string('city', 80)->nullable();
            $table->string('country', 80)->nullable();
            
            // Capacity
            $table->integer('capacity')->nullable();

            // Timestamps
            // Option A: Match your SQL exactly (Only created_at)
            $table->timestamp('created_at')->useCurrent();
            
            // Option B: Standard Laravel (Includes updated_at)
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
