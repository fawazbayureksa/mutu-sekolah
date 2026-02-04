<?php

namespace App\Services;

use App\Models\School;
use App\Repositories\Contracts\SchoolRepositoryInterface;

class SchoolService
{
    protected SchoolRepositoryInterface $schoolRepository;

    public function __construct(SchoolRepositoryInterface $schoolRepository)
    {
        $this->schoolRepository = $schoolRepository;
    }

    public function getOrCreate(array $data): School
    {
        $school = null;

        if (! empty($data['npsn'])) {
            $school = $this->schoolRepository->findByNpsn($data['npsn']);
        }

        if (! $school && ! empty($data['name'])) {
            $school = $this->schoolRepository->findByName($data['name']);
        }

        if (! $school) {
            $school = $this->schoolRepository->create($data);
        } else {
            $this->schoolRepository->update($school->id, $data);
        }

        return $school->fresh();
    }

    public function findById(int $id): ?School
    {
        return $this->schoolRepository->findById($id);
    }

    public function findByNpsn(string $npsn): ?School
    {
        return $this->schoolRepository->findByNpsn($npsn);
    }

    public function findByNpsnOrCreate(array $data): School
    {
        $school = $this->schoolRepository->findByNpsn($data['npsn']);

        if (! $school) {
            $school = $this->schoolRepository->create($data);
        }

        return $school->fresh();
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->schoolRepository->all();
    }
}
