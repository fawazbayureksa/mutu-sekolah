<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Services\InstrumentSubmissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubmissionUpdateController extends Controller
{
    protected InstrumentSubmissionService $service;

    public function __construct(InstrumentSubmissionService $service)
    {
        $this->service = $service;
    }

    public function show(Request $request, string $token)
    {
        $submission = Submission::where('update_token', $token)->firstOrFail();

        if (!$submission->isUpdateTokenValid()) {
            abort(403, 'Link sudah tidak berlaku atau sudah digunakan.');
        }

        // Load necessary relationships
        $submission->load(['school', 'instrument', 'responses.instrumentItem.question']);

        // Get the instrument with hierarchy
        $instrument = $this->service->getInstrumentWithHierarchy($submission->instrument->code)
            ?? $this->service->getInstrument($submission->instrument->code);
        
        if (!$instrument) {
            abort(404, 'Instrumen tidak ditemukan');
        }

        $useHierarchy = $instrument->aspects()->exists();
        $aspects = $useHierarchy ? $instrument->aspects : collect();

        // Pre-fill old values from existing responses
        $prefillAnswers = [];
        foreach ($submission->responses as $response) {
            // Convert answer to string for structure type (JSON)
            $answerValue = is_array($response->answer) ? json_encode($response->answer) : $response->answer;
            $prefillAnswers[$response->instrument_item_id] = $answerValue;
        }

        return view('submission.update', compact(
            'submission',
            'instrument',
            'aspects',
            'useHierarchy',
            'prefillAnswers',
            'token'
        ));
    }

    public function update(Request $request, string $token)
    {
        $submission = Submission::where('update_token', $token)->firstOrFail();

        if (!$submission->isUpdateTokenValid()) {
            return back()->with('error', 'Link sudah tidak berlaku atau sudah digunakan.');
        }

        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'nullable',
        ]);

        try {
            DB::transaction(function () use ($submission, $request) {
                $answers = $request->input('answers', []);
                $instrument = $submission->instrument;

                // Delete old responses
                $submission->responses()->delete();

                // Process answers similar to InstrumentSubmissionService
                $totalScore = 0;
                $maxPossibleScore = 0;
                $responseCount = 0;

                foreach ($answers as $itemId => $rawAnswer) {
                    $item = \App\Models\InstrumentItem::with(['question.scaleTemplate'])->find($itemId);

                    if (!$item) {
                        Log::warning("InstrumentItem not found: {$itemId}");
                        continue;
                    }

                    // Use the service's normalize and scoring logic
                    $normalizedAnswer = $this->normalizeAnswer($item, $rawAnswer);

                    if ($normalizedAnswer === null) {
                        Log::info("Skipping empty answer for item {$itemId}");
                        continue;
                    }

                    // Calculate scores using AnswerScoringService
                    $scoringService = app(\App\Services\AnswerScoringService::class);
                    $score = $scoringService->calculate($item, $normalizedAnswer);
                    $maxScore = $scoringService->getMaxScore($item);

                    $totalScore += $score;
                    $maxPossibleScore += $maxScore;

                    // Create response
                    \App\Models\Response::create([
                        'submission_id' => $submission->id,
                        'school_id' => $submission->school_id,
                        'instrument_item_id' => $itemId,
                        'answer' => $normalizedAnswer,
                        'score' => $score,
                    ]);

                    $responseCount++;
                }

                // Update submission with new scores
                $submission->update([
                    'total_score' => $totalScore,
                    'max_possible_score' => $maxPossibleScore,
                    'completion_percentage' => $maxPossibleScore > 0
                        ? round(($totalScore / $maxPossibleScore) * 100, 2)
                        : 0,
                    'status' => 'submitted', // Reset to submitted after update
                    'filled_at' => now(),
                ]);

                // Mark token as used
                $submission->markTokenAsUsed();
            });

            return redirect()->route('landing')->with('success', 'Data berhasil diperbarui. Terima kasih atas partisipasi Anda.');
        } catch (\Exception $e) {
            Log::error('Submission update error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.')
                ->withInput();
        }
    }

    protected function normalizeAnswer(\App\Models\InstrumentItem $item, mixed $rawAnswer): mixed
    {
        if ($rawAnswer === null || $rawAnswer === '') {
            return null;
        }

        $answerType = $item->question?->answer_type ?? $item->answer_type;

        return match ($answerType) {
            'structure' => $this->normalizeStructureAnswer($rawAnswer, $item),
            'boolean' => $this->normalizeBooleanAnswer($rawAnswer),
            'number', 'percentage' => $this->normalizeNumericAnswer($rawAnswer),
            default => (string) $rawAnswer,
        };
    }

    protected function normalizeStructureAnswer(mixed $answer, \App\Models\InstrumentItem $item): ?array
    {
        $parsed = is_string($answer) ? json_decode($answer, true) : $answer;

        if (!is_array($parsed)) {
            Log::warning("Structure answer is not valid JSON/array", ['answer' => $answer]);
            return null;
        }

        $filtered = array_filter($parsed, function ($row) {
            if (!is_array($row)) {
                return false;
            }
            foreach ($row as $key => $value) {
                if ($key !== 'label' && $value !== '' && $value !== null) {
                    return true;
                }
            }
            return false;
        });

        $schema = $item->question?->answer_options ?? [];
        $numericColumns = collect($schema['columns'] ?? [])
            ->filter(fn($col) => in_array($col['type'] ?? '', ['number', 'percentage']))
            ->pluck('key')
            ->toArray();

        return array_map(function ($row) use ($numericColumns) {
            foreach ($numericColumns as $col) {
                if (isset($row[$col])) {
                    $row[$col] = is_numeric($row[$col]) ? (float) $row[$col] : 0;
                }
            }
            return $row;
        }, array_values($filtered));
    }

    protected function normalizeBooleanAnswer(mixed $answer): string
    {
        $truthyValues = ['yes', 'ya', '1', 'true', 'ada', 'sudah'];
        return in_array(strtolower((string) $answer), $truthyValues) ? 'Yes' : 'No';
    }

    protected function normalizeNumericAnswer(mixed $answer): float
    {
        return is_numeric($answer) ? (float) $answer : 0;
    }
}

