<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'author',
        'description',
        'thumbnail',
        'stock',
        'category_id',
        'release_year',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
