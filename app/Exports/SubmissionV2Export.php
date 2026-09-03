<?php

namespace App\Exports;

use App\Exports\Sheets\SubmissionV2DataSheet;
use App\Exports\Sheets\SubmissionV2SummarySheet;
use App\Models\InstrumentSubmissionV2;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SubmissionV2Export implements WithMultipleSheets
{
    public function __construct(protected InstrumentSubmissionV2 $submission)
    {
        $this->submission->loadMissing([
            'school.province', 'school.regency', 'province', 'regency', 'verifier', 'validator',
        ]);
    }

    public function sheets(): array
    {
        return [
            new SubmissionV2SummarySheet($this->submission),
            new SubmissionV2DataSheet($this->submission),
        ];
    }
}
