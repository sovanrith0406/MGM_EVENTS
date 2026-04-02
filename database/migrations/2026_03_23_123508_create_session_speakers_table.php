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
       Schema::create('session_speakers', function (Blueprint $table) {
        $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
        $table->foreignId('speaker_id')->constrained()->onDelete('cascade');
        
        // Adding the Enum with a default value
        $table->enum('speaker_role', ['speaker', 'moderator', 'panelist'])
              ->default('speaker');

        // Setting the composite primary key
        $table->primary(['schedule_id', 'speaker_id']);
        
        //
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_speakers');
    }
};
