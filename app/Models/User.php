<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    // ✅ Match actual primary key
    protected $primaryKey = 'user_id';

    // Make sure 'password' is NOT in $guarded
    protected $guarded = [];   // ← if this exists, it blocks everything not listed

    // OR make sure 'password' IS in $fillable
    protected $fillable = [
        'full_name',
        'email',
        'password_hash',   // ← must be here if using $fillable
        'role_id',
        'avatar_url',
        'is_active',
    ];

    protected $hidden = ['password_hash', 'remember_token'];

    // ✅ Tell Laravel the password column is 'password_hash'
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
    // In User.php
    public function getAvatarAttribute(): string
    {
        return $this->avatar_url
            ? Storage::url($this->avatar_url)
            : asset('images/default-avatar.png');
    }
    // ✅ Relationship to roles table
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    // ── Role helpers ──────────────────────────────────────────────────────────
    public function isAdmin(): bool
    {
        return (int) $this->role_id === 1;
    }

    public function isUser(): bool
    {
        return (int) $this->role_id === 2;
    }

    public function isSupplier(): bool
    {
        return (int) $this->role_id === 3;
    }
    
}