<?php

namespace App\Observers;

use App\Jobs\ProjectSubmissionJob;
use App\Models\InstrumentSubmissionV2;

class InstrumentSubmissionV2Observer
{
    /**
     * Handle the InstrumentSubmissionV2 "saved" event.
     */
    public function saved(InstrumentSubmissionV2 $submission): void
    {
        // Dispatch projection job whenever submission answers, details or statuses change
        ProjectSubmissionJob::dispatch($submission->id, 'event');
    }

    /**
     * Handle the InstrumentSubmissionV2 "deleted" event.
     */
    public function deleted(InstrumentSubmissionV2 $submission): void
    {
        // Clean up corresponding rekapitulasi & snapshots
        \App\Models\DashboardRekapitulasi::where('submission_id', $submission->id)->delete();
        \App\Models\DashboardSectionSnapshot::where('submission_id', $submission->id)->delete();
    }
}
