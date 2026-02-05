<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\Instrument;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentQuestion;
use Illuminate\Support\Facades\DB;

class ReportingService
{
    public function generateSchoolReport(int $schoolId, string $year = null): array
    {
        $query = Assessment::where('school_id', $schoolId);

        if ($year) {
            $query->where('period_year', $year);
        }

        $assessments = $query->with(['instrument', 'answers.question'])->get();

        return [
            'school_id' => $schoolId,
            'year' => $year,
            'total_assessments' => $assessments->count(),
            'average_score' => $assessments->avg('percentage') ?? 0,
            'average_grade' => $this->calculateAverageGrade($assessments),
            'assessments_by_status' => $this->groupAssessmentsByStatus($assessments),
            'assessments_by_type' => $this->groupAssessmentsByType($assessments),
            'recent_assessments' => $assessments->latest()->take(5),
        ];
    }

    public function generateInstrumentReport(int $instrumentId, string $year = null): array
    {
        $query = Assessment::where('instrument_id', $instrumentId);

        if ($year) {
            $query->where('period_year', $year);
        }

        $assessments = $query->with(['school', 'answers'])->get();
        $instrument = Instrument::find($instrumentId);

        $scores = $assessments->pluck('percentage')->filter();
        
        return [
            'instrument_id' => $instrumentId,
            'instrument_name' => $instrument->name ?? 'Unknown',
            'year' => $year,
            'total_submissions' => $assessments->count(),
            'average_score' => $scores->avg() ?? 0,
            'median_score' => $this->calculateMedian($scores->toArray()),
            'min_score' => $scores->min() ?? 0,
            'max_score' => $scores->max() ?? 0,
            'grade_distribution' => $this->calculateGradeDistribution($assessments),
            'completeness_rate' => $this->calculateCompletenessRate($assessments),
            'aspect_averages' => $this->calculateAspectAverages($assessments),
        ];
    }

    public function generateRegionalReport(string $province = null, string $city = null, string $year = null): array
    {
        $query = Assessment::with(['school', 'instrument']);

        if ($province) {
            $query->whereHas('school', function ($q) use ($province) {
                $q->where('province', $province);
            });
        }

        if ($city) {
            $query->whereHas('school', function ($q) use ($city) {
                $q->where('city', $city);
            });
        }

        if ($year) {
            $query->where('period_year', $year);
        }

        $assessments = $query->get();

        return [
            'region' => [
                'province' => $province,
                'city' => $city,
            ],
            'year' => $year,
            'total_assessments' => $assessments->count(),
            'total_schools' => $assessments->pluck('school_id')->unique()->count(),
            'average_score' => $assessments->avg('percentage') ?? 0,
            'grade_distribution' => $this->calculateGradeDistribution($assessments),
            'top_performing_schools' => $this->getTopPerformingSchools($assessments, 5),
            'bottom_performing_schools' => $this->getBottomPerformingSchools($assessments, 5),
            'by_instrument' => $this->groupAssessmentsByInstrument($assessments),
        ];
    }

    public function generateQuestionAnalysisReport(int $questionId, string $year = null): array
    {
        $query = AssessmentAnswer::where('question_id', $questionId);

        if ($year) {
            $query->whereHas('assessment', function ($q) use ($year) {
                $q->where('period_year', $year);
            });
        }

        $answers = $query->with(['assessment.school', 'question'])->get();
        $question = AssessmentQuestion::find($questionId);

        return [
            'question_id' => $questionId,
            'question_text' => $question->question_text ?? 'Unknown',
            'question_type' => $question->answer_type ?? 'Unknown',
            'year' => $year,
            'total_responses' => $answers->count(),
            'average_score' => $answers->avg('score') ?? 0,
            'answer_distribution' => $this->calculateAnswerDistribution($answers, $question),
            'schools_with_low_scores' => $this->getSchoolsWithLowScores($answers, 5),
            'completion_rate' => $this->calculateQuestionCompletionRate($questionId, $year),
        ];
    }

