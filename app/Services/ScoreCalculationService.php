<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use App\Models\Instrument;

class ScoreCalculationService
{
    public function calculateAssessmentScore(Assessment $assessment): array
    {
        $instrument = $assessment->instrument;

        if (!$instrument) {
            return [
                'total_score' => 0,
                'max_possible_score' => 0,
                'percentage' => 0,
                'grade' => 'N/A',
            ];
        }

        $totalScore = 0;
        $maxScore = 0;
        $answersCount = 0;

        foreach ($assessment->answers as $answer) {
            $question = $answer->question;

            if (!$question) {
                continue;
            }

            $score = $answer->score ?? $answer->calculateScore();
            $totalScore += $score;
            $answersCount++;
        }

        $maxScore = $this->calculateMaxPossibleScore($instrument);
        $percentage = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;
        $grade = $this->calculateGrade($percentage);

        return [
            'total_score' => round($totalScore, 2),
            'max_possible_score' => round($maxScore, 2),
            'percentage' => round($percentage, 2),
            'grade' => $grade,
            'answered_questions' => $answersCount,
        ];
    }

    public function calculateMaxPossibleScore(Instrument $instrument): float
    {
        $maxScore = 0;

        foreach ($instrument->items as $item) {
            if ($item->uses_master_question && $item->question) {
                $question = $item->question;
                $maxScore += $question->max_score * $question->weight;
            }
        }

        return $maxScore;
    }

    public function calculateGrade(float $percentage): string
    {
        if ($percentage >= 90) {
            return 'A';
        } elseif ($percentage >= 80) {
            return 'B';
        } elseif ($percentage >= 70) {
            return 'C';
        } elseif ($percentage >= 60) {
            return 'D';
        } else {
            return 'E';
        }
    }

    public function calculateAnswerScore(AssessmentAnswer $answer): ?float
    {
        $question = $answer->question;

        if (!$question) {
            return null;
        }

        return $answer->calculateScore();
    }

    public function updateAssessmentScores(Assessment $assessment): void
    {
        $scores = $this->calculateAssessmentScore($assessment);

        $assessment->update([
            'total_score' => $scores['total_score'],
            'max_possible_score' => $scores['max_possible_score'],
            'percentage' => $scores['percentage'],
            'grade' => $scores['grade'],
            'answered_questions' => $scores['answered_questions'],
            'total_questions' => $assessment->instrument->items()->count(),
            'completion_percentage' => ($scores['answered_questions'] / $assessment->instrument->items()->count()) * 100,
        ]);
    }

    public function calculateAspectScores(Assessment $assessment): array
    {
        $aspectScores = [];

        foreach ($assessment->instrument->aspects as $aspect) {
            $aspectTotalScore = 0;
            $aspectMaxScore = 0;

            foreach ($aspect->questions as $question) {
                $answer = $assessment->answers()->where('question_id', $question->id)->first();

                if ($answer) {
                    $aspectTotalScore += $answer->score ?? 0;
                }

                $aspectMaxScore += $question->max_score * $question->weight;
            }

            $aspectPercentage = $aspectMaxScore > 0 ? ($aspectTotalScore / $aspectMaxScore) * 100 : 0;

            $aspectScores[] = [
                'aspect_id' => $aspect->id,
                'aspect_code' => $aspect->code,
                'aspect_name' => $aspect->name,
                'total_score' => round($aspectTotalScore, 2),
                'max_score' => round($aspectMaxScore, 2),
                'percentage' => round($aspectPercentage, 2),
                'grade' => $this->calculateGrade($aspectPercentage),
            ];
        }

        return $aspectScores;
    }

    public function calculateAndStoreScores(Assessment $assessment): void
    {
        $scores = $this->calculateAssessmentScore($assessment);

        $assessment->update([
            'total_score' => $scores['total_score'],
            'max_score' => $scores['max_possible_score'],
            'percentage' => $scores['percentage'],
            'grade' => $scores['grade'],
        ]);
    }

    public function calculateScoreByAspect(Assessment $assessment): array
    {
        $scoreByAspect = [];

        // Group answers by aspect
        $assessment->load(['answers.question.indicator.aspect']);

        foreach ($assessment->answers as $answer) {
            $aspect = $answer->question->indicator->aspect ?? null;

            if (!$aspect) {
                continue;
            }

            $aspectName = $aspect->aspect_name;

            if (!isset($scoreByAspect[$aspectName])) {
                $scoreByAspect[$aspectName] = [
                    'score' => 0,
                    'max_score' => 0,
                ];
            }

            $scoreByAspect[$aspectName]['score'] += $answer->score ?? 0;
            $scoreByAspect[$aspectName]['max_score'] += $answer->question->max_score * $answer->question->weight;
        }

        return $scoreByAspect;
    }
}
