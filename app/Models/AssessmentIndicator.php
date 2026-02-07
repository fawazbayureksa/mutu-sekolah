<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'aspect_id',
        'code',
        'description',
        'order',
    ];

    public function aspect(): BelongsTo
    {
        return $this->belongsTo(AssessmentAspect::class, 'aspect_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(AssessmentQuestion::class, 'indicator_id')->orderBy('order');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
