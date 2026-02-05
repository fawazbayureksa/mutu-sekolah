# Database Schema Enhancement - Verification Report

**Date:** February 5, 2026  
**Version:** 1.0  
**Status:** 🔍 VERIFICATION IN PROGRESS

---

## 📋 Executive Summary

This document verifies the implementation of database schema enhancements for the unified Assessment & Instrument system.

---

## ✅ Migration Files Status

### Created Migrations

| # | Migration File | Status | Issues |
|---|---|---|---|
| 1 | `2026_02_05_020000_enhance_assessment_questions_table.php` | ✅ Created | - |
| 2 | `2026_02_05_020001_enhance_assessment_answers_table.php` | ✅ Created | - |
| 3 | `2026_02_05_020002_enhance_assessments_table.php` | ✅ Created | - |
| 4 | `2026_02_05_020003_consolidate_assessment_instrument_systems.php` | ✅ Created | - |
| 5 | `2026_02_05_020004_create_answer_options_tables.php` | ✅ Created | - |

---

## 🔍 Detailed Verification

### 1. Assessment Questions Table Enhancement

**Expected Columns:**
- ✅ `question_code` (string, unique, nullable)
- ✅ `answer_options` (json, nullable)
- ✅ `help_text` (text, nullable)
- ✅ `is_required` (boolean, default false)
- ✅ `max_score` (decimal, nullable)
- ✅ `min_score` (decimal, default 0)
- ✅ `scale_template_id` (foreign key, nullable)
- ✅ `is_active` (boolean, default true)
- ✅ `deleted_at` (timestamp, nullable)

**Issues Found:**
- ⚠️ **POTENTIAL ISSUE**: Answer type enum needs verification
  - Migration uses: `'boolean', 'scale', 'number', 'text', 'multiple_choice', 'percentage', 'file'`
  - Original table might have different values
  - **Action Required**: Check if existing enum needs updating

**Recommendation:**
```php
// Add this to migration if needed:
DB::statement("ALTER TABLE assessment_questions MODIFY COLUMN answer_type ENUM('boolean', 'scale', 'number', 'text', 'multiple_choice', 'percentage', 'file') NOT NULL");
```

---

### 2. Assessment Answers Table Enhancement

**Expected Columns:**
- ✅ `score` (decimal, nullable)
- ✅ `numeric_value` (decimal, nullable)
- ✅ `boolean_value` (boolean, nullable)
- ✅ `notes` (text, nullable)
- ✅ `file_path` (string, nullable)
- ✅ `attachments` (json, nullable)
- ✅ `answered_by` (string, nullable)
- ✅ `answered_at` (timestamp, nullable)
- ✅ `validation_status` (enum, default 'pending')
- ✅ `validated_by` (foreign key, nullable)
- ✅ `validated_at` (timestamp, nullable)
- ✅ `validation_notes` (text, nullable)
- ✅ `deleted_at` (timestamp, nullable)

**Issues Found:**
- ⚠️ **POTENTIAL ISSUE**: `answer_value` field behavior
  - New columns added for type-specific storage
  - Need to ensure backward compatibility
  - **Action Required**: Check if existing `answer_value` data needs migration

**Data Migration Needed:**
```php
// Example: Migrate existing answers to new fields
AssessmentAnswer::whereNotNull('answer_value')->chunk(100, function ($answers) {
    foreach ($answers as $answer) {
        $question = $answer->question;
        
        if ($question->answer_type === 'boolean') {
            $answer->boolean_value = filter_var($answer->answer_value, FILTER_VALIDATE_BOOLEAN);
        } elseif ($question->answer_type === 'scale' || $question->answer_type === 'number') {
            $answer->numeric_value = (float) $answer->answer_value;
        }
        
        $answer->save();
    }
});
```

---

### 3. Assessments Table Enhancement

