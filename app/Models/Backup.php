<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'file_name',
        'backup_by',
        'key',
        'backup_at',
    ];

    protected $casts = [
        'backup_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'backup_by');
    }
}
