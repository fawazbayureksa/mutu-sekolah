<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_name',
        'npsn',
        'province',
        'city',
    ];

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    /**
     * Get all submissions for this school.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Get the latest submission for this school.
     */
    public function latestSubmission()
    {
        return $this->hasOne(Submission::class)->latestOfMany('filled_at');
    }
}
