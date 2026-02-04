<?php

namespace App\Repositories;

use App\Models\Instrument;
use App\Models\Response;
use App\Models\School;
use App\Repositories\Contracts\InstrumentRepositoryInterface;

class InstrumentRepository implements InstrumentRepositoryInterface
{
    public function getInstrumentWithItems(string $code): ?Instrument
    {
        return Instrument::with('items')
            ->where('code', $code)
            ->first();
    }

    public function storeSchool(array $data): School
    {
        return School::create($data);
    }

    public function storeResponses(int $schoolId, array $answers): bool
    {
        foreach ($answers as $instrumentItemId => $answerValue) {
            Response::create([
                'school_id' => $schoolId,
                'instrument_item_id' => $instrumentItemId,
                'answer' => $answerValue,
            ]);
        }

        return true;
    }
}
