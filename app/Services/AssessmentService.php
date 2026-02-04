<?php

namespace App\Services;

use App\Models\Assessment;
use App\Repositories\Contracts\AssessmentAnswerRepositoryInterface;
use App\Repositories\Contracts\AssessmentRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AssessmentService
{
    protected AssessmentRepositoryInterface $assessmentRepository;

    protected AssessmentAnswerRepositoryInterface $answerRepository;

    public function __construct(
        AssessmentRepositoryInterface $assessmentRepository,
        AssessmentAnswerRepositoryInterface $answerRepository
    ) {
        $this->assessmentRepository = $assessmentRepository;
        $this->answerRepository = $answerRepository;
    }

    public function createAssessment(array $assessmentData, array $answersData = []): Assessment
    {
        return DB::transaction(function () use ($assessmentData, $answersData) {
            $assessment = $this->assessmentRepository->create($assessmentData);

            if (! empty($answersData)) {
                $this->saveAnswers($assessment->id, $answersData);
            }

            return $assessment->load('answers');
        });
    }

    public function updateAssessment(int $assessmentId, array $assessmentData, ?array $answersData = null): Assessment
    {
        return DB::transaction(function () use ($assessmentId, $assessmentData, $answersData) {
            $this->assessmentRepository->update($assessmentId, $assessmentData);

            if ($answersData !== null) {
                $this->answerRepository->deleteByAssessmentId($assessmentId);
                $this->saveAnswers($assessmentId, $answersData);
            }

            return $this->assessmentRepository->findById($assessmentId);
        });
    }

    public function findById(int $id): ?Assessment
    {
        return $this->assessmentRepository->findById($id);
    }

    public function findBySchoolId(int $schoolId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->assessmentRepository->findBySchoolId($schoolId);
    }

    public function submitAssessment(int $assessmentId): Assessment
    {
        $this->assessmentRepository->updateStatus($assessmentId, 'submitted');

        return $this->assessmentRepository->findById($assessmentId);
    }

    public function deleteAssessment(int $assessmentId): bool
    {
        return DB::transaction(function () use ($assessmentId) {
            $this->answerRepository->deleteByAssessmentId($assessmentId);

            return $this->assessmentRepository->delete($assessmentId);
        });
    }

    public function updateStatus(int $assessmentId, string $status): bool
    {
        return $this->assessmentRepository->updateStatus($assessmentId, $status);
    }

    protected function saveAnswers(int $assessmentId, array $answersData): void
    {
        foreach ($answersData as $answerData) {
            $this->answerRepository->create([
                'assessment_id' => $assessmentId,
                'question_id' => $answerData['question_id'],
                'answer_value' => $answerData['answer_value'],
            ]);
        }
    }
}
