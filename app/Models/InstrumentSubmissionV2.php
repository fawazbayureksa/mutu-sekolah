<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Province;
use App\Models\Regency;

class InstrumentSubmissionV2 extends Model
{
    use HasFactory;

    protected $table = 'instrument_submissions_v2';

    const STATUS_DRAFT = 'draft';

    const STATUS_SUBMITTED = 'submitted';

    const STATUS_VERIFIED = 'verified';

    const STATUS_VALIDATED = 'validated';

    const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'school_id',
        'school_name',
        'npsn',
        'address',
        'province_code',
        'regency_code',
        'expertise',
        'expertise_program',
        'expertise_concentration',
        'curriculum',
        'approval_status',
        'respondent_name',
        'respondent_position',
        'respondent_contact',
        'form_version',
        'answers',
        'section_notes',
        'status',
        'verified_by',
        'verified_at',
        'verification_notes',
        'validated_by',
        'validated_at',
        'validation_notes',
        'update_token',
        'update_token_used_at',
        'update_token_expires_at',
        'total_score',
        'max_possible_score',
        'completion_percentage',
        'filled_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'answers' => 'array',
        'section_notes' => 'array',
        'filled_at' => 'date',
        'verified_at' => 'datetime',
        'validated_at' => 'datetime',
        'update_token_used_at' => 'datetime',
        'update_token_expires_at' => 'datetime',
        'total_score' => 'decimal:2',
        'max_possible_score' => 'decimal:2',
        'completion_percentage' => 'decimal:2',
    ];

    /**
     * Get status for a specific section (e.g. 'approved' or 'rejected')
     */
    public function getSectionStatus(string $sectionCode): ?string
    {
        $notes = $this->section_notes ?? [];
        return $notes[$sectionCode]['status'] ?? null;
    }

    /**
     * Get notes for a specific section
     */
    public function getSectionNotes(string $sectionCode): ?string
    {
        $notes = $this->section_notes ?? [];
        return $notes[$sectionCode]['notes'] ?? null;
    }

    /**
     * Set review status and notes for a specific section
     */
    public function setSectionReview(string $sectionCode, ?string $status, ?string $notesText): void
    {
        $allNotes = $this->section_notes ?? [];
        $allNotes[$sectionCode] = [
            'status' => $status,
            'notes' => $notesText,
            'updated_at' => now()->toDateTimeString(),
        ];
        $this->section_notes = $allNotes;
    }

    /**
     * Get the school for this submission
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    /**
     * Get the province for this submission
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    /**
     * Get the regency for this submission
     */
    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class, 'regency_code', 'code');
    }

    /**
     * Get the details/sections for this submission
     */
    public function details(): HasMany
    {
        return $this->hasMany(InstrumentSubmissionV2Detail::class, 'submission_id');
    }

    /**
     * Get the verifier user
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get the validator user
     */
    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for pending verification
     */
    public function scopePendingVerification($query)
    {
        return $query->where('status', self::STATUS_SUBMITTED);
    }

    /**
     * Scope for verified submissions
     */
    public function scopeVerified($query)
    {
        return $query->where('status', self::STATUS_VERIFIED);
    }

    /**
     * Check if submission is editable
     */
    public function isEditable(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_REJECTED]);
    }

    /**
     * Check if update token is valid
     */
    public function hasValidUpdateToken(): bool
    {
        return $this->update_token
            && ! $this->update_token_used_at
            && $this->update_token_expires_at
            && $this->update_token_expires_at->isFuture();
    }

    /**
     * Generate update token
     */
    public function generateUpdateToken(int $expiresInHours = 999): string
    {
        $token = bin2hex(random_bytes(32));

        $this->update([
            'update_token' => $token,
            'update_token_expires_at' => now()->addHours($expiresInHours),
            'update_token_used_at' => null,
        ]);

        return $token;
    }

    /**
     * Get answer for specific section
     */
    public function getAnswer(string $sectionCode): mixed
    {
        return $this->answers[$sectionCode] ?? null;
    }

    /**
     * Set answer for specific section
     */
    public function setAnswer(string $sectionCode, mixed $value): void
    {
        $answers = $this->answers ?? [];
        $answers[$sectionCode] = $value;
        $this->answers = $answers;
    }

    /**
     * Get status badge class for display
     */
    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'bg-secondary',
            self::STATUS_SUBMITTED => 'bg-primary',
            self::STATUS_VERIFIED => 'bg-info',
            self::STATUS_VALIDATED => 'bg-success',
            self::STATUS_REJECTED => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    /**
     * Get status label for display
     */
    public function getStatusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_SUBMITTED => 'Diajukan',
            self::STATUS_VERIFIED => 'Terverifikasi',
            self::STATUS_VALIDATED => 'Tervalidasi',
            self::STATUS_REJECTED => 'Ditolak',
            default => 'Unknown',
        };
    }
}
