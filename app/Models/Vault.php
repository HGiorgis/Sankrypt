<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vault extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'category',
        'encrypted_data',
        'encryption_salt',
        'data_hash',
        'version',
        'last_accessed_at'
    ];

    protected $casts = [
        'last_accessed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function touchLastAccessed()
    {
        $this->update(['last_accessed_at' => now()]);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) \Illuminate\Support\Str::uuid();
            }
            if (empty($model->version)) {
                $model->version = '1.0';
            }
        });
    }
}