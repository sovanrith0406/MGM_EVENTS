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
        Schema::create('mailbox_messages', function (Blueprint $table) {
            // PRIMARY KEY (`message_id`)
            $table->id('message_id'); 
            
            // `event_id` bigint DEFAULT NULL
            $table->bigInteger('event_id')->nullable();
            
            // `sender_name` varchar(150) DEFAULT NULL
            $table->string('sender_name', 150)->nullable();
            
            // `sender_email` varchar(190) DEFAULT NULL
            $table->string('sender_email', 190)->nullable();
            
            // `recipient_email` varchar(190) DEFAULT NULL
            $table->string('recipient_email', 190)->nullable();
            
            // `subject` varchar(200) NOT NULL
            $table->string('subject', 200);
            
            // `body` text NOT NULL
            $table->text('body');
            
            // `folder` enum('inbox','sent','draft','trash') NOT NULL DEFAULT 'inbox'
            $table->enum('folder', ['inbox', 'sent', 'draft', 'trash'])->default('inbox');
            
            // `is_read` tinyint(1) NOT NULL DEFAULT '0'
            $table->boolean('is_read')->default(false);
            
            // `created_by` bigint DEFAULT NULL
            $table->bigInteger('created_by')->nullable();
            
            // `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->dateTime('created_at')->useCurrent();

            // -------------------------------------------------------------------
            // Indexes
            // -------------------------------------------------------------------
            
            // KEY `fk_mail_user` (`created_by`)
            $table->index('created_by', 'fk_mail_user');
            
            // KEY `idx_mail_folder_read` (`folder`,`is_read`)
            $table->index(['folder', 'is_read'], 'idx_mail_folder_read');
            
            // KEY `idx_mail_event` (`event_id`)
            $table->index('event_id', 'idx_mail_event');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mailbox_messages');
    }
};