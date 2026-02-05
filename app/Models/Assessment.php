<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Assessment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'school_id',
        'respondent_name',
        'respondent_position',
        'filled_at',
        'period_year',
        'status',
        'submitted_at',
        'instrument_id',
        'total_score',
        'max_possible_score',
        'percentage',
        'grade',
        'academic_year',
        'semester',
        'assessment_type',
        'total_questions',
        'answered_questions',
        'completion_percentage',
        'started_at',
        'completed_at',
        'duration_minutes',
        'verified_by',
        'verified_at',
        'verification_notes',
        'approved_by',
        'approved_at',
        'approval_notes',
        'remarks',
        'metadata',
    ];

    protected $casts = [
        'filled_at' => 'date',
        'submitted_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'deleted_at' => 'datetime',
        'total_score' => 'decimal:2',
        'max_possible_score' => 'decimal:2',
        'percentage' => 'decimal:2',
        'completion_percentage' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(AssessmentAnswer::class);
    }

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('period_year', $year);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('assessment_type', $type);
    }

    public function calculateTotalScore(): float
    {
        return $this->answers()->sum('score');
    }

    public function calculatePercentage(): float
    {
        if ($this->max_possible_score == 0) {
            return 0;
        }
        return ($this->total_score / $this->max_possible_score) * 100;
    }

    public function calculateDuration(): ?int
    {
        if ($this->started_at && $this->completed_at) {
            return $this->started_at->diffInMinutes($this->completed_at);
        }
        return null;
    }

    public function updateProgress(): void
    {
        $answered = $this->answers()->count();
        $total = $this->total_questions ?: $this->instrument->items()->count();
        
        $this->update([
            'answered_questions' => $answered,
            'completion_percentage' => $total > 0 ? ($answered / $total) * 100 : 0,
        ]);
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }

    public function isApproved(): bool
    {
        return !is_null($this->approved_at);
    }

    public function canBeEdited(): bool
    {
        return in_array($this->status, ['draft']);
    }

    public function canBeSubmitted(): bool
    {
        return $this->status === 'draft';
    }

    public function canBeVerified(): bool
    {
        return $this->status === 'submitted';
    }

    public function canBeApproved(): bool
    {
        return !is_null($this->verified_at) && is_null($this->approved_at);
    }
}
