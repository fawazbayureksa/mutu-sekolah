<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AssessmentAspect extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'order',
    ];

    public function indicators(): HasMany
    {
        return $this->hasMany(AssessmentIndicator::class, 'aspect_id')->orderBy('order');
    }

    public function questions(): HasMany
    {
        return $this->hasManyThrough(AssessmentQuestion::class, AssessmentIndicator::class, 'aspect_id', 'indicator_id')->orderBy('order');
    }

    public function instruments(): BelongsToMany
    {
        return $this->belongsToMany(Instrument::class, 'instrument_aspects', 'aspect_id', 'instrument_id')
            ->withPivot(['order', 'weight'])
            ->orderBy('pivot_order');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
