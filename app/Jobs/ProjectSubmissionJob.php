<?php

namespace App\Jobs;

use App\Models\InstrumentSubmissionV2;
use App\Services\Dashboard\DashboardProjectionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProjectSubmissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $submissionId;
    public string $triggeredBy;

    public int $tries = 3;
    public int $timeout = 60;

    public function __construct(int $submissionId, string $triggeredBy = 'event')
    {
        $this->submissionId = $submissionId;
        $this->triggeredBy = $triggeredBy;
    }

    public function handle(DashboardProjectionService $projectionService): void
    {
        $submission = InstrumentSubmissionV2::find($this->submissionId);

        if (!$submission) {
            return;
        }

        $projectionService->projectSubmission($submission, $this->triggeredBy);
    }
}
