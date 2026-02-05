<?php

namespace App\Services;

use App\Models\School;
use App\Models\Submission;
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

    public function submit(array $payload): Submission
    {
        $validated = $this->validate($payload);

        return DB::transaction(function () use ($validated) {
            // Get instrument
            $instrument = $this->repository->getInstrumentWithItems('KPTK-2024');

            if (!$instrument) {
                throw new \Exception('Instrument not found');
            }

            // Find or create school
            $school = School::firstOrCreate(
                [
                    'npsn' => $validated['npsn'] ?? null,
                    'school_name' => $validated['school_name'],
                ],
                [
                    'province' => $validated['province'],
                    'city' => $validated['city'],
                ]
            );

            // Create submission
            $submission = Submission::create([
                'school_id' => $school->id,
                'instrument_id' => $instrument->id,
                'respondent_name' => $validated['respondent_name'],
                'respondent_position' => $validated['respondent_position'],
                'filled_at' => now(),
                'status' => 'submitted',
            ]);

            // Store responses
            $this->storeResponses($submission->id, $school->id, $validated['answers']);

            return $submission;
        });
    }

    protected function storeResponses(int $submissionId, int $schoolId, array $answers): void
    {
        $responses = [];

        foreach ($answers as $itemId => $answer) {
            $responses[] = [
                'submission_id' => $submissionId,
                'school_id' => $schoolId,
                'instrument_item_id' => $itemId,
                'answer' => $answer,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('responses')->insert($responses);
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
