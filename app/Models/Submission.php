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
        'verified_by',
        'verified_at',
        'validation_notes',
    ];

    protected $casts = [
        'filled_at' => 'date',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the school that owns the submission.
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Get the instrument that owns the submission.
     */
    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }

    /**
     * Get all responses for this submission.
     */
    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    /**
     * Get the user who verified this submission.
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check if submission is verified.
     */
    public function isVerified(): bool
    {
        return in_array($this->status, ['verified', 'validated']);
    }

    /**
     * Check if submission is validated.
     */
    public function isValidated(): bool
    {
        return $this->status === 'validated';
    }
}
