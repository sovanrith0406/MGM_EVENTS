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
        Schema::create('sponsors', function (Blueprint $table) {
           // Use sponsor_id as the primary key to match your SQL
        $table->id('sponsor_id'); 
        
        $table->string('name', 180)->index('idx_sponsors_name');
        $table->string('website', 255)->nullable();
        $table->string('logo_url', 500)->nullable();
        $table->string('contact_name', 150)->nullable();
        $table->string('contact_email', 190)->nullable();
        $table->string('contact_phone', 50)->nullable();
        
        // This creates both created_at and updated_at
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