**Expected Columns:**
- ✅ `instrument_id` (foreign key, nullable)
- ✅ `total_score` (decimal, default 0)
- ✅ `max_possible_score` (decimal, nullable)
- ✅ `percentage` (decimal, nullable)
- ✅ `grade` (string, nullable)
- ✅ `academic_year` (string, nullable)
- ✅ `semester` (string, nullable)
- ✅ `assessment_type` (enum, default 'self-assessment')
- ✅ `total_questions` (integer, default 0)
- ✅ `answered_questions` (integer, default 0)
- ✅ `completion_percentage` (decimal, default 0)
- ✅ `started_at` (timestamp, nullable)
- ✅ `completed_at` (timestamp, nullable)
- ✅ `duration_minutes` (integer, nullable)
- ✅ `verified_by` (foreign key, nullable)
- ✅ `verified_at` (timestamp, nullable)
- ✅ `approved_by` (foreign key, nullable)
- ✅ `approved_at` (timestamp, nullable)
- ✅ `remarks` (text, nullable)
- ✅ `metadata` (json, nullable)
- ✅ `deleted_at` (timestamp, nullable)

**Issues Found:**
- ⚠️ **INCONSISTENCY**: Field naming with existing `submissions` table
  - `assessments` has `respondent_name`, `respondent_email`, `respondent_position`, `respondent_phone`
  - `submissions` table (if exists) might have similar fields
  - **Action Required**: Verify if `submissions` table should be merged or kept separate

**Clarification Needed:**
Are these two separate concepts?
1. **Assessment** = School self-assessment submission
2. **Submission** = Individual respondent submission

---

### 4. System Consolidation

**Expected Changes:**
- ✅ `instrument_items.assessment_question_id` (foreign key, nullable)
- ✅ `instrument_items.uses_master_question` (boolean, default false)
- ✅ `instrument_items.custom_help_text` (text, nullable)
- ✅ `instrument_items.custom_answer_options` (json, nullable)
- ✅ `instruments` table enhancements (category, version, is_active, etc.)
- ✅ `instrument_aspects` bridge table created

**Issues Found:**
- ⚠️ **DESIGN QUESTION**: Relationship between `submissions` and `assessments`
  - Current schema has both tables
  - `responses` links to `submissions`
  - `assessment_answers` links to `assessments`
  - **Are these serving different purposes or duplicating functionality?**

**Suggested Consolidation Strategy:**

**Option A: Keep Both (Recommended)**
```
Use Case 1: School-level Assessment
- instruments → assessments → assessment_answers
- One assessment per school per period

Use Case 2: Individual Submissions
- instruments → submissions → responses
- Multiple submissions per instrument (different respondents)
```

**Option B: Merge into One**
```
- instruments → submissions → responses
- Remove assessments/assessment_answers tables
- Add respondent info to submissions
```

---

### 5. Answer Options & Scale Templates

**Expected Tables:**
- ✅ `answer_options` table created
- ✅ `scale_templates` table created
- ✅ Foreign key relationships established

**Issues Found:**
- ⚠️ **POTENTIAL CONFLICT**: Multiple ways to define answer options
  1. In `assessment_questions.answer_options` (JSON)
  2. In `answer_options` table (relational)
  3. Via `scale_template_id` reference
  
  **Which should be the source of truth?**

**Recommended Approach:**
```php
// Priority order for answer options:
1. Check instrument_items.custom_answer_options (instrument-specific override)
2. Check answer_options table (question-specific options)
3. Check scale_templates via scale_template_id (template-based)
4. Fall back to assessment_questions.answer_options (legacy JSON)
```

---

## 🚨 Critical Issues Identified

### Issue #1: Answer Type Enum Mismatch
**Severity:** HIGH  
**Location:** `assessment_questions` and `instrument_items` tables

**Problem:**
- Original seeder uses: `'number', 'option', 'boolean'`
- New migration adds: `'scale', 'percentage', 'file', 'multiple_choice'`
- Existing data might break

