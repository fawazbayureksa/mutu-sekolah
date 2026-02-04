<?php

namespace App\Repositories\Eloquent;

use App\Models\Assessment;
use App\Repositories\Contracts\AssessmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AssessmentRepository implements AssessmentRepositoryInterface
{
    protected Assessment $model;

    public function __construct(Assessment $model)
    {
        $this->model = $model;
    }

    public function create(array $data): Assessment
    {
        return $this->model->create($data);
    }

    public function findById(int $id): ?Assessment
    {
        return $this->model->with(['school', 'answers'])->find($id);
    }

    public function update(int $id, array $data): Assessment
    {
        $assessment = $this->findById($id);
        $assessment->update($data);

        return $assessment->fresh();
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id) > 0;
    }

    public function findBySchoolId(int $schoolId): Collection
    {
        return $this->model->where('school_id', $schoolId)->get();
    }

    public function findByStatus(string $status): Collection
    {
        return $this->model->where('status', $status)->get();
    }

    public function findByPeriodYear(string $year): Collection
    {
        return $this->model->where('period_year', $year)->get();
    }

    public function updateStatus(int $id, string $status): bool
    {
        return $this->model->where('id', $id)->update([
            'status' => $status,
            'submitted_at' => $status === 'submitted' ? now() : null,
        ]) > 0;
    }
}
