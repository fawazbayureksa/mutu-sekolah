<?php

namespace App\Exports;

use App\Exports\Sheets\BulkSummarySheet;
use App\Exports\Sheets\BulkDataSheet;
use App\Models\InstrumentSubmissionV2;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SubmissionV2BulkExport implements WithMultipleSheets
{
    protected Collection $submissions;

    public function __construct(
        string $status = 'all',
        string $bidangKeahlian = '',
    ) {
        $this->submissions = InstrumentSubmissionV2::with([
                'school', 'province', 'regency', 'verifier', 'validator',
            ])
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->when($bidangKeahlian !== '', fn($q) => $q->where('expertise', $bidangKeahlian))
            ->latest('filled_at')
            ->get();
    }

    public function sheets(): array
    {
        return [
            new BulkSummarySheet($this->submissions),
            new BulkDataSheet($this->submissions),
        ];
    }
}