**Solution:**
```php
// Create migration: 2026_02_05_030000_fix_answer_type_enum.php
Schema::table('assessment_questions', function (Blueprint $table) {
    DB::statement("ALTER TABLE assessment_questions MODIFY COLUMN answer_type ENUM('boolean', 'scale', 'number', 'text', 'multiple_choice', 'percentage', 'file', 'option') NOT NULL");
});

// Update existing data
DB::table('assessment_questions')
    ->where('answer_type', 'option')
    ->update(['answer_type' => 'multiple_choice']);
```

---

### Issue #2: Duplicate System Structures
**Severity:** MEDIUM  
**Location:** Overall architecture

**Problem:**
Both systems exist independently:
1. `assessments` + `assessment_answers` (15 fields overlap with submissions)
2. `submissions` + `responses` (similar purpose)

**Impact:**
- Confusion for developers
- Data duplication risk
- Inconsistent reporting

**Solution Options:**

**Quick Fix (Low Risk):**
```php
// Add clear documentation in models
class Assessment extends Model {
    // This is for SCHOOL-LEVEL assessments
    // One assessment = One school's complete instrument submission
}

class Submission extends Model {
    // This is for INDIVIDUAL-RESPONDENT submissions
    // Multiple submissions = Multiple people filling same instrument
}
```

**Long-term Fix (Recommended):**
```php
// Create new migration to merge tables
// Keep submissions as main table
// Add assessment_level field: 'school' | 'individual'
Schema::table('submissions', function (Blueprint $table) {
    $table->enum('submission_level', ['school', 'individual'])->default('individual');
    $table->foreignId('assessment_id')->nullable()->constrained('assessments')->onDelete('cascade');
});

// assessments becomes a grouping/summary table
// submissions contains actual response data
```

---

### Issue #3: Missing Model Updates
**Severity:** MEDIUM  
**Location:** App models

**Problem:**
Schema changed but models not updated with new relationships and fields.

**Required Model Updates:**

```php
// app/Models/AssessmentQuestion.php
class AssessmentQuestion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        // ...existing fields...
        'question_code',
        'answer_options',
        'help_text',
        'is_required',
        'max_score',
        'min_score',
        'scale_template_id',
        'is_active',
    ];

    protected $casts = [
        'answer_options' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'max_score' => 'decimal:2',
        'min_score' => 'decimal:2',
    ];

    public function scaleTemplate()
    {
        return $this->belongsTo(ScaleTemplate::class);
    }

    public function answerOptions()
    {
        return $this->hasMany(AnswerOption::class, 'question_id');
    }

    public function instrumentItems()
    {
        return $this->hasMany(InstrumentItem::class, 'assessment_question_id');
    }

    // Get effective answer options (considering priority)
    public function getEffectiveAnswerOptions()
    {
        // Priority: relational options > scale template > JSON field
        if ($this->answerOptions()->exists()) {
            return $this->answerOptions;
        }
        
        if ($this->scaleTemplate) {
            return json_decode($this->scaleTemplate->scale_options, true);
        }
        
        return $this->answer_options;
    }
}
```

```php
// app/Models/Assessment.php
class Assessment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        // ...existing fields...
        'instrument_id',
        'total_score',
        'max_possible_score',
        'percentage',
        'grade',
        'academic_year',
        'semester',
        'assessment_type',
        'total_questions',
        'answered_questions',
        'completion_percentage',
        'started_at',
        'completed_at',
        'duration_minutes',
        'verified_by',
        'verified_at',
        'approved_by',
        'approved_at',
        'remarks',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'filled_at' => 'datetime',
        'submitted_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'total_score' => 'decimal:2',
        'max_possible_score' => 'decimal:2',
        'percentage' => 'decimal:2',
        'completion_percentage' => 'decimal:2',
    ];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Calculate total score from answers
    public function calculateTotalScore()
    {
        return $this->answers()->sum('score');
    }

    // Calculate completion percentage
    public function calculateCompletionPercentage()
    {
        if ($this->total_questions == 0) return 0;
        return ($this->answered_questions / $this->total_questions) * 100;
    }

    // Calculate grade based on percentage
    public function calculateGrade()
    {
        $percentage = $this->percentage ?? 0;
        
        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'E';
    }
}
```

