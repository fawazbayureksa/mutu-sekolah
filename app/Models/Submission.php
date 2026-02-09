<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'instrument_id',
        'respondent_name',
        'respondent_position',
        'filled_at',
        'status',
        'total_score',
        'max_possible_score',
        'completion_percentage',
        'verified_by',
        'verified_at',
        'validation_notes',
    ];

    protected $casts = [
        'filled_at' => 'date',
        'verified_at' => 'datetime',
        'total_score' => 'decimal:2',
        'max_possible_score' => 'decimal:2',
        'completion_percentage' => 'decimal:2',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function isVerified(): bool
    {
        return in_array($this->status, ['verified', 'validated']);
    }

    public function isValidated(): bool
    {
        return $this->status === 'validated';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    public function calculateTotalScore(): float
    {
        return $this->responses()->sum('score');
    }

    public function getCompletionPercentage(): float
    {
        $total = $this->instrument->items()->count();
        $answered = $this->responses()->count();

        return $total > 0 ? ($answered / $total) * 100 : 0;
    }
}
