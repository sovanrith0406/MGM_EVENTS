<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailboxMessage extends Model
{
    protected $primaryKey = 'message_id';
    public $timestamps    = false; // table has created_at but no updated_at

    protected $fillable = [
        'event_id',
        'sender_name',
        'sender_email',
        'recipient_email',
        'subject',
        'body',
        'folder',
        'is_read',
        'created_by',
        'created_at',
    ];

    protected $casts = [
        'is_read'    => 'boolean',
        'created_at' => 'datetime',
    ];

    // Sender user (via email)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_email', 'email');
    }

    // Recipient user (via email)
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_email', 'email');
    }
}