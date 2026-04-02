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
        Schema::create('schedule_speaker', function (Blueprint $table) {
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('speaker_id');

            $table->primary(['schedule_id', 'speaker_id']);

            $table->foreign('schedule_id')
                ->references('schedule_id')
                ->on('schedules')
                ->onDelete('cascade');

            $table->foreign('speaker_id')
                ->references('speaker_id')
                ->on('speakers')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_speaker');
    }
};
