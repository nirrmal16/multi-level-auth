<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class User extends Authenticatable
{
public function role(): BelongsTo
{
    return $this->belongsTo(Role::class);
}

public function isAdmin(): bool
{
    return $this->role->name === 'admin';
}

public function isManager(): bool
{
    return $this->role->name === 'manager';
}

public function isEmployee(): bool
{
    return $this->role->name === 'employee';
}
}