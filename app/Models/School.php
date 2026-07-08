<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\InstrumentSubmissionV2;
use App\Models\User;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school_name',
        'npsn',
        'address',
        'province_code',
        'regency_code',
        'expertise',
        'expertise_program',
        'expertise_concentration',
        'school_status',
        'school_category',
        'program_duration',
        'school_accreditation',
        'curriculum',
        'approval_status',
        'share_token',
        'share_token_expires_at',
    ];

    protected $casts = [
        'expertise' => 'array',
        'expertise_program' => 'array',
        'expertise_concentration' => 'array',
        'share_token_expires_at' => 'datetime',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class, 'regency_code', 'code');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function instrumentSubmissionsV2(): HasMany
    {
        return $this->hasMany(InstrumentSubmissionV2::class, 'school_id');
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    public function latestSubmission()
    {
        return $this->hasOne(Submission::class)->latestOfMany('filled_at');
    }

    public function generateShareToken(int $expiresInDays = 3): self
    {
        $this->share_token = bin2hex(random_bytes(32));
        $this->share_token_expires_at = now()->addDays($expiresInDays);
        $this->save();

        return $this;
    }

    public function isShareTokenValid(): bool
    {
        return $this->share_token !== null
            && $this->share_token_expires_at !== null
            && $this->share_token_expires_at->isFuture();
    }

    public function getShareUrl(): ?string
    {
        if (!$this->share_token) {
            return null;
        }

        return route('schools.shared.show', $this->share_token);
    }

    public function scopeByAddress($query, $address)
    {
        return $query->where('address', 'like', '%' . $address . '%');
    }

    public function scopeByNpsn($query, $npsn)
    {
        return $query->where('npsn', $npsn);
    }
}
