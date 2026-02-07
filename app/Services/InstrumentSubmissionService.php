<?php

namespace App\Services;

use App\Models\School;
use App\Models\Submission;
use App\Models\InstrumentItem;
use App\Models\AssessmentQuestion;
use App\Repositories\Contracts\InstrumentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InstrumentSubmissionService
{
    protected InstrumentRepositoryInterface $repository;

    public function __construct(InstrumentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getInstrument(string $code): ?\App\Models\Instrument
    {
        return $this->repository->getInstrumentWithItems($code);
    }

    public function getInstrumentWithHierarchy(string $code): ?\App\Models\Instrument
    {
        return $this->repository->getInstrumentWithHierarchy($code);
    }

    public function submit(array $payload): Submission
    {
        // $validated = $this->validate($payload);

        return DB::transaction(function () use ($payload) {
            $validated = $payload;
            // Get instrument - try advanced first, fallback to legacy
            $instrument = $this->repository->getInstrumentWithHierarchy('KPTK-ADV-2024');

            if (!$instrument) {
                $instrument = $this->repository->getInstrumentWithItems('KPTK-2024');
            }

            if (!$instrument) {
                throw new \Exception('Instrument not found');
            }

            // Find or create school
            $school = School::firstOrCreate(
                [
                    'npsn' => $validated['npsn'] ?? null,
                    'school_name' => $validated['school_name'],
                ],
                [
                    'province' => $validated['province'],
                    'city' => $validated['city'],
                ]
            );


            // Create submission
            $submission = Submission::create([
                'school_id' => $school->id,
                'instrument_id' => $instrument->id,
                'respondent_name' => $validated['respondent_name'],
                'respondent_position' => $validated['respondent_position'],
                'filled_at' => now(),
                'status' => 'submitted',
            ]);
            // Store responses with scores
            $this->storeResponses($submission->id, $school->id, $validated['answers'], $instrument);
            return $submission;
        });
    }

    protected function storeResponses(int $submissionId, int $schoolId, array $answers, $instrument): void
    {
        try {
            $responses = [];
            $totalScore = 0;
            $maxPossibleScore = 0;

            foreach ($answers as $itemId => $answer) {
                // Skip empty answers
                if (empty($answer) && $answer !== '0' && $answer !== 0) {
                    Log::info("Skipping empty answer for item {$itemId}");
                    continue;
                }

                // Log each answer to debug
                Log::info("Processing answer for item {$itemId}:", [
                    'answer_type' => gettype($answer),
                    'answer_value' => is_string($answer) && strlen($answer) > 100 ? substr($answer, 0, 100) . '...' : $answer
                ]);

                // Calculate score based on question type and scale template
                $score = $this->calculateScore($itemId, $answer);
                $maxScore = $this->getMaxScore($itemId);

                $totalScore += $score;
                $maxPossibleScore += $maxScore;

                $responses[] = [
                    'submission_id' => $submissionId,
                    'school_id' => $schoolId,
                    'instrument_item_id' => $itemId,
                    'answer' => is_array($answer) ? json_encode($answer) : $answer,
                    'score' => $score,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ];
            }

            DB::table('responses')->insert($responses);

            // Update submission with total scores
            Submission::where('id', $submissionId)->update([
                'total_score' => $totalScore,
                'max_possible_score' => $maxPossibleScore,
                'completion_percentage' => $maxPossibleScore > 0 ? ($totalScore / $maxPossibleScore) * 100 : 0,
            ]);
        } catch (\Exception $e) {
            Log::info("Error storing responses: " . $e->getMessage());
            throw new \Exception('Failed to store responses: ' . $e->getMessage());
        }
    }

    protected function calculateScore($itemId, $answer): float
    {
        $item = InstrumentItem::with('question.scaleTemplate')->find($itemId);

        if (!$item) {
            return 0;
        }

        // If using master question with scale template
        if ($item->uses_master_question && $item->question && $item->question->scaleTemplate) {
            $scaleTemplate = $item->question->scaleTemplate;
            $scoreValue = $scaleTemplate->getScoreForValue($answer);

            if ($scoreValue !== null) {
                return $scoreValue;
            }
        }

        // If question has direct answer_options
        if ($item->uses_master_question && $item->question && $item->question->answer_options) {
            $options = is_array($item->question->answer_options)
                ? $item->question->answer_options
                : json_decode($item->question->answer_options, true) ?? [];

            foreach ($options as $option) {
                if (isset($option['value']) && (string)$option['value'] === (string)$answer) {
                    return (float)($option['score'] ?? 0);
                }
            }
        }

        // For boolean answers without template
        if ($item->answer_type === 'boolean') {
            return in_array(strtolower($answer), ['yes', 'ya', '1', 'true', 'ada']) ? 100 : 0;
        }

        // For numeric answers
        if (is_numeric($answer)) {
            return (float)$answer;
        }

        return 0;
    }

    protected function getMaxScore($itemId): float
    {
        $item = InstrumentItem::with('question.scaleTemplate')->find($itemId);

        if (!$item) {
            return 100;
        }

        if ($item->uses_master_question && $item->question) {
            if ($item->question->scaleTemplate) {
                return (float)$item->question->scaleTemplate->max_score;
            }
            if ($item->question->max_score !== null) {
                return (float)$item->question->max_score;
            }
        }

        // Default max score
        return 100;
    }

    protected function validate(array $payload): array
    {
        $validator = Validator::make($payload, [
            'school_name' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:20',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'respondent_name' => 'required|string|max:255',
            'respondent_position' => 'required|string|max:255',
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return $validator->validated();
    }
}
