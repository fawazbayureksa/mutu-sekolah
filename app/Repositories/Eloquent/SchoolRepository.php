<?php

namespace App\Repositories\Eloquent;

use App\Models\School;
use App\Repositories\Contracts\SchoolRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SchoolRepository implements SchoolRepositoryInterface
{
    protected School $model;

    public function __construct(School $model)
    {
        $this->model = $model;
    }

    public function create(array $data): School
    {
        return $this->model->create($data);
    }

    public function findByNpsn(string $npsn): ?School
    {
        return $this->model->where('npsn', $npsn)->first();
    }

    public function findByName(string $name): ?School
    {
        return $this->model->where('name', $name)->first();
    }

    public function findById(int $id): ?School
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data): School
    {
        $school = $this->findById($id);
        $school->update($data);

        return $school->fresh();
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id) > 0;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
