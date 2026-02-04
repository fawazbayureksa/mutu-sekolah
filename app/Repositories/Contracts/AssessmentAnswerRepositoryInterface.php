<?php

namespace App\Repositories\Contracts;

use App\Models\AssessmentAnswer;
use Illuminate\Database\Eloquent\Collection;

interface AssessmentAnswerRepositoryInterface
{
    public function create(array $data): AssessmentAnswer;

    public function findById(int $id): ?AssessmentAnswer;

    public function findByAssessmentId(int $assessmentId): Collection;

    public function findByQuestionId(int $questionId): Collection;

    public function bulkCreate(array $answers): bool;

    public function update(int $id, array $data): AssessmentAnswer;

    public function delete(int $id): bool;

    public function deleteByAssessmentId(int $assessmentId): bool;
}
