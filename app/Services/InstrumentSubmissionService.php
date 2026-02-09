<?php

namespace App\Services;

use App\Models\School;
use App\Models\Submission;
use App\Models\Response;
use App\Models\InstrumentItem;
use App\Repositories\Contracts\InstrumentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InstrumentSubmissionService
{
    protected InstrumentRepositoryInterface $repository;
    protected AnswerScoringService $scoringService;

    public function __construct(
        InstrumentRepositoryInterface $repository,
        AnswerScoringService $scoringService
    ) {
        $this->repository = $repository;
        $this->scoringService = $scoringService;
    }

    public function getInstrument(string $code): ?\App\Models\Instrument
    {
        return $this->repository->getInstrumentWithItems($code);
    }

    public function getInstrumentWithHierarchy(string $code): ?\App\Models\Instrument
    {
        return $this->repository->getInstrumentWithHierarchy($code);
    }

    public function submit(array $validated): Submission
    {
        return DB::transaction(function () use ($validated) {
            // 1. Load instrument
            $instrument = $this->loadInstrument();

            // 2. Resolve school
            $school = $this->resolveSchool($validated);

            // 3. Create submission
            $submission = $this->createSubmission($school, $instrument, $validated);

            // 4. Process and store responses
            $totals = $this->processAnswers(
                $submission,
                $school->id,
                $validated['answers'] ?? [],
                $instrument
            );

            // 5. Update submission totals
            $submission->update([
                'total_score' => $totals['total_score'],
                'max_possible_score' => $totals['max_possible_score'],
                'completion_percentage' => $totals['completion_percentage'],
            ]);

            Log::info('Instrument submission completed', [
                'submission_id' => $submission->id,
                'school_id' => $school->id,
                'response_count' => $totals['response_count'],
            ]);

            return $submission->fresh();
        });
    }

    protected function loadInstrument(): \App\Models\Instrument
    {
        $instrument = $this->repository->getInstrumentWithHierarchy('KPTK-ADV-2024')
            ?? $this->repository->getInstrumentWithItems('KPTK-2024');

        if (!$instrument) {
            throw new \RuntimeException('Active instrument not found');
        }

        return $instrument;
    }

    protected function resolveSchool(array $data): School
    {
        // Try NPSN first (unique identifier)
        if (!empty($data['npsn'])) {
            $school = School::where('npsn', $data['npsn'])->first();
            if ($school) {
                // Update address if changed
                $school->update(['address' => $data['address']]);
                return $school;
            }
        }

        // Create new school
        return School::create([
            'school_name' => $data['school_name'],
            'npsn' => $data['npsn'] ?? null,
            'address' => $data['address'],
        ]);
    }

    protected function createSubmission(School $school, $instrument, array $data): Submission
    {
        return Submission::create([
            'school_id' => $school->id,
            'instrument_id' => $instrument->id,
            'respondent_name' => $data['respondent_name'],
            'respondent_position' => $data['respondent_position'],
            'filled_at' => now(),
            'status' => 'submitted',
            'total_score' => 0,
            'max_possible_score' => 0,
            'completion_percentage' => 0,
        ]);
    }

    protected function processAnswers(
        Submission $submission,
        int $schoolId,
        array $answers,
        $instrument
    ): array {
        $totalScore = 0;
        $maxPossibleScore = 0;
        $responseCount = 0;

        foreach ($answers as $itemId => $rawAnswer) {
            // Load item with relationships
            $item = InstrumentItem::with(['question.scaleTemplate'])->find($itemId);

            if (!$item) {
                Log::warning("InstrumentItem not found: {$itemId}");
                continue;
            }

            // Normalize answer
            $normalizedAnswer = $this->normalizeAnswer($item, $rawAnswer);

            // Skip empty answers
            if ($normalizedAnswer === null) {
                Log::info("Skipping empty answer for item {$itemId}");
                continue;
            }

            // Calculate scores using centralized service
            $score = $this->scoringService->calculate($item, $normalizedAnswer);
            $maxScore = $this->scoringService->getMaxScore($item);

            $totalScore += $score;
            $maxPossibleScore += $maxScore;

            // Create response using Eloquent (with JSON cast support)
            Response::create([
                'submission_id' => $submission->id,
                'school_id' => $schoolId,
                'instrument_item_id' => $itemId,
                'answer' => $normalizedAnswer, // Eloquent will auto-encode if array
                'score' => $score,
            ]);

            $responseCount++;
        }

        return [
            'total_score' => $totalScore,
            'max_possible_score' => $maxPossibleScore,
            'completion_percentage' => $maxPossibleScore > 0
                ? round(($totalScore / $maxPossibleScore) * 100, 2)
                : 0,
            'response_count' => $responseCount,
        ];
    }

    protected function normalizeAnswer(InstrumentItem $item, mixed $rawAnswer): mixed
    {
        // Handle empty
        if ($rawAnswer === null || $rawAnswer === '') {
            return null;
        }

        $answerType = $item->question?->answer_type ?? $item->answer_type;

        return match ($answerType) {
            'structure' => $this->normalizeStructureAnswer($rawAnswer, $item),
            'boolean' => $this->normalizeBooleanAnswer($rawAnswer),
            'number', 'percentage' => $this->normalizeNumericAnswer($rawAnswer),
            default => (string) $rawAnswer,
        };
    }

    protected function normalizeStructureAnswer(mixed $answer, InstrumentItem $item): ?array
    {
        // Parse JSON string
        $parsed = is_string($answer) ? json_decode($answer, true) : $answer;

        if (!is_array($parsed)) {
            Log::warning("Structure answer is not valid JSON/array", ['answer' => $answer]);
            return null;
        }

        // Filter empty rows
        $filtered = array_filter($parsed, function ($row) {
            if (!is_array($row)) {
                return false;
            }
            // Keep row if any value (except label) is non-empty
            foreach ($row as $key => $value) {
                if ($key !== 'label' && $value !== '' && $value !== null) {
                    return true;
                }
            }
            return false;
        });

        // Cast numeric fields based on schema
        $schema = $item->question?->answer_options ?? [];
        $numericColumns = collect($schema['columns'] ?? [])
            ->filter(fn($col) => in_array($col['type'] ?? '', ['number', 'percentage']))
            ->pluck('key')
            ->toArray();

        return array_map(function ($row) use ($numericColumns) {
            foreach ($numericColumns as $col) {
                if (isset($row[$col])) {
                    $row[$col] = is_numeric($row[$col]) ? (float) $row[$col] : 0;
                }
            }
            return $row;
        }, array_values($filtered));
    }

    protected function normalizeBooleanAnswer(mixed $answer): string
    {
        $truthyValues = ['yes', 'ya', '1', 'true', 'ada', 'sudah'];
        return in_array(strtolower((string) $answer), $truthyValues) ? 'Yes' : 'No';
    }

    protected function normalizeNumericAnswer(mixed $answer): float
    {
        return is_numeric($answer) ? (float) $answer : 0;
    }
}