```php
// app/Models/AssessmentAnswer.php
class AssessmentAnswer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        // ...existing fields...
        'score',
        'numeric_value',
        'boolean_value',
        'notes',
        'file_path',
        'attachments',
        'answered_by',
        'answered_at',
        'validation_status',
        'validated_by',
        'validated_at',
        'validation_notes',
    ];

    protected $casts = [
        'attachments' => 'array',
        'boolean_value' => 'boolean',
        'numeric_value' => 'decimal:2',
        'score' => 'decimal:2',
        'answered_at' => 'datetime',
        'validated_at' => 'datetime',
    ];

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    // Auto-calculate score when answer is saved
    protected static function booted()
    {
        static::saving(function ($answer) {
            if ($answer->isDirty('answer_value') || $answer->isDirty('numeric_value')) {
                $answer->calculateScore();
            }
        });
    }

    public function calculateScore()
    {
        $question = $this->question;
        
        if (!$question) return;

        // Get answer options
        $options = $question->getEffectiveAnswerOptions();
        
        if (is_array($options)) {
            // Find matching option and get score
            $answerValue = $this->numeric_value ?? $this->answer_value;
            $option = collect($options)->firstWhere('value', $answerValue);
            
            if ($option && isset($option['score'])) {
                $this->score = $option['score'];
                return;
            }
        }

        // Fallback: calculate based on min/max
        if ($question->max_score && $this->numeric_value !== null) {
            $range = $question->max_score - $question->min_score;
            $this->score = (($this->numeric_value - $question->min_score) / $range) * 100;
        }
    }
}
```

```php
// app/Models/Instrument.php
class Instrument extends Model
{
    use SoftDeletes;

    protected $fillable = [
        // ...existing fields...
        'category',
        'version',
        'is_active',
        'is_published',
        'published_at',
        'created_by',
        'updated_by',
        'instructions',
        'estimated_duration',
        'scoring_method',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function aspects()
    {
        return $this->belongsToMany(AssessmentAspect::class, 'instrument_aspects')
                    ->withPivot('order', 'weight')
                    ->orderBy('order');
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Get total possible score
    public function getTotalPossibleScore()
    {
        return $this->items->sum(function ($item) {
            $question = $item->getEffectiveQuestion();
            return $question ? $question->max_score : 0;
        });
    }
}
```

```php
// app/Models/InstrumentItem.php
class InstrumentItem extends Model
{
    protected $fillable = [
        // ...existing fields...
        'assessment_question_id',
        'uses_master_question',
        'custom_help_text',
        'custom_answer_options',
    ];

    protected $casts = [
        'custom_answer_options' => 'array',
        'uses_master_question' => 'boolean',
    ];

    public function assessmentQuestion()
    {
        return $this->belongsTo(AssessmentQuestion::class);
    }

    // Get effective question (master or custom)
    public function getEffectiveQuestion()
    {
        if ($this->uses_master_question && $this->assessmentQuestion) {
            return $this->assessmentQuestion;
        }
        
        // Return self as question-like object
        return $this;
    }

    // Get effective help text
    public function getEffectiveHelpText()
    {
        if ($this->custom_help_text) {
            return $this->custom_help_text;
        }
        
        if ($this->uses_master_question && $this->assessmentQuestion) {
            return $this->assessmentQuestion->help_text;
        }
        
        return null;
    }

    // Get effective answer options
    public function getEffectiveAnswerOptions()
    {
        if ($this->custom_answer_options) {
            return $this->custom_answer_options;
        }
        
        if ($this->uses_master_question && $this->assessmentQuestion) {
            return $this->assessmentQuestion->getEffectiveAnswerOptions();
        }
        
        return null;
    }
}
```

