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
        Schema::create('user_settings', function (Blueprint $table) {
            // `user_id` bigint NOT NULL
            $table->bigInteger('user_id');
            
            // `setting_key` varchar(80) NOT NULL
            $table->string('setting_key', 80);
            
            // `setting_value` varchar(500) DEFAULT NULL
            $table->string('setting_value', 500)->nullable();
            
            // `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();

            // PRIMARY KEY (`user_id`, `setting_key`)
            $table->primary(['user_id', 'setting_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};