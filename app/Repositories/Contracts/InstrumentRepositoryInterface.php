<?php

namespace App\Repositories\Contracts;

use App\Models\Instrument;

interface InstrumentRepositoryInterface
{
    public function getInstrumentWithItems(string $code): ?Instrument;

    public function getInstrumentWithHierarchy(string $code): ?Instrument;

    public function storeSchool(array $data): \App\Models\School;

    public function storeResponses(int $schoolId, array $answers): bool;
}