---

### Issue #4: Missing Service Classes
**Severity:** MEDIUM  
**Location:** Business logic layer

**Problem:**
Complex calculations and workflows should be in service classes, not controllers.

**Required Services:**

```php
// app/Services/AssessmentScoringService.php
<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\AssessmentAnswer;
use Illuminate\Support\Facades\DB;

class AssessmentScoringService
{
    public function calculateAssessmentScore(Assessment $assessment): array
    {
        $answers = $assessment->answers()->with('question')->get();
        
        $totalScore = 0;
        $maxPossibleScore = 0;
        $totalQuestions = 0;
        $answeredQuestions = 0;

        foreach ($answers as $answer) {
            $question = $answer->question;
            
            if (!$question) continue;

            $totalQuestions++;
            $maxPossibleScore += $question->max_score ?? 100;

            if ($answer->answer_value || $answer->numeric_value !== null || $answer->boolean_value !== null) {
                $answeredQuestions++;
                $totalScore += $answer->score ?? 0;
            }
        }

        $percentage = $maxPossibleScore > 0 ? ($totalScore / $maxPossibleScore) * 100 : 0;
        $completionPercentage = $totalQuestions > 0 ? ($answeredQuestions / $totalQuestions) * 100 : 0;

        return [
            'total_score' => round($totalScore, 2),
            'max_possible_score' => round($maxPossibleScore, 2),
            'percentage' => round($percentage, 2),
            'total_questions' => $totalQuestions,
            'answered_questions' => $answeredQuestions,
            'completion_percentage' => round($completionPercentage, 2),
            'grade' => $this->calculateGrade($percentage),
        ];
    }

    public function updateAssessmentScore(Assessment $assessment): Assessment
    {
        $scores = $this->calculateAssessmentScore($assessment);
        $assessment->update($scores);
        
        return $assessment->fresh();
    }

    public function calculateGrade(float $percentage): string
    {
        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'E';
    }

    public function calculateWeightedScore(Assessment $assessment): float
    {
        // Implement weighted scoring based on instrument configuration
        $instrument = $assessment->instrument;
        
        if (!$instrument || $instrument->scoring_method !== 'weighted_sum') {
            return $assessment->total_score;
        }

        $aspectScores = DB::table('assessment_answers')
            ->join('assessment_questions', 'assessment_answers.question_id', '=', 'assessment_questions.id')
            ->join('assessment_indicators', 'assessment_questions.indicator_id', '=', 'assessment_indicators.id')
            ->join('assessment_aspects', 'assessment_indicators.aspect_id', '=', 'assessment_aspects.id')
            ->join('instrument_aspects', 'assessment_aspects.id', '=', 'instrument_aspects.aspect_id')
            ->where('assessment_answers.assessment_id', $assessment->id)
            ->where('instrument_aspects.instrument_id', $instrument->id)
            ->select(
                'assessment_aspects.id as aspect_id',
                'instrument_aspects.weight',
                DB::raw('SUM(assessment_answers.score) as aspect_score')
            )
            ->groupBy('assessment_aspects.id', 'instrument_aspects.weight')
            ->get();

        $weightedTotal = 0;
        $totalWeight = 0;

        foreach ($aspectScores as $aspectScore) {
            $weightedTotal += $aspectScore->aspect_score * $aspectScore->weight;
            $totalWeight += $aspectScore->weight;
        }

        return $totalWeight > 0 ? $weightedTotal / $totalWeight : 0;
    }
}
```

