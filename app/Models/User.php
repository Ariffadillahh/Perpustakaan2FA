<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'google2fa_secret',
        'two_factor_enabled',
        'role_id',
        'email_verified_at',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'google2fa_secret',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'two_factor_enabled' => 'boolean',
        'is_active' => 'boolean',
        'email' => 'encrypted',
        'phone_number' => 'encrypted',
        'google2fa_secret' => 'encrypted',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function backups()
    {
        return $this->hasMany(Backup::class, 'backup_by');
    }
}
