# Assessment & Instrument System Audit Report

**Date**: February 9, 2026  
**Status**: Production Review  
**Scope**: Full audit of answer persistence system

---

## Table of Contents

1. [Key Issues Found](#1-key-issues-found)
2. [Root Causes](#2-root-causes)
3. [Table Responsibility Map](#3-table-responsibility-map)
4. [Recommended Canonical Save Flow](#4-recommended-canonical-save-flow)
5. [Example Payloads](#5-example-payloads)
6. [Laravel Validation Rules](#6-laravel-validation-rules)
7. [Example Save Logic](#7-example-save-logic)
8. [Required Model Fixes](#8-required-model-fixes)
9. [Best Practices Summary](#9-best-practices-summary)
10. [Immediate Action Items](#10-immediate-action-items)

---

## 1. Key Issues Found

### Critical Issues

| # | Issue | Severity |
|---|-------|----------|
| 1 | **Validation is disabled** - The `$this->validate()` call is commented out in `InstrumentSubmissionService::submit()` (line 36) | 🔴 Critical |
| 2 | **Submission model missing fillable fields** - `total_score`, `max_possible_score`, `completion_percentage` are not in `$fillable` | 🔴 Critical |
| 3 | **Response model missing JSON cast** - `answer` column stores JSON for table-type but has no `'answer' => 'array'` cast | 🔴 Critical |
| 4 | **Dual answer storage creates ambiguity** - Both `assessment_answers` and `responses` tables exist for similar purposes | 🔴 Critical |

### Medium Issues

| # | Issue | Severity |
|---|-------|----------|
| 5 | **No answer integrity validation** - Table-type answers are not validated against their JSON schema | 🟠 Medium |
| 6 | **Empty row handling** - No filtering of empty rows before saving table-type answers | 🟠 Medium |
| 7 | **Missing transaction rollback logging** - Exceptions silently fail without specific error tracking | 🟠 Medium |
| 8 | **Score calculation inconsistency** - Both `InstrumentSubmissionService::calculateScore()` and `Response::calculateScore()` exist with different logic | 🟠 Medium |

### Minor Issues

| # | Issue | Severity |
|---|-------|----------|
| 9 | **Redundant `school_id`** - Stored in both `submissions` and `responses` (denormalization) | 🟡 Minor |
| 10 | **Missing index** - `responses.instrument_item_id` + `submission_id` compound index missing | 🟡 Minor |

---

## 2. Root Causes

| Issue | Root Cause |
|-------|------------|
| Answers not persisting | Validation disabled; potential silent failures in score calculation |
| Table answers lost | JSON not cast in Response model; empty values not filtered |
| Data integrity risk | No schema validation for structure-type answers |
| Confusing architecture | Two separate "answer" tables evolved in parallel |
| Score mismatch | Duplicate calculation logic without single source of truth |

---

## 3. Table Responsibility Map

### Current State (Confusing)

| Table | Current Usage | Problem |
|-------|--------------|---------|
| `assessments` | Self-assessment metadata (school + instrument) | Overlaps with `submissions` |
| `assessment_answers` | Answers linked to `assessments` | NOT USED in form flow |
| `submissions` | Form submission metadata | Active, correct |
| `responses` | Answers linked to `submissions` | Active, correct |

### Recommended State (Clear Separation)

| Table | Responsibility | Scope |
|-------|---------------|-------|
| `submissions` | **Submission envelope** - who, when, status, totals | Per-form-submission |
| `responses` | **Answer storage** - individual answers with scores | Per-question-per-submission |
| `assessments` | **Assessment period** - aggregated evaluation record | Per-school-per-period |
| `assessment_answers` | **Deprecate or use for verified/audited answers** | Post-validation only |

### Verdict

For the public instrument form:
- ✅ **Source of truth for answers**: `responses` table
- ✅ **Source of truth for submission metadata**: `submissions` table
- ❌ **DO NOT USE** `assessment_answers` for public form submissions

---

## 4. Recommended Canonical Save Flow

```
┌─────────────────────────────────────────────────────────────────────────────┐
│  STEP 1: VALIDATE REQUEST                                                   │
│  ├── Validate school data (school_name, npsn, address)                     │
│  ├── Validate respondent data (name, position)                             │
│  └── Validate answers array structure                                       │
└─────────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│  STEP 2: BEGIN TRANSACTION                                                  │
└─────────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│  STEP 3: RESOLVE SCHOOL                                                     │
│  ├── Search by NPSN (if provided)                                          │
│  ├── If not found, search by exact school_name                             │
│  └── If not found, create new school record                                │
└─────────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│  STEP 4: CREATE SUBMISSION                                                  │
│  ├── Link to school_id                                                     │
│  ├── Link to instrument_id                                                 │
│  ├── Set status = 'submitted'                                              │
│  └── Set initial scores = 0                                                │
└─────────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│  STEP 5: PROCESS EACH ANSWER                                                │
│  For each (itemId => answerValue):                                         │
│    ├── Load InstrumentItem with Question + ScaleTemplate                   │
│    ├── Validate answer against question type                               │
│    ├── For STRUCTURE type:                                                 │
│    │   ├── Parse JSON if string                                            │
│    │   ├── Validate against schema (columns/rows)                          │
│    │   ├── Filter empty rows                                               │
│    │   └── Re-encode as JSON                                               │
│    ├── Calculate score via single scoring service                          │
│    └── Build response record                                               │
└─────────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│  STEP 6: UPDATE SUBMISSION TOTALS                                           │
│  ├── Sum all response scores                                               │
│  ├── Sum all max possible scores                                           │
│  ├── Calculate completion percentage                                       │
│  └── Update submission record                                              │
└─────────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│  STEP 7: COMMIT TRANSACTION                                                 │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 5. Example Payloads

### Simple Answer Payload

```php
[
    'school_name' => 'SMK Negeri 1 Jakarta',
    'npsn' => '20100001',
    'address' => 'Jl. Merdeka No. 1, Jakarta Pusat, DKI Jakarta 10110',
    'respondent_name' => 'Budi Santoso',
    'respondent_position' => 'Kepala Sekolah',
    'answers' => [
        '101' => 'Yes',           // boolean (item_id => value)
        '102' => '4',             // scale
        '103' => '85',            // percentage
        '104' => 'Teks bebas',    // text
    ]
]
```

### Table/Structure Answer Payload

```php
[
    // ... school/respondent fields ...
    'answers' => [
        '105' => '[
            {"label": "Guru PNS", "jumlah": 15, "persentase": 60},
            {"label": "Guru Non-PNS", "jumlah": 10, "persentase": 40}
        ]',  // JSON string from frontend
    ]
]
```

### Normalized Structure (After Parse)

```php
[
    [
        'label' => 'Guru PNS',
        'jumlah' => 15,
        'persentase' => 60.0,
    ],
    [
        'label' => 'Guru Non-PNS', 
        'jumlah' => 10,
        'persentase' => 40.0,
    ],
]
```

---

## 6. Laravel Validation Rules

### Form Request Class

Create file: `app/Http/Requests/InstrumentSubmissionRequest.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\InstrumentItem;

class InstrumentSubmissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // School data
            'school_name' => ['required', 'string', 'max:255'],
            'npsn' => ['nullable', 'string', 'max:20', 'regex:/^\d{8}$/'],
            'address' => ['required', 'string', 'max:500'],
            
            // Respondent data
            'respondent_name' => ['required', 'string', 'max:255'],
            'respondent_position' => ['required', 'string', 'max:255'],
            
            // Answers array
            'answers' => ['required', 'array', 'min:1'],
            'answers.*' => ['present'], // Allow empty for optional questions
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $this->validateAnswerTypes($validator);
        });
    }

    protected function validateAnswerTypes($validator): void
    {
        $answers = $this->input('answers', []);
        
        foreach ($answers as $itemId => $answer) {
            $item = InstrumentItem::with('question')->find($itemId);
            
            if (!$item) {
                $validator->errors()->add(
                    "answers.{$itemId}", 
                    "Item tidak ditemukan."
                );
                continue;
            }

            $question = $item->question;
            $answerType = $question?->answer_type ?? $item->answer_type;
            $isRequired = $question?->is_required ?? true;

            // Skip empty answers for optional questions
            if (empty($answer) && !$isRequired) {
                continue;
            }

            // Validate required
            if (empty($answer) && $isRequired) {
                $validator->errors()->add(
                    "answers.{$itemId}", 
                    "Pertanyaan ini wajib diisi."
                );
                continue;
            }

            // Type-specific validation
            match ($answerType) {
                'boolean' => $this->validateBoolean($validator, $itemId, $answer),
                'scale', 'multiple_choice' => $this->validateScale($validator, $itemId, $answer, $question),
                'number' => $this->validateNumber($validator, $itemId, $answer),
                'percentage' => $this->validatePercentage($validator, $itemId, $answer),
                'structure' => $this->validateStructure($validator, $itemId, $answer, $question),
                default => null,
            };
        }
    }

    protected function validateBoolean($validator, $itemId, $answer): void
    {
        if (!in_array($answer, ['Yes', 'No', 'yes', 'no', '1', '0'])) {
            $validator->errors()->add(
                "answers.{$itemId}", 
                "Jawaban harus Ya atau Tidak."
            );
        }
    }

    protected function validateScale($validator, $itemId, $answer, $question): void
    {
        $options = $question?->getAnswerOptionsArray() ?? [];
        $validValues = array_column($options, 'value');
        
        if (!in_array($answer, $validValues)) {
            $validator->errors()->add(
                "answers.{$itemId}", 
                "Pilihan tidak valid."
            );
        }
    }

    protected function validateNumber($validator, $itemId, $answer): void
    {
        if (!is_numeric($answer)) {
            $validator->errors()->add(
                "answers.{$itemId}", 
                "Jawaban harus berupa angka."
            );
        }
    }

    protected function validatePercentage($validator, $itemId, $answer): void
    {
        if (!is_numeric($answer) || $answer < 0 || $answer > 100) {
            $validator->errors()->add(
                "answers.{$itemId}", 
                "Persentase harus antara 0-100."
            );
        }
    }

    protected function validateStructure($validator, $itemId, $answer, $question): void
    {
        $parsed = is_string($answer) ? json_decode($answer, true) : $answer;
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            $validator->errors()->add(
                "answers.{$itemId}", 
                "Format data tabel tidak valid."
            );
            return;
        }

        if (!is_array($parsed)) {
            $validator->errors()->add(
                "answers.{$itemId}", 
                "Data tabel harus berupa array."
            );
            return;
        }

        // Validate against schema
        $schema = $question?->answer_options ?? [];
        $requiredColumns = collect($schema['columns'] ?? [])
            ->where('required', true)
            ->pluck('key')
            ->toArray();

        foreach ($parsed as $rowIndex => $row) {
            if (!is_array($row)) {
                continue;
            }
            
            foreach ($requiredColumns as $col) {
                if (!isset($row[$col]) || $row[$col] === '') {
                    $validator->errors()->add(
                        "answers.{$itemId}", 
                        "Kolom {$col} pada baris " . ($rowIndex + 1) . " wajib diisi."
                    );
                }
            }
        }
    }
}
```

---

## 7. Example Save Logic

### Refactored InstrumentSubmissionService

```php
<?php

namespace App\Services;

use App\Models\School;
use App\Models\Submission;
use App\Models\Response;
use App\Models\InstrumentItem;
use App\Repositories\Contracts\InstrumentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InstrumentSubmissionService
{
    public function __construct(
        protected InstrumentRepositoryInterface $repository,
        protected AnswerScoringService $scoringService
    ) {}

    public function submit(array $validated): Submission
    {
        return DB::transaction(function () use ($validated) {
            // 1. Load instrument
            $instrument = $this->loadInstrument();
            
            // 2. Resolve school
            $school = $this->resolveSchool($validated);
            
            // 3. Create submission
            $submission = $this->createSubmission($school, $instrument, $validated);
            
            // 4. Process and store responses
            $totals = $this->processAnswers(
                $submission,
                $school->id,
                $validated['answers'] ?? [],
                $instrument
            );
            
            // 5. Update submission totals
            $submission->update([
                'total_score' => $totals['total_score'],
                'max_possible_score' => $totals['max_possible_score'],
                'completion_percentage' => $totals['completion_percentage'],
            ]);
            
            Log::info('Instrument submission completed', [
                'submission_id' => $submission->id,
                'school_id' => $school->id,
                'response_count' => $totals['response_count'],
            ]);
            
            return $submission->fresh();
        });
    }

    protected function loadInstrument(): \App\Models\Instrument
    {
        $instrument = $this->repository->getInstrumentWithHierarchy('KPTK-ADV-2024')
            ?? $this->repository->getInstrumentWithItems('KPTK-2024');
            
        if (!$instrument) {
            throw new \RuntimeException('Active instrument not found');
        }
        
        return $instrument;
    }

    protected function resolveSchool(array $data): School
    {
        // Try NPSN first (unique identifier)
        if (!empty($data['npsn'])) {
            $school = School::where('npsn', $data['npsn'])->first();
            if ($school) {
                // Update address if changed
                $school->update(['address' => $data['address']]);
                return $school;
            }
        }
        
        // Create new school
        return School::create([
            'school_name' => $data['school_name'],
            'npsn' => $data['npsn'] ?? null,
            'address' => $data['address'],
        ]);
    }

    protected function createSubmission(School $school, $instrument, array $data): Submission
    {
        return Submission::create([
            'school_id' => $school->id,
            'instrument_id' => $instrument->id,
            'respondent_name' => $data['respondent_name'],
            'respondent_position' => $data['respondent_position'],
            'filled_at' => now(),
            'status' => 'submitted',
            'total_score' => 0,
            'max_possible_score' => 0,
            'completion_percentage' => 0,
        ]);
    }

    protected function processAnswers(
        Submission $submission, 
        int $schoolId, 
        array $answers, 
        $instrument
    ): array {
        $totalScore = 0;
        $maxPossibleScore = 0;
        $responseCount = 0;

        foreach ($answers as $itemId => $rawAnswer) {
            // Load item with relationships
            $item = InstrumentItem::with(['question.scaleTemplate'])->find($itemId);
            
            if (!$item) {
                Log::warning("InstrumentItem not found: {$itemId}");
                continue;
            }

            // Normalize answer
            $normalizedAnswer = $this->normalizeAnswer($item, $rawAnswer);
            
            // Skip empty answers
            if ($normalizedAnswer === null) {
                continue;
            }

            // Calculate scores
            $score = $this->scoringService->calculate($item, $normalizedAnswer);
            $maxScore = $this->scoringService->getMaxScore($item);

            $totalScore += $score;
            $maxPossibleScore += $maxScore;

            // Create response using Eloquent
            Response::create([
                'submission_id' => $submission->id,
                'school_id' => $schoolId,
                'instrument_item_id' => $itemId,
                'answer' => is_array($normalizedAnswer) 
                    ? json_encode($normalizedAnswer) 
                    : (string) $normalizedAnswer,
                'score' => $score,
            ]);
            
            $responseCount++;
        }

        return [
            'total_score' => $totalScore,
            'max_possible_score' => $maxPossibleScore,
            'completion_percentage' => $maxPossibleScore > 0 
                ? round(($totalScore / $maxPossibleScore) * 100, 2) 
                : 0,
            'response_count' => $responseCount,
        ];
    }

    protected function normalizeAnswer(InstrumentItem $item, mixed $rawAnswer): mixed
    {
        // Handle empty
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

    protected function normalizeStructureAnswer(mixed $answer, InstrumentItem $item): ?array
    {
        // Parse JSON string
        $parsed = is_string($answer) ? json_decode($answer, true) : $answer;
        
        if (!is_array($parsed)) {
            return null;
        }

        // Filter empty rows
        $filtered = array_filter($parsed, function ($row) {
            if (!is_array($row)) {
                return false;
            }
            // Keep row if any value (except label) is non-empty
            foreach ($row as $key => $value) {
                if ($key !== 'label' && $value !== '' && $value !== null) {
                    return true;
                }
            }
            return false;
        });

        // Cast numeric fields
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
```

### Answer Scoring Service (Single Source of Truth)

Create file: `app/Services/AnswerScoringService.php`

```php
<?php

namespace App\Services;

use App\Models\InstrumentItem;

class AnswerScoringService
{
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

    protected function scoreBooleanAnswer(mixed $answer, $question): float
    {
        $isYes = in_array(strtolower((string) $answer), ['yes', 'ya', '1', 'true']);
        return $isYes ? (float) $question->max_score : (float) $question->min_score;
    }

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
            return array_sum(array_column($answer, $scoreColumn));
        }

        // Default: percentage based on filled rows
        $total = count($schema['rows'] ?? []);
        $filled = count($answer);
        
        return $total > 0 ? ($filled / $total) * 100 : 0;
    }
}
```

---

## 8. Required Model Fixes

### Submission Model

File: `app/Models/Submission.php`

```php
protected $fillable = [
    'school_id',
    'instrument_id',
    'respondent_name',
    'respondent_position',
    'filled_at',
    'status',
    'total_score',           // ← ADD
    'max_possible_score',    // ← ADD
    'completion_percentage', // ← ADD
    'verified_by',
    'verified_at',
    'validation_notes',
];

protected $casts = [
    'filled_at' => 'date',
    'verified_at' => 'datetime',
    'total_score' => 'decimal:2',           // ← ADD
    'max_possible_score' => 'decimal:2',    // ← ADD
    'completion_percentage' => 'decimal:2', // ← ADD
];
```

### Response Model

File: `app/Models/Response.php`

```php
protected $fillable = [
    'submission_id',
    'school_id',
    'instrument_item_id',
    'answer',
    'score',
    'notes',
];

protected $casts = [
    'score' => 'decimal:2',
    'answer' => 'array',  // ← ADD - enables automatic JSON encode/decode
];
```

---

## 9. Best Practices Summary

| Category | Recommendation |
|----------|----------------|
| **Single Source of Truth** | Use `responses` table for form answers. Do NOT also insert into `assessment_answers`. |
| **Validation** | Always validate server-side. Use FormRequest class. Never trust frontend. |
| **JSON Handling** | Always cast JSON columns in models. Validate structure before save. |
| **Transactions** | Wrap all multi-table operations in `DB::transaction()`. |
| **Scoring** | Use single `AnswerScoringService`. Remove duplicate logic from Response model. |
| **Logging** | Log all submissions with submission_id, school_id, response_count. |
| **Empty Values** | Filter empty rows from table answers BEFORE saving. |
| **Type Casting** | Cast numeric values explicitly. Don't rely on PHP type juggling. |
| **Fillable** | Keep `$fillable` in sync with columns you write to. Avoid `$guarded = []`. |
| **Foreign Keys** | Ensure all FK relationships are enforced at database level. |

---

## 10. Immediate Action Items

### Priority 1 (Critical - Must Fix)

- [ ] **Enable validation** - Uncomment line 36 in `InstrumentSubmissionService::submit()`
- [ ] **Fix Submission $fillable** - Add `total_score`, `max_possible_score`, `completion_percentage`
- [ ] **Fix Response $casts** - Add `'answer' => 'array'`

### Priority 2 (High - Should Fix)

- [ ] **Create FormRequest** - Create `InstrumentSubmissionRequest` class
- [ ] **Extract AnswerScoringService** - Single scoring logic source
- [ ] **Add logging** - Track all submissions with metadata

### Priority 3 (Medium - Nice to Have)

- [ ] **Add compound index** - `responses` table on `(submission_id, instrument_item_id)`
- [ ] **Test table-type answers** - Verify JSON persistence and retrieval
- [ ] **Document API contracts** - Expected payload structures

---

## Database Schema Reference

### responses table

```sql
CREATE TABLE responses (
    id BIGINT UNSIGNED PRIMARY KEY,
    submission_id BIGINT UNSIGNED NOT NULL,
    school_id BIGINT UNSIGNED,
    instrument_item_id BIGINT UNSIGNED NOT NULL,
    answer TEXT NOT NULL,
    score DECIMAL(8,2),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (submission_id) REFERENCES submissions(id) ON DELETE CASCADE,
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (instrument_item_id) REFERENCES instrument_items(id) ON DELETE CASCADE,
    
    INDEX idx_submission_item (submission_id, instrument_item_id)
);
```

### submissions table

```sql
CREATE TABLE submissions (
    id BIGINT UNSIGNED PRIMARY KEY,
    school_id BIGINT UNSIGNED NOT NULL,
    instrument_id BIGINT UNSIGNED NOT NULL,
    respondent_name VARCHAR(255) NOT NULL,
    respondent_position VARCHAR(255) NOT NULL,
    filled_at DATE NOT NULL,
    status ENUM('draft', 'submitted', 'verified', 'validated') NOT NULL,
    total_score DECIMAL(10,2),
    max_possible_score DECIMAL(10,2),
    completion_percentage DECIMAL(5,2),
    verified_by BIGINT UNSIGNED,
    verified_at TIMESTAMP,
    validation_notes TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (instrument_id) REFERENCES instruments(id) ON DELETE CASCADE,
    FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL
);
```

---