<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'indicator_id',
        'question_text',
        'answer_type',
        'weight',
        'order',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
    ];

    public function indicator(): BelongsTo
    {
        return $this->belongsTo(AssessmentIndicator::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(AssessmentAnswer::class);
    }
}
