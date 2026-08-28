<?php

namespace App\Services\Dashboard;

use App\Models\DashboardRekapitulasi;
use App\Models\InstrumentSubmissionV2;

class DashboardRekapitulasiService
{
    public function __construct(
        protected DashboardProjectionService $projectionService
    ) {}

    /**
     * Calculate and sync all records into dashboard_rekapitulasis & snapshots table
     */
    public function syncAll(): int
    {
        return $this->projectionService->projectAll('command');
    }

    /**
     * Calculate and sync a single submission record
     */
    public function syncSubmission(InstrumentSubmissionV2 $sub): ?DashboardRekapitulasi
    {
        return $this->projectionService->projectSubmission($sub, 'manual');
    }
}
