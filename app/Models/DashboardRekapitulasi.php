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
        
        // Aspek A: Mutu Peserta Didik
        'ukk_rate',
        'ukk_participants',
        'ukk_passed',
        'certification_count',
        'tracer_rate',
        'tracer_total_graduates',
        'tracer_employed',
        'tracer_continuing_edu',
        'tracer_entrepreneur',
        'dropout_rate',
        'dropout_initial',
        'dropout_final',
        'dropout_count',
        'tka_score',
        'tka_school_avg',
        'tka_national_avg',

        // Aspek B: Sarana Prasarana
        'facility_readiness',
        'equipment_standard',
        'k3_compliance',
        'infrastructure_rate',

        // Aspek C: Tata Kelola
        'industry_collab_count',
        'industry_partner_count',
        'tefa_rate',
        'tefa_category',
        'teacher_comp_rate',
        'teacher_trained_count',
        'staffing_ratio_rate',

        // Priority Indicators
        'has_sop',
        'is_below_ideal_ratio',
        'is_tracer_incomplete',

        // Workflow / Meta
        'completion_percentage',
        'status',
        'filled_at',
        'calculated_at',
        'projection_version',
    ];

    protected $casts = [
        'ukk_rate'               => 'decimal:2',
        'ukk_participants'       => 'integer',
        'ukk_passed'             => 'integer',
        'certification_count'    => 'integer',
        'tracer_rate'            => 'decimal:2',
        'tracer_total_graduates' => 'integer',
        'tracer_employed'        => 'integer',
        'tracer_continuing_edu'  => 'integer',
        'tracer_entrepreneur'    => 'integer',
        'dropout_rate'           => 'decimal:2',
        'dropout_initial'        => 'integer',
        'dropout_final'          => 'integer',
        'dropout_count'          => 'integer',
        'tka_score'              => 'decimal:2',
        'tka_school_avg'         => 'decimal:2',
        'tka_national_avg'       => 'decimal:2',
        'facility_readiness'     => 'decimal:2',
        'equipment_standard'     => 'decimal:2',
        'k3_compliance'          => 'decimal:2',
        'infrastructure_rate'    => 'decimal:2',
        'industry_collab_count'  => 'integer',
        'industry_partner_count' => 'integer',
        'tefa_rate'              => 'decimal:2',
        'teacher_comp_rate'      => 'decimal:2',
        'teacher_trained_count'  => 'integer',
        'staffing_ratio_rate'    => 'decimal:2',
        'has_sop'                => 'boolean',
        'is_below_ideal_ratio'   => 'boolean',
        'is_tracer_incomplete'   => 'boolean',
        'completion_percentage'  => 'decimal:2',
        'projection_version'     => 'integer',
        'filled_at'              => 'date',
        'calculated_at'          => 'datetime',
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
