<?php

namespace App\Services;

use App\Models\Province;
use App\Models\Regency;
use App\Repositories\ProvinceRepository;
use App\Repositories\RegencyRepository;
use Illuminate\Database\Eloquent\Collection;

class LocationService
{
    protected ProvinceRepository $provinceRepository;

    protected RegencyRepository $regencyRepository;

    public function __construct(ProvinceRepository $provinceRepository, RegencyRepository $regencyRepository)
    {
        $this->provinceRepository = $provinceRepository;
        $this->regencyRepository = $regencyRepository;
    }

    public function getAllProvinces(): Collection
    {
        return $this->provinceRepository->all();
    }

    public function getProvinceByCode(string $code): ?Province
    {
        return $this->provinceRepository->findByCode($code);
    }

    public function getProvinceByName(string $name): Collection
    {
        return $this->provinceRepository->findByName($name);
    }

    public function getProvincesWithRegencies(): Collection
    {
        return $this->provinceRepository->withRegencies();
    }

    public function getProvinceWithRegencies(string $code): ?Province
    {
        return $this->provinceRepository->findByCodeWithRegencies($code);
    }

    public function getProvincesPaginated(int $perPage = 15)
    {
        return $this->provinceRepository->getPaginated($perPage);
    }

    public function getAllRegencies(): Collection
    {
        return $this->regencyRepository->all();
    }

    public function getRegencyByCode(string $code): ?Regency
    {
        return $this->regencyRepository->findByCode($code);
    }

    public function getRegencyByName(string $name): Collection
    {
        return $this->regencyRepository->findByName($name);
    }

    public function getRegenciesByProvince(string $provinceCode): Collection
    {
        return $this->regencyRepository->findByProvinceCode($provinceCode);
    }

    public function getRegenciesPaginated(int $perPage = 15)
    {
        return $this->regencyRepository->getPaginated($perPage);
    }

    public function searchRegencies(string $keyword): Collection
    {
        return $this->regencyRepository->search($keyword);
    }
}
