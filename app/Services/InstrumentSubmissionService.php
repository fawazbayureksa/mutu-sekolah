<?php

namespace App\Services;

use App\Models\School;
use App\Repositories\Contracts\InstrumentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InstrumentSubmissionService
{
    protected InstrumentRepositoryInterface $repository;

    public function __construct(InstrumentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getInstrument(string $code): ?\App\Models\Instrument
    {
        return $this->repository->getInstrumentWithItems($code);
    }

    public function submit(array $payload): School
    {
        $validated = $this->validate($payload);

        return DB::transaction(function () use ($validated) {
            $schoolData = [
                'school_name' => $validated['school_name'],
                'npsn' => $validated['npsn'] ?? null,
                'province' => $validated['province'],
                'city' => $validated['city'],
                'respondent_name' => $validated['respondent_name'],
                'respondent_position' => $validated['respondent_position'],
                'filled_at' => now(),
            ];

            $school = $this->repository->storeSchool($schoolData);
            $this->repository->storeResponses($school->id, $validated['answers']);

            return $school;
        });
    }

    protected function validate(array $payload): array
    {
        $validator = Validator::make($payload, [
            'school_name' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:20',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'respondent_name' => 'required|string|max:255',
            'respondent_position' => 'required|string|max:255',
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return $validator->validated();
    }
}
