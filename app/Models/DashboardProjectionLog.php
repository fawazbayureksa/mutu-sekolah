<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DashboardProjectionLog extends Model
{
    use HasFactory;

    protected $table = 'dashboard_projection_logs';

    protected $fillable = [
        'submission_id',
        'triggered_by',
        'status',
        'message',
        'duration_ms',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'duration_ms'  => 'decimal:2',
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(InstrumentSubmissionV2::class, 'submission_id');
    }
}
