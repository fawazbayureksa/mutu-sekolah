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
        int $limit = 0,   // 0 = no limit (all records)
        int $offset = 0,
        string $programKeahlian = '',
        string $konsentrasiKeahlian = '',
        string $dateFrom = '',
        string $dateTo = '',
    ) {
        $query = InstrumentSubmissionV2::with([
            'school',
            'school.province',
            'school.regency',
            'province',
            'regency',
            'verifier',
            'validator',
        ])
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->when(filled($bidangKeahlian), fn($q) => $q->where('expertise', $bidangKeahlian))
            ->when(filled($programKeahlian), fn($q) => $q->where('expertise_program', $programKeahlian))
            ->when(filled($konsentrasiKeahlian), fn($q) => $q->where('expertise_concentration', $konsentrasiKeahlian))
            ->when(filled($dateFrom), fn($q) => $q->whereDate('created_at', '>=', $dateFrom))
            ->when(filled($dateTo), fn($q) => $q->whereDate('created_at', '<=', $dateTo))
            ->latest('filled_at');

        if ($limit > 0) {
            $query->skip($offset)->take($limit);
        }

        $this->submissions = $query->get();
    }

    public function sheets(): array
    {
        return [
            new BulkSummarySheet($this->submissions),
            new BulkDataSheet($this->submissions),
        ];
    }
}
