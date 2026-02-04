<?php

namespace App\Repositories\Contracts;

use App\Models\Assessment;
use Illuminate\Database\Eloquent\Collection;

interface AssessmentRepositoryInterface
{
    public function create(array $data): Assessment;

    public function findById(int $id): ?Assessment;

    public function update(int $id, array $data): Assessment;

    public function delete(int $id): bool;

    public function findBySchoolId(int $schoolId): Collection;

    public function findByStatus(string $status): Collection;

    public function findByPeriodYear(string $year): Collection;

    public function updateStatus(int $id, string $status): bool;
}
