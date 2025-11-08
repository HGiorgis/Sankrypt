<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'email',
        'auth_key_hash',
        'api_key',
        'public_key',
        'encrypted_private_key',
        'security_settings',
        'preferences',
        'last_login_at',
        'password_changed_at',
    ];

    protected $hidden = [
        'auth_key_hash',
        'remember_token',
    ];

    protected $casts = [
        'security_settings' => 'array',
        'last_login_at' => 'datetime',
        'password_changed_at' => 'datetime',
    ];

    public function vaults()
    {
        return $this->hasMany(Vault::class);
    }

    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
}