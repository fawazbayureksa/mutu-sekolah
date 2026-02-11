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
        'update_token',
        'update_token_used_at',
        'update_token_expires_at',
        'validated_by',
        'validated_at',
        'validation_notes',
        'released_by',
        'released_at',
    ];

    protected $casts = [
        'filled_at' => 'date',
        'verified_at' => 'datetime',
        'update_token_used_at' => 'datetime',
        'update_token_expires_at' => 'datetime',
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

    public function generateUpdateToken(): string
    {
        // Generate a short random token (8 characters alphanumeric)
        // Use cryptographically secure random generation
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $token = '';
        $max = strlen($characters) - 1;
        
        for ($i = 0; $i < 8; $i++) {
            $token .= $characters[random_int(0, $max)];
        }
        
        // Ensure uniqueness
        while (self::where('update_token', $token)->exists()) {
            $token = '';
            for ($i = 0; $i < 8; $i++) {
                $token .= $characters[random_int(0, $max)];
            }
        }
        
        $this->update([
            'update_token' => $token,
            'update_token_expires_at' => now()->addDays(7), // Token expires in 7 days
            'update_token_used_at' => null, // Reset if regenerated
        ]);
        
        return $token;
    }

    public function isUpdateTokenValid(): bool
    {
        if (!$this->update_token) {
            return false;
        }

        // Token already used
        if ($this->update_token_used_at) {
            return false;
        }

        // Token expired
        if ($this->update_token_expires_at && $this->update_token_expires_at->isPast()) {
            return false;
        }

        return true;
    }

    public function markTokenAsUsed(): void
    {
        $this->update([
            'update_token_used_at' => now(),
        ]);
    }
}
