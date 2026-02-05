<?php

namespace App\Services;

use App\Models\Instrument;
use App\Models\InstrumentItem;
use App\Models\InstrumentAspect;
use App\Models\AssessmentQuestion;
use Illuminate\Support\Facades\DB;

class InstrumentManagementService
{
    public function createInstrument(array $data): Instrument
    {
        return DB::transaction(function () use ($data) {
            $instrument = Instrument::create([
                'code' => $data['code'],
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'category' => $data['category'] ?? null,
                'version' => $data['version'] ?? '1.0',
                'instructions' => $data['instructions'] ?? null,
                'estimated_duration' => $data['estimated_duration'] ?? null,
                'scoring_method' => $data['scoring_method'] ?? 'weighted_sum',
                'created_by' => auth()->id(),
                'is_active' => true,
                'is_published' => false,
            ]);

            if (isset($data['aspects']) && is_array($data['aspects'])) {
                $this->attachAspects($instrument, $data['aspects']);
            }

            if (isset($data['questions']) && is_array($data['questions'])) {
                $this->addQuestions($instrument, $data['questions']);
            }

            return $instrument;
        });
    }

    public function updateInstrument(Instrument $instrument, array $data): Instrument
    {
        return DB::transaction(function () use ($instrument, $data) {
            $instrument->update([
                'name' => $data['name'] ?? $instrument->name,
                'description' => $data['description'] ?? $instrument->description,
                'category' => $data['category'] ?? $instrument->category,
                'version' => $data['version'] ?? $instrument->version,
                'instructions' => $data['instructions'] ?? $instrument->instructions,
                'estimated_duration' => $data['estimated_duration'] ?? $instrument->estimated_duration,
                'scoring_method' => $data['scoring_method'] ?? $instrument->scoring_method,
                'updated_by' => auth()->id(),
            ]);

            if (isset($data['aspects']) && is_array($data['aspects'])) {
                $this->syncAspects($instrument, $data['aspects']);
            }

            if (isset($data['questions']) && is_array($data['questions'])) {
                $this->syncQuestions($instrument, $data['questions']);
            }

            return $instrument->fresh();
        });
    }

    public function publishInstrument(Instrument $instrument): Instrument
    {
        $instrument->publish();
        return $instrument;
    }

    public function unpublishInstrument(Instrument $instrument): Instrument
    {
        $instrument->unpublish();
        return $instrument;
    }

    public function duplicateInstrument(Instrument $instrument, array $data): Instrument
    {
        return DB::transaction(function () use ($instrument, $data) {
            $newInstrument = Instrument::create([
                'code' => $data['code'] ?? $instrument->code . '-copy',
                'name' => $data['name'] ?? $instrument->name . ' (Copy)',
                'description' => $instrument->description,
                'category' => $instrument->category,
                'version' => '1.0',
                'instructions' => $instrument->instructions,
                'estimated_duration' => $instrument->estimated_duration,
                'scoring_method' => $instrument->scoring_method,
                'created_by' => auth()->id(),
                'is_active' => true,
                'is_published' => false,
            ]);

            foreach ($instrument->aspects as $aspect) {
                InstrumentAspect::create([
                    'instrument_id' => $newInstrument->id,
                    'aspect_id' => $aspect->id,
                    'order' => $aspect->pivot->order,
                    'weight' => $aspect->pivot->weight,
                ]);
            }

            $order = 1;
            foreach ($instrument->items as $item) {
                InstrumentItem::create([
                    'instrument_id' => $newInstrument->id,
                    'assessment_question_id' => $item->assessment_question_id,
                    'section' => $item->section,
                    'order' => $order++,
                    'uses_master_question' => $item->uses_master_question,
                    'custom_help_text' => $item->custom_help_text,
                    'custom_answer_options' => $item->custom_answer_options,
                ]);
            }

            return $newInstrument;
        });
    }

    protected function attachAspects(Instrument $instrument, array $aspects): void
    {
        foreach ($aspects as $aspectData) {
            InstrumentAspect::create([
                'instrument_id' => $instrument->id,
                'aspect_id' => $aspectData['aspect_id'],
                'order' => $aspectData['order'] ?? 0,
                'weight' => $aspectData['weight'] ?? 1.0,
            ]);
        }
    }

    protected function syncAspects(Instrument $instrument, array $aspects): void
    {
        $instrument->aspects()->detach();

        foreach ($aspects as $aspectData) {
            InstrumentAspect::updateOrCreate(
                [
                    'instrument_id' => $instrument->id,
                    'aspect_id' => $aspectData['aspect_id'],
                ],
                [
                    'order' => $aspectData['order'] ?? 0,
                    'weight' => $aspectData['weight'] ?? 1.0,
                ]
            );
        }
    }

    protected function addQuestions(Instrument $instrument, array $questions): void
    {
        foreach ($questions as $index => $questionData) {
            InstrumentItem::create([
                'instrument_id' => $instrument->id,
                'assessment_question_id' => $questionData['question_id'] ?? null,
                'section' => $questionData['section'] ?? null,
                'order' => $index + 1,
                'uses_master_question' => isset($questionData['question_id']),
            ]);
        }
    }

    protected function syncQuestions(Instrument $instrument, array $questions): void
    {
        $instrument->items()->delete();

        foreach ($questions as $index => $questionData) {
            InstrumentItem::create([
                'instrument_id' => $instrument->id,
                'assessment_question_id' => $questionData['question_id'] ?? null,
                'section' => $questionData['section'] ?? null,
                'order' => $index + 1,
                'uses_master_question' => isset($questionData['question_id']),
            ]);
        }
    }

    public function deleteInstrument(Instrument $instrument): bool
    {
        return $instrument->delete();
    }
}