```php
// app/Services/AnswerValidationService.php
<?php

namespace App\Services;

use App\Models\AssessmentAnswer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AnswerValidationService
{
    public function validateAnswer(AssessmentAnswer $answer): bool
    {
        $question = $answer->question;
        
        if (!$question) {
            throw new \Exception('Question not found for answer');
        }

        // Check required
        if ($question->is_required && $this->isEmpty($answer)) {
            throw ValidationException::withMessages([
                'answer' => 'This question requires an answer'
            ]);
        }

        // Validate by type
        switch ($question->answer_type) {
            case 'boolean':
                return $this->validateBoolean($answer);
            
            case 'scale':
            case 'number':
                return $this->validateNumeric($answer, $question);
            
            case 'percentage':
                return $this->validatePercentage($answer);
            
            case 'multiple_choice':
                return $this->validateMultipleChoice($answer, $question);
            
            case 'text':
                return $this->validateText($answer);
            
            case 'file':
                return $this->validateFile($answer);
            
            default:
                return true;
        }
    }

    protected function isEmpty(AssessmentAnswer $answer): bool
    {
        return empty($answer->answer_value) 
            && $answer->numeric_value === null 
            && $answer->boolean_value === null 
            && empty($answer->file_path);
    }

    protected function validateBoolean(AssessmentAnswer $answer): bool
    {
        return $answer->boolean_value !== null;
    }

    protected function validateNumeric(AssessmentAnswer $answer, $question): bool
    {
        if ($answer->numeric_value === null) return false;

        $value = $answer->numeric_value;
        
        if ($question->min_score !== null && $value < $question->min_score) {
            throw ValidationException::withMessages([
                'answer' => "Value must be at least {$question->min_score}"
            ]);
        }

        if ($question->max_score !== null && $value > $question->max_score) {
            throw ValidationException::withMessages([
                'answer' => "Value must not exceed {$question->max_score}"
            ]);
        }

        return true;
    }

    protected function validatePercentage(AssessmentAnswer $answer): bool
    {
        if ($answer->numeric_value === null) return false;

        $value = $answer->numeric_value;
        
        if ($value < 0 || $value > 100) {
            throw ValidationException::withMessages([
                'answer' => 'Percentage must be between 0 and 100'
            ]);
        }

        return true;
    }

    protected function validateMultipleChoice(AssessmentAnswer $answer, $question): bool
    {
        $options = $question->getEffectiveAnswerOptions();
        
        if (!$options) return true;

        $validValues = collect($options)->pluck('value')->toArray();
        
        if (!in_array($answer->answer_value, $validValues)) {
            throw ValidationException::withMessages([
                'answer' => 'Invalid answer option selected'
            ]);
        }

        return true;
    }

    protected function validateText(AssessmentAnswer $answer): bool
    {
        return !empty($answer->answer_value);
    }

    protected function validateFile(AssessmentAnswer $answer): bool
    {
        return !empty($answer->file_path) && file_exists(storage_path('app/' . $answer->file_path));
    }

    public function approveAnswer(AssessmentAnswer $answer, int $validatorId, ?string $notes = null): AssessmentAnswer
    {
        $answer->update([
            'validation_status' => 'validated',
            'validated_by' => $validatorId,
            'validated_at' => now(),
            'validation_notes' => $notes,
        ]);

        return $answer->fresh();
    }

    public function rejectAnswer(AssessmentAnswer $answer, int $validatorId, string $reason): AssessmentAnswer
    {
        $answer->update([
            'validation_status' => 'rejected',
            'validated_by' => $validatorId,
            'validated_at' => now(),
            'validation_notes' => $reason,
        ]);

        return $answer->fresh();
    }

    public function requestRevision(AssessmentAnswer $answer, int $validatorId, string $feedback): AssessmentAnswer
    {
        $answer->update([
            'validation_status' => 'needs_revision',
            'validated_by' => $validatorId,
            'validated_at' => now(),
            'validation_notes' => $feedback,
        ]);

        return $answer->fresh();
    }
}
```

---

## 📊 Compatibility Check

### Backward Compatibility Status

| Component | Status | Notes |
|---|---|---|
| Existing Data | ⚠️ **PARTIAL** | New columns nullable, but enum changes may break |
| API Endpoints | ⚠️ **NEEDS UPDATE** | New fields need to be added to responses |
| Frontend Forms | ❌ **NEEDS UPDATE** | New answer types require new UI components |
| Seeders | ⚠️ **NEEDS UPDATE** | Answer type enum mismatch |
| Reports | ❌ **NEEDS UPDATE** | New scoring fields change calculations |

---

## ✅ Testing Checklist

### Database Tests Required

```php
// tests/Feature/AssessmentEnhancementTest.php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentAnswer;
use App\Models\ScaleTemplate;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssessmentEnhancementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function assessment_can_calculate_total_score()
    {
        $assessment = Assessment::factory()->create();
        
        AssessmentAnswer::factory()->create([
            'assessment_id' => $assessment->id,
            'score' => 80.00,
        ]);
        
        AssessmentAnswer::factory()->create([
            'assessment_id' => $assessment->id,
            'score' => 90.00,
        ]);

        $this->assertEquals(170.00, $assessment->calculateTotalScore());
    }

    /** @test */
    public function question_can_use_scale_template()
    {
        $template = ScaleTemplate::factory()->create([
            'code' => 'LIKERT_5',
            'scale_options' => json_encode([
                ['value' => '1', 'label' => 'Sangat Tidak Setuju', 'score' => 20],
                ['value' => '5', 'label' => 'Sangat Setuju', 'score' => 100],
            ]),
        ]);

        $question = AssessmentQuestion::factory()->create([
            'scale_template_id' => $template->id,
            'answer_type' => 'scale',
        ]);

        $options = $question->getEffectiveAnswerOptions();
        
        $this->assertCount(2, $options);
        $this->assertEquals('Sangat Setuju', $options[1]['label']);
    }

    /** @test */
    public function answer_auto_calculates_score()
    {
        $question = AssessmentQuestion::factory()->create([
            'answer_type' => 'scale',
            'min_score' => 0,
            'max_score' => 100,
        ]);

        $answer = AssessmentAnswer::factory()->create([
            'question_id' => $question->id,
            'numeric_value' => 5,
        ]);

        $answer->calculateScore();

        $this->assertNotNull($answer->score);
    }

    /** @test */
    public function instrument_item_can_reference_master_question()
    {
        $question = AssessmentQuestion::factory()->create();
        
        $item = InstrumentItem::factory()->create([
            'assessment_question_id' => $question->id,
            'uses_master_question' => true,
        ]);

        $this->assertEquals($question->id, $item->getEffectiveQuestion()->id);
    }

    /** @test */
    public function assessment_tracks_completion_percentage()
    {
        $assessment = Assessment::factory()->create([
            'total_questions' => 10,
            'answered_questions' => 7,
        ]);

        $this->assertEquals(70.00, $assessment->calculateCompletionPercentage());
    }
}
```

---

## 🎯 Action Items

### Immediate (Must Do)

- [ ] **1. Fix answer type enum mismatch**
  - Create migration to update enum values
  - Update existing seeder data
  - Test with existing data

- [ ] **2. Update all Model classes**
  - Add new relationships
  - Add new fillable fields
  - Add new casts
  - Add helper methods

- [ ] **3. Create Service classes**
  - `AssessmentScoringService`
  - `AnswerValidationService`
  - `InstrumentBuilderService`

- [ ] **4. Run comprehensive tests**
  - Database migration tests
  - Model relationship tests
  - Scoring calculation tests
  - Validation tests

### Short-term (Should Do)

- [ ] **5. Update API controllers**
  - Add endpoints for new fields
  - Update validation rules
  - Add score calculation endpoints

- [ ] **6. Update Frontend components**
  - Create UI for new answer types
  - Add validation feedback
  - Add progress tracking

- [ ] **7. Create data migration scripts**
  - Migrate existing answers to new structure
  - Populate score fields for existing data

