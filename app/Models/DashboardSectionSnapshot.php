<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DashboardSectionSnapshot extends Model
{
    use HasFactory;

    protected $table = 'dashboard_section_snapshots';

    protected $fillable = [
        'submission_id',
        'school_id',
        'section_code',
        'year',
        'province_code',
        'regency_code',
        'expertise',
        'expertise_program',
        'expertise_concentration',
        'metric_rate_1',
        'metric_rate_2',
        'metric_int_1',
        'metric_int_2',
        'metric_int_3',
        'metric_bool_1',
        'metric_bool_2',
        'processed_data',
        'row_count',
        'calculated_at',
    ];

    protected $casts = [
        'metric_rate_1'  => 'decimal:2',
        'metric_rate_2'  => 'decimal:2',
        'metric_int_1'   => 'integer',
        'metric_int_2'   => 'integer',
        'metric_int_3'   => 'integer',
        'metric_bool_1'  => 'boolean',
        'metric_bool_2'  => 'boolean',
        'processed_data' => 'array',
        'row_count'      => 'integer',
        'calculated_at'  => 'datetime',
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(InstrumentSubmissionV2::class, 'submission_id');
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class, 'regency_code', 'code');
    }

    public function scopeForSection($query, string $sectionCode)
    {
        return $query->where('section_code', $sectionCode);
    }
}
