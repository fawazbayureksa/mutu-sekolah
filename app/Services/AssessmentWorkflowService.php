<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentQuestion;
use App\Models\Instrument;
use Illuminate\Support\Facades\DB;

class AssessmentWorkflowService
{
    protected ScoreCalculationService $scoreService;
    protected AnswerValidationService $validationService;

    public function __construct(
        ScoreCalculationService $scoreService,
        AnswerValidationService $validationService
    ) {
        $this->scoreService = $scoreService;
        $this->validationService = $validationService;
    }

    public function createAssessment(array $data): Assessment
    {
        return DB::transaction(function () use ($data) {
            $assessment = Assessment::create([
                'instrument_id' => $data['instrument_id'],
                'school_id' => $data['school_id'],
                'respondent_name' => $data['respondent_name'],
                'respondent_position' => $data['respondent_position'],
                'filled_at' => $data['filled_at'] ?? now(),
                'period_year' => $data['period_year'] ?? now()->year,
                'academic_year' => $data['academic_year'] ?? null,
                'semester' => $data['semester'] ?? null,
                'assessment_type' => $data['assessment_type'] ?? 'self-assessment',
                'status' => 'draft',
                'started_at' => now(),
            ]);

            $instrument = $assessment->instrument;
            $assessment->update([
                'total_questions' => $instrument->items()->count(),
                'max_possible_score' => $this->scoreService->calculateMaxPossibleScore($instrument),
            ]);

            return $assessment;
        });
    }

    public function saveAnswer(Assessment $assessment, AssessmentQuestion $question, array $data): AssessmentAnswer
    {
        return DB::transaction(function () use ($assessment, $question, $data) {
            $this->validationService->validateAnswer($data, $question);
            $data = $this->validationService->castAnswerValue($data, $question);
            $data['score'] = $this->validationService->calculateAnswerScore($data, $question);

            $answer = $assessment->answers()->updateOrCreate(
                ['question_id' => $question->id],
                array_merge($data, [
                    'answered_by' => auth()->id() ?? $assessment->respondent_name,
                    'answered_at' => now(),
                    'validation_status' => 'pending',
                ])
            );

            $assessment->updateProgress();

            return $answer;
        });
    }

    public function submitAssessment(Assessment $assessment): Assessment
    {
        return DB::transaction(function () use ($assessment) {
            $this->validationService->validateAssessmentCompletion($assessment);
            
            $this->scoreService->updateAssessmentScores($assessment);
            
            $assessment->update([
                'status' => 'submitted',
                'submitted_at' => now(),
                'completed_at' => now(),
                'duration_minutes' => $assessment->calculateDuration(),
            ]);

            return $assessment->fresh();
        });
    }

    public function verifyAssessment(Assessment $assessment, array $data): Assessment
    {
        return DB::transaction(function () use ($assessment, $data) {
            if ($assessment->status !== 'submitted') {
                throw new \Exception('Assessment can only be verified when in submitted status.');
            }

            $assessment->update([
                'status' => 'verified',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
                'verification_notes' => $data['notes'] ?? null,
            ]);

            return $assessment->fresh();
        });
    }

    public function approveAssessment(Assessment $assessment, array $data): Assessment
    {
        return DB::transaction(function () use ($assessment, $data) {
            if (!$assessment->isVerified()) {
                throw new \Exception('Assessment must be verified before approval.');
            }

            $assessment->update([
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'approval_notes' => $data['notes'] ?? null,
            ]);

            return $assessment->fresh();
        });
    }

    public function rejectAssessment(Assessment $assessment, array $data): Assessment
    {
        return DB::transaction(function () use ($assessment, $data) {
            if ($assessment->status === 'draft') {
                throw new \Exception('Cannot reject a draft assessment.');
            }

            $assessment->update([
                'status' => 'draft',
                'verification_notes' => $data['reason'] ?? 'Assessment rejected.',
                'verified_by' => null,
                'verified_at' => null,
                'approved_by' => null,
                'approved_at' => null,
            ]);

            return $assessment->fresh();
        });
    }

    public function recalculateScores(Assessment $assessment): Assessment
    {
        return DB::transaction(function () use ($assessment) {
            $this->scoreService->updateAssessmentScores($assessment);
            return $assessment->fresh();
        });
    }

    public function getAssessmentDetails(Assessment $assessment): array
    {
        return [
            'assessment' => $assessment,
            'scores' => $this->scoreService->calculateAssessmentScore($assessment),
            'aspect_scores' => $this->scoreService->calculateAspectScores($assessment),
            'completion' => [
                'total_questions' => $assessment->total_questions,
                'answered_questions' => $assessment->answered_questions,
                'percentage' => $assessment->completion_percentage,
            ],
            'answers' => $assessment->answers()->with('question')->get(),
        ];
    }
}
