<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\InstrumentSubmissionV2;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
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
    ];

    protected $casts = [
        'expertise' => 'array',
        'expertise_program' => 'array',
        'expertise_concentration' => 'array',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
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

    public function scopeByAddress($query, $address)
    {
        return $query->where('address', 'like', '%' . $address . '%');
    }

    public function scopeByNpsn($query, $npsn)
    {
        return $query->where('npsn', $npsn);
    }
}
