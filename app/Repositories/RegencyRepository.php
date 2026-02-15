<?php

namespace App\Repositories;

use App\Models\Regency;
use Illuminate\Database\Eloquent\Collection;

class RegencyRepository
{
    public function all(): Collection
    {
        return Regency::with('province')->get();
    }

    public function findByCode(string $code): ?Regency
    {
        return Regency::with('province')->where('code', $code)->first();
    }

    public function findByName(string $name): Collection
    {
        return Regency::with('province')->where('name', 'like', '%'.$name.'%')->get();
    }

    public function findByProvinceCode(string $provinceCode): Collection
    {
        return Regency::where('province_code', $provinceCode)->orderBy('name')->get();
    }

    public function getPaginated(int $perPage = 15)
    {
        return Regency::with('province')->orderBy('name')->paginate($perPage);
    }

    public function search(string $keyword): Collection
    {
        return Regency::with('province')
            ->where('name', 'like', '%'.$keyword.'%')
            ->orWhereHas('province', function ($query) use ($keyword) {
                $query->where('name', 'like', '%'.$keyword.'%');
            })
            ->get();
    }
}
