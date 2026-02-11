<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 'draft';

    const STATUS_SUBMITTED = 'submitted';

    const STATUS_VERIFIED = 'verified';

    const STATUS_VALIDATED = 'validated';

    const STATUS_RELEASED = 'released';

    const STATUS_REJECTED = 'rejected';

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
        'verification_notes',
        'validated_by',
        'validated_at',
        'validation_notes',
        'released_by',
        'released_at',
    ];

    protected $casts = [
        'filled_at' => 'date',
        'verified_at' => 'datetime',
        'validated_at' => 'datetime',
        'released_at' => 'datetime',
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

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function releaser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'released_by');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePendingVerification($query)
    {
        return $query->where('status', self::STATUS_SUBMITTED);
    }

    public function scopePendingValidation($query)
    {
        return $query->where('status', self::STATUS_VERIFIED);
    }

    public function scopeReleased($query)
    {
        return $query->where('status', self::STATUS_RELEASED);
    }

    public function isVerified(): bool
    {
        return in_array($this->status, [self::STATUS_VERIFIED, self::STATUS_VALIDATED, self::STATUS_RELEASED]);
    }

    public function isValidated(): bool
    {
        return in_array($this->status, [self::STATUS_VALIDATED, self::STATUS_RELEASED]);
    }

    public function isReleased(): bool
    {
        return $this->status === self::STATUS_RELEASED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isSubmitted(): bool
    {
        return $this->status === self::STATUS_SUBMITTED;
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
