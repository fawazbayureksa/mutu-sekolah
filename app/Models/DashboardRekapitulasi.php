<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DashboardRekapitulasi extends Model
{
    use HasFactory;

    protected $table = 'dashboard_rekapitulasis';

    protected $fillable = [
        'submission_id',
        'school_id',
        'school_name',
        'npsn',
        'school_status',
        'school_category',
        'school_accreditation',
        'province_code',
        'regency_code',
        'expertise',
        'expertise_program',
        'expertise_concentration',
        'year',
        'ukk_rate',
        'tracer_rate',
        'dropout_rate',
        'tka_score',
        'facility_readiness',
        'equipment_standard',
        'k3_compliance',
        'infrastructure_rate',
        'industry_collab_count',
        'tefa_rate',
        'teacher_comp_rate',
        'staffing_ratio_rate',
        'completion_percentage',
        'status',
        'filled_at',
        'calculated_at',
    ];

    protected $casts = [
        'ukk_rate'             => 'decimal:2',
        'tracer_rate'          => 'decimal:2',
        'dropout_rate'         => 'decimal:2',
        'tka_score'            => 'decimal:2',
        'facility_readiness'   => 'decimal:2',
        'equipment_standard'   => 'decimal:2',
        'k3_compliance'        => 'decimal:2',
        'infrastructure_rate'  => 'decimal:2',
        'tefa_rate'            => 'decimal:2',
        'teacher_comp_rate'    => 'decimal:2',
        'staffing_ratio_rate'  => 'decimal:2',
        'completion_percentage'=> 'decimal:2',
        'filled_at'            => 'date',
        'calculated_at'        => 'datetime',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(InstrumentSubmissionV2::class, 'submission_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class, 'regency_code', 'code');
    }
}