    public function generateTrendReport(int $instrumentId, string $startYear, string $endYear): array
    {
        $assessments = Assessment::where('instrument_id', $instrumentId)
            ->whereBetween('period_year', [$startYear, $endYear])
            ->with('school')
            ->get();

        $yearlyData = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $yearAssessments = $assessments->where('period_year', $year);
            
            $yearlyData[] = [
                'year' => $year,
                'total' => $yearAssessments->count(),
                'average_score' => $yearAssessments->avg('percentage') ?? 0,
                'unique_schools' => $yearAssessments->pluck('school_id')->unique()->count(),
            ];
        }

        return [
            'instrument_id' => $instrumentId,
            'period' => "{$startYear} - {$endYear}",
            'yearly_trends' => $yearlyData,
            'overall_improvement' => $this->calculateOverallImprovement($yearlyData),
        ];
    }

    protected function calculateAverageGrade($assessments): string
    {
        if ($assessments->isEmpty()) {
            return '-';
        }

        $grades = $assessments->pluck('grade')->filter();
        
        if ($grades->isEmpty()) {
            return '-';
        }

        $gradeCounts = $grades->countBy()->sortKeysDesc();
        return $gradeCounts->keys()->first();
    }

    protected function groupAssessmentsByStatus($assessments): array
    {
        return $assessments->groupBy('status')->map(function ($group) {
            return $group->count();
        })->toArray();
    }

    protected function groupAssessmentsByType($assessments): array
    {
        return $assessments->groupBy('assessment_type')->map(function ($group) {
            return [
                'count' => $group->count(),
                'average_score' => $group->avg('percentage') ?? 0,
            ];
        })->toArray();
    }

    protected function calculateMedian(array $scores): float
    {
        sort($scores);
        $count = count($scores);
        
        if ($count === 0) {
            return 0;
        }

        $middle = floor($count / 2);

        if ($count % 2) {
            return $scores[$middle];
        }

        return ($scores[$middle - 1] + $scores[$middle]) / 2;
    }

    protected function calculateGradeDistribution($assessments): array
    {
        $grades = $assessments->pluck('grade')->filter();
        
        $distribution = [
            'A' => 0,
            'B' => 0,
            'C' => 0,
            'D' => 0,
            'E' => 0,
        ];

        foreach ($grades as $grade) {
            if (array_key_exists($grade, $distribution)) {
                $distribution[$grade]++;
            }
        }

        return $distribution;
    }

    protected function calculateCompletenessRate($assessments): float
    {
        if ($assessments->isEmpty()) {
            return 0;
        }

        $totalQuestions = $assessments->sum('total_questions');
        $answeredQuestions = $assessments->sum('answered_questions');

        return $totalQuestions > 0 ? ($answeredQuestions / $totalQuestions) * 100 : 0;
    }

    protected function calculateAspectAverages($assessments): array
    {
        $aspectAverages = [];

        foreach ($assessments as $assessment) {
            $aspectScores = app(ScoreCalculationService::class)->calculateAspectScores($assessment);

            foreach ($aspectScores as $aspectScore) {
                $aspectId = $aspectScore['aspect_id'];
                $percentage = $aspectScore['percentage'];

                if (!isset($aspectAverages[$aspectId])) {
                    $aspectAverages[$aspectId] = [
                        'aspect_code' => $aspectScore['aspect_code'],
                        'aspect_name' => $aspectScore['aspect_name'],
                        'total_score' => 0,
                        'count' => 0,
                    ];
                }

                $aspectAverages[$aspectId]['total_score'] += $percentage;
                $aspectAverages[$aspectId]['count']++;
            }
        }

        foreach ($aspectAverages as &$aspect) {
            $aspect['average'] = $aspect['count'] > 0 ? $aspect['total_score'] / $aspect['count'] : 0;
            unset($aspect['total_score'], $aspect['count']);
        }

        return array_values($aspectAverages);
    }

    protected function getTopPerformingSchools($assessments, int $limit): array
    {
        return $assessments
            ->sortByDesc('percentage')
            ->take($limit)
            ->map(function ($assessment) {
                return [
                    'school_name' => $assessment->school->school_name,
                    'score' => $assessment->percentage,
                    'grade' => $assessment->grade,
                ];
            })
            ->values()
            ->toArray();
    }

    protected function getBottomPerformingSchools($assessments, int $limit): array
    {
        return $assessments
            ->sortBy('percentage')
            ->take($limit)
            ->map(function ($assessment) {
                return [
                    'school_name' => $assessment->school->school_name,
                    'score' => $assessment->percentage,
                    'grade' => $assessment->grade,
                ];
            })
            ->values()
            ->toArray();
    }

    protected function groupAssessmentsByInstrument($assessments): array
    {
        return $assessments
            ->groupBy('instrument_id')
            ->map(function ($group) {
                $instrument = $group->first()->instrument;
                return [
                    'instrument_name' => $instrument->name ?? 'Unknown',
                    'count' => $group->count(),
                    'average_score' => $group->avg('percentage') ?? 0,
                ];
            })
            ->values()
            ->toArray();
    }

    protected function calculateAnswerDistribution($answers, $question): array
    {
        $distribution = [];
        $options = $question->getAnswerOptionsArray();

        if (in_array($question->answer_type, ['scale', 'multiple_choice'])) {
            foreach ($options as $option) {
                $count = $answers->where('answer_value', $option['value'])->count();
                $distribution[] = [
                    'value' => $option['value'],
                    'label' => $option['label'],
                    'count' => $count,
                    'percentage' => $answers->count() > 0 ? ($count / $answers->count()) * 100 : 0,
                ];
            }
        } elseif ($question->answer_type === 'boolean') {
            $yesCount = $answers->where('boolean_value', true)->count();
            $noCount = $answers->where('boolean_value', false)->count();

            $distribution = [
                [
                    'value' => true,
                    'label' => 'Ya',
                    'count' => $yesCount,
                    'percentage' => $answers->count() > 0 ? ($yesCount / $answers->count()) * 100 : 0,
                ],
                [
                    'value' => false,
                    'label' => 'Tidak',
                    'count' => $noCount,
                    'percentage' => $answers->count() > 0 ? ($noCount / $answers->count()) * 100 : 0,
                ],
            ];
        }

        return $distribution;
    }

    protected function getSchoolsWithLowScores($answers, int $limit): array
    {
        return $answers
            ->sortBy('score')
            ->take($limit)
            ->map(function ($answer) {
                return [
                    'school_name' => $answer->assessment->school->school_name,
                    'score' => $answer->score,
                ];
            })
            ->values()
            ->toArray();
    }

    protected function calculateQuestionCompletionRate(int $questionId, ?string $year): float
    {
        $query = Assessment::query();

        if ($year) {
            $query->where('period_year', $year);
        }

        $totalAssessments = $query->count();
        
        if ($totalAssessments === 0) {
            return 0;
        }

        $answeredCount = AssessmentAnswer::where('question_id', $questionId)
            ->whereHas('assessment', function ($q) use ($year) {
                if ($year) {
                    $q->where('period_year', $year);
                }
            })
            ->count();

        return ($answeredCount / $totalAssessments) * 100;
    }

    protected function calculateOverallImprovement(array $yearlyData): array
    {
        if (count($yearlyData) < 2) {
            return [
                'improvement' => 0,
                'trend' => 'stable',
            ];
        }

        $first = $yearlyData[0]['average_score'];
        $last = end($yearlyData)['average_score'];
        $improvement = $last - $first;

        $trend = $improvement > 0 ? 'increasing' : ($improvement < 0 ? 'decreasing' : 'stable');

        return [
            'improvement' => round($improvement, 2),
            'trend' => $trend,
            'start_year' => $yearlyData[0]['year'],
            'end_year' => end($yearlyData)['year'],
        ];
    }
}
