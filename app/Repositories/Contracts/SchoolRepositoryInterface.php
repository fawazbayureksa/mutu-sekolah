<?php

namespace App\Repositories\Contracts;

use App\Models\School;

interface SchoolRepositoryInterface
{
    public function create(array $data): School;

    public function findByNpsn(string $npsn): ?School;

    public function findByName(string $name): ?School;

    public function findById(int $id): ?School;

    public function update(int $id, array $data): School;

    public function delete(int $id): bool;

    public function all(): \Illuminate\Database\Eloquent\Collection;
}
