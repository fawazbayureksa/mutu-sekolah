<?php

namespace App\Services;

use App\Models\InstrumentItem;
use Illuminate\Support\Facades\Log;

class AnswerScoringService
{
    /**
     * Calculate score for a given answer
     *
     * @param InstrumentItem $item
     * @param mixed $answer
     * @return float
     */
    public function calculate(InstrumentItem $item, mixed $answer): float
    {
        $question = $item->question;

        if (!$question) {
            return 0;
        }

        // 1. Scale Template (highest priority)
        if ($question->scaleTemplate) {
            $score = $question->scaleTemplate->getScoreForValue($answer);
            if ($score !== null) {
                return (float) $score;
            }
        }

        // 2. Answer Options on Question
        if ($question->answer_options) {
            $options = is_array($question->answer_options)
                ? $question->answer_options
                : (json_decode($question->answer_options, true) ?? []);

            foreach ($options as $option) {
                if (isset($option['value']) && (string) $option['value'] === (string) $answer) {
                    return (float) ($option['score'] ?? 0);
                }
            }
        }

        // 3. Type-based fallback
        return match ($question->answer_type) {
            'boolean' => $this->scoreBooleanAnswer($answer, $question),
            'percentage' => min(100, max(0, (float) $answer)),
            'number' => (float) $answer,
            'structure' => $this->scoreStructureAnswer($answer, $question),
            default => 0,
        };
    }

    /**
     * Get maximum possible score for an item
     *
     * @param InstrumentItem $item
     * @return float
     */
    public function getMaxScore(InstrumentItem $item): float
    {
        $question = $item->question;

        if (!$question) {
            return 100;
        }

        if ($question->scaleTemplate) {
            return (float) $question->scaleTemplate->max_score;
        }

        return (float) ($question->max_score ?? 100);
    }

    /**
     * Score boolean answer
     *
     * @param mixed $answer
     * @param mixed $question
     * @return float
     */
    protected function scoreBooleanAnswer(mixed $answer, $question): float
    {
        $isYes = in_array(strtolower((string) $answer), ['yes', 'ya', '1', 'true']);
        return $isYes ? (float) $question->max_score : (float) $question->min_score;
    }

    /**
     * Score structure/table answer
     *
     * @param mixed $answer
     * @param mixed $question
     * @return float
     */
    protected function scoreStructureAnswer(mixed $answer, $question): float
    {
        // Structure answers typically don't have direct scores
        // Score could be based on completeness or specific column totals
        if (!is_array($answer)) {
            return 0;
        }

        $schema = $question->answer_options ?? [];
        $scoreColumn = $schema['score_column'] ?? null;

        if ($scoreColumn) {
            // Sum values from a specific column if defined
            return array_sum(array_column($answer, $scoreColumn));
        }

        // Default: percentage based on filled rows vs expected rows
        $total = count($schema['rows'] ?? []);
        $filled = count($answer);

        return $total > 0 ? ($filled / $total) * 100 : 0;
    }
}
