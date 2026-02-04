<?php

namespace App\Repositories\Eloquent;

use App\Models\AssessmentAnswer;
use App\Repositories\Contracts\AssessmentAnswerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AssessmentAnswerRepository implements AssessmentAnswerRepositoryInterface
{
    protected AssessmentAnswer $model;

    public function __construct(AssessmentAnswer $model)
    {
        $this->model = $model;
    }

    public function create(array $data): AssessmentAnswer
    {
        return $this->model->create($data);
    }

    public function findById(int $id): ?AssessmentAnswer
    {
        return $this->model->with(['assessment', 'question'])->find($id);
    }

    public function findByAssessmentId(int $assessmentId): Collection
    {
        return $this->model->where('assessment_id', $assessmentId)
            ->with('question')
            ->get();
    }

    public function findByQuestionId(int $questionId): Collection
    {
        return $this->model->where('question_id', $questionId)->get();
    }

    public function bulkCreate(array $answers): bool
    {
        try {
            foreach ($answers as $answer) {
                $this->model->create($answer);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function update(int $id, array $data): AssessmentAnswer
    {
        $answer = $this->findById($id);
        $answer->update($data);

        return $answer->fresh();
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id) > 0;
    }

    public function deleteByAssessmentId(int $assessmentId): bool
    {
        return $this->model->where('assessment_id', $assessmentId)->delete() > 0;
    }
}
