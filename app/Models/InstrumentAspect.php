<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstrumentAspect extends Model
{
    use HasFactory;

    protected $fillable = [
        'instrument_id',
        'aspect_id',
        'order',
        'weight',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
    ];

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }

    public function aspect(): BelongsTo
    {
        return $this->belongsTo(AssessmentAspect::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
