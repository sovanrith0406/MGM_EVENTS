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
        Schema::create('ticket_types', function (Blueprint $table) {
            // Primary Key
            $table->id('ticket_type_id');
            
            // Columns
            $table->unsignedBigInteger('event_id');
            $table->string('name', 120);
            $table->decimal('price', 12, 2)->default(0.00);
            $table->char('currency', 3)->default('USD');
            $table->integer('quota')->nullable();
            $table->dateTime('sale_start')->nullable();
            $table->dateTime('sale_end')->nullable();
            
            // tinyint(1) is best represented as a boolean in Laravel
            $table->boolean('is_active')->default(true);

            // Constraints & Indexes
            $table->unique(['event_id', 'name'], 'uk_ticket_event_name');
            $table->index('is_active', 'idx_ticket_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_types');
    }
};