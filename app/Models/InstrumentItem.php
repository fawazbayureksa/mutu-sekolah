<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstrumentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'instrument_id',
        'section',
        'indicator_code',
        'indicator_text',
        'answer_type',
    ];

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }
}
