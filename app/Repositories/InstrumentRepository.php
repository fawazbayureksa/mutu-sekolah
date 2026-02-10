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

    public function getInstrumentWithHierarchy(string $code): ?Instrument
    {
        return Instrument::with([
            'items' => function ($query) {
                $query->orderBy('order');
            },
            'items.question' => function ($query) {
                $query->with('scaleTemplate');
            },
            'aspects' => function ($query) {
                $query->orderByPivot('order')
                    ->with([
                        'indicators' => function ($q) {
                            $q->orderBy('order')
                                ->with([
                                    'questions' => function ($q2) {
                                        $q2->orderBy('order')
                                            ->where('is_active', true)
                                            ->with('scaleTemplate');
                                    }
                                ]);
                        }
                    ]);
            },
        ])
            ->where('code', $code)
            ->where('is_active', true)
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
