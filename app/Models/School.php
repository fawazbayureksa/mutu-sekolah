<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'npsn',
        'name',
        'province',
        'city',
        'address',
    ];

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }
}
