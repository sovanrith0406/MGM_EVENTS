<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->foreignId('event_id')->constrained('events', 'event_id')->onDelete('cascade');
            $table->string('supplier_name', 150);
            $table->string('description', 255)->nullable();
            $table->date('booking_date');
            $table->decimal('amount', 12, 2);
            $table->char('currency', 3)->default('USD');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'paid'])->default('pending');
            $table->foreignId('created_by')->nullable()->constrained('users', 'user_id')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_bookings');
    }
};