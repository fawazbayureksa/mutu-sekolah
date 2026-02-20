<?php

namespace App\Repositories;

use App\Models\Province;
use Illuminate\Database\Eloquent\Collection;

class ProvinceRepository
{
    public function all(): Collection
    {
        return Province::all();
    }

    public function findByCode(string $code): ?Province
    {
        return Province::where('code', $code)->first();
    }

    public function findByName(string $name): Collection
    {
        return Province::where('name', 'like', '%'.$name.'%')->get();
    }

    public function withRegencies(): Collection
    {
        return Province::with('regencies')->get();
    }

    public function findByCodeWithRegencies(string $code): ?Province
    {
        return Province::with('regencies')->where('code', $code)->first();
    }

    public function getPaginated(int $perPage = 15)
    {
        return Province::orderBy('name')->paginate($perPage);
    }
}