- [ ] **8. Write documentation**
  - API documentation
  - Developer guide
  - User guide

### Long-term (Nice to Have)

- [ ] **9. Implement reporting system**
  - Score analytics
  - Completion tracking
  - Comparison reports

- [ ] **10. Add export functionality**
  - PDF export
  - Excel export
  - CSV export

- [ ] **11. Create admin panel**
  - Instrument builder UI
  - Question library manager
  - Scale template manager

- [ ] **12. Performance optimization**
  - Add caching
  - Optimize queries
  - Add indexes

---

## 🔧 Quick Fixes Needed

### Fix #1: Answer Type Enum
```bash
php artisan make:migration fix_answer_type_enum_values
```

```php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Update assessment_questions
        DB::statement("ALTER TABLE assessment_questions MODIFY COLUMN answer_type ENUM('boolean', 'scale', 'number', 'text', 'multiple_choice', 'percentage', 'file', 'option') NOT NULL");
        
        // Migrate 'option' to 'multiple_choice'
        DB::table('assessment_questions')
            ->where('answer_type', 'option')
            ->update(['answer_type' => 'multiple_choice']);

        // Update instrument_items if it has answer_type
        if (Schema::hasColumn('instrument_items', 'answer_type')) {
            DB::statement("ALTER TABLE instrument_items MODIFY COLUMN answer_type ENUM('boolean', 'scale', 'number', 'text', 'multiple_choice', 'percentage', 'file', 'option')");
            
            DB::table('instrument_items')
                ->where('answer_type', 'option')
                ->update(['answer_type' => 'multiple_choice']);
        }
    }

    public function down()
    {
        DB::statement("ALTER TABLE assessment_questions MODIFY COLUMN answer_type ENUM('boolean', 'scale', 'number', 'text') NOT NULL");
        
        if (Schema::hasColumn('instrument_items', 'answer_type')) {
            DB::statement("ALTER TABLE instrument_items MODIFY COLUMN answer_type ENUM('boolean', 'scale', 'number', 'text')");
        }
    }
};
```

### Fix #2: Data Migration for Existing Answers
```bash
php artisan make:command MigrateExistingAnswers
```

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AssessmentAnswer;
use Illuminate\Support\Facades\DB;

class MigrateExistingAnswers extends Command
{
    protected $signature = 'answers:migrate';
    protected $description = 'Migrate existing answers to new structure';

    public function handle()
    {
        $this->info('Migrating existing answers...');

        DB::transaction(function () {
            AssessmentAnswer::with('question')
                ->whereNotNull('answer_value')
                ->whereNull('numeric_value')
                ->whereNull('boolean_value')
                ->chunk(100, function ($answers) {
                    foreach ($answers as $answer) {
                        $this->migrateAnswer($answer);
                    }
                });
        });

        $this->info('Migration completed!');
    }

    protected function migrateAnswer($answer)
    {
        $question = $answer->question;
        
        if (!$question) return;

        switch ($question->answer_type) {
            case 'boolean':
                $answer->boolean_value = filter_var($answer->answer_value, FILTER_VALIDATE_BOOLEAN);
                break;

            case 'scale':
            case 'number':
            case 'percentage':
                $answer->numeric_value = (float) $answer->answer_value;
                break;
        }

        // Calculate score
        $answer->calculateScore();
        $answer->save();

        $this->line("Migrated answer ID: {$answer->id}");
    }
}
```

---

## 📈 Conclusion

### Overall Status: ⚠️ **NEEDS ATTENTION**

**Summary:**
- ✅ Migrations are well-designed and comprehensive
- ✅ Schema enhancements cover all requirements
- ⚠️ Several compatibility issues need immediate attention
- ⚠️ Models and services need to be created/updated
- ❌ Testing framework needs to be implemented

**Risk Level:** MEDIUM
- No data loss risk (migrations use nullable columns)
- Some breaking changes in enum values
- Requires careful deployment