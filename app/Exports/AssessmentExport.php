<?php

namespace App\Exports;

use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssessmentExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $assessment;

    public function __construct(Assessment $assessment)
    {
        $this->assessment = $assessment;
    }

    public function collection()
    {
        return AssessmentAnswer::with(['question.indicator.aspect', 'question.scaleTemplate'])
            ->where('assessment_id', $this->assessment->id)
            ->get()
            ->map(function ($answer) {
                return [
                    'code' => $this->assessment->assessment_code,
                    'school' => $this->assessment->school->school_name ?? 'N/A',
                    'instrument' => $this->assessment->instrument->name ?? 'N/A',
                    'assessment_date' => $this->assessment->assessment_date->format('Y-m-d'),
                    'assessment_period' => ucfirst($this->assessment->assessment_period),
                    'status' => ucfirst($this->assessment->status),
                    'question_code' => $answer->question->question_code,
                    'question' => $answer->question->question_text,
                    'aspect' => $answer->question->indicator->aspect->name ?? 'N/A',
                    'indicator' => $answer->question->indicator->indicator_name ?? 'N/A',
                    'answer_type' => $answer->question->answer_type,
                    'answer_value' => $answer->answer_value,
                    'score' => $answer->score,
                    'notes' => $answer->notes ?? '',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Assessment Code',
            'School',
            'Instrument',
            'Assessment Date',
            'Assessment Period',
            'Status',
            'Question Code',
            'Question',
            'Aspect',
            'Indicator',
            'Answer Type',
            'Answer Value',
            'Score',
            'Notes',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFE5E5E5',
                    ],
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Assessment - ' . $this->assessment->assessment_code;
    }
}
