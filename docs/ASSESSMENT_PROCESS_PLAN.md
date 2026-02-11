# Assessment Process — Development Plan

> **Date**: February 11, 2026  
> **Scope**: Fix, simplify, and make the Assessment module fully functional  
> **Goal**: A working end-to-end assessment process: create assessment → fill answers → calculate scores → verify → approve → view results

---

## Table of Contents

1. [Current State Audit](#1-current-state-audit)
2. [Architecture Decision — Unify or Keep Separate](#2-architecture-decision--unify-or-keep-separate)
3. [Phase 1 — Fix Critical Bugs](#3-phase-1--fix-critical-bugs)
4. [Phase 2 — Simplify Assessment CRUD](#4-phase-2--simplify-assessment-crud)
5. [Phase 3 — Answer Entry Flow](#5-phase-3--answer-entry-flow)
6. [Phase 4 — Scoring & Results](#6-phase-4--scoring--results)
7. [Phase 5 — Workflow (Submit → Verify → Approve)](#7-phase-5--workflow-submit--verify--approve)
8. [Phase 6 — Reporting & Analytics](#8-phase-6--reporting--analytics)
9. [Phase 7 — UI/UX Polish](#9-phase-7--uiux-polish)
10. [File Changes Overview](#10-file-changes-overview)
11. [Implementation Order](#11-implementation-order)

---

## 1. Current State Audit

### Two Separate Systems Exist

The project has **two parallel systems** for recording school data:

| | Submission System | Assessment System |
|--|-------------------|-------------------|
| **Who uses it** | Public respondent (no auth) | Admin (authenticated) |
| **Entry** | Public form at `/instrumen` | Admin panel at `/admin/assessments` |
| **Models** | `Submission` → `Response` | `Assessment` → `AssessmentAnswer` |
| **Status flow** | submitted → verified → validated → released | draft → submitted → verified → approved |
| **Scoring** | `AnswerScoringService` | `ScoreCalculationService` |
| **Status** | ✅ Working | ❌ Mostly broken |

### Assessment System — What's Broken

| # | Bug | Severity | Location |
|---|-----|----------|----------|
| 1 | **Controller references non-existent columns**: `assessment_code`, `assessor_id`, `assessment_date`, `assessment_year`, `assessment_period` — none exist in model `$fillable` or migrations | 🔴 Critical | `AssessmentController` |
| 2 | **`assessor` relationship** eagerly loaded but doesn't exist on `Assessment` model | 🔴 Critical | `AssessmentController::index()` |
| 3 | **`AssessmentAnswerController` calls `validateAnswer()` with wrong parameters**: passes `($question, $value, $text)` but service expects `(array $data, $question)` | 🔴 Critical | `AssessmentAnswerController` |
| 4 | **`AssessmentAnswerController` references non-existent columns**: `instrument_item_id`, `assessment_question_id` on `AssessmentAnswer` | 🔴 Critical | `AssessmentAnswerController` |
| 5 | **`ScoreCalculationService::calculateScoreByAspect()`** uses `$aspect->aspect_name` but model has `name` | 🟡 Medium | `ScoreCalculationService` |
| 6 | **`ScoreCalculationService::calculateAndStoreScores()`** updates `max_score` column but model has `max_possible_score` | 🟡 Medium | `ScoreCalculationService` |
| 7 | **Sidebar link is HIDDEN** — "Penilaian" menu item is commented out (TEMPORARILY HIDDEN) | 🟡 Medium | `layouts/admin.blade.php` |
| 8 | **JS bug in `answer.blade.php`**: uses `this.type` inside `forEach` callback instead of `input.type` | 🟡 Medium | `answer.blade.php` |
| 9 | **Broken HTML in `show.blade.php`**: duplicate form tag missing `>` | 🟡 Medium | `show.blade.php` |
| 10 | **`AssessmentWorkflowService` is unused** — exists with full workflow but controller doesn't call it | 🟠 Tech Debt | Dead code |

### Assessment System — What's Working (Partially)
- ✅ Model relationships (school, instrument, answers)
- ✅ Assessment CRUD views exist (index, create, edit, show, answer)
- ✅ Score + grade calculation logic exists
- ✅ Aspect-level scoring logic exists
- ✅ Export to Excel exists (`AssessmentExport`)
- ✅ Activity logging is thorough
- ✅ Answer auto-save JS in answer.blade.php (concept)

---

## 2. Architecture Decision — Unify or Keep Separate

### Recommendation: Keep Separate, Fix Assessment

**Why not merge**: The Submission system (public form → verifier → admin) serves a different purpose than the Assessment system (admin-driven evaluation). They have different users, workflows, and entry points.

**Plan**: Fix the Assessment system to be fully functional as a **separate admin-driven** assessment tool, while keeping the Submission system for public data collection.

### Simplified Assessment Flow for This Project

Since this is a simple government school quality recording project, simplify the assessment flow to:

```
Admin creates Assessment for a School
  → Admin fills in answers (per aspect/indicator/question)
    → System auto-calculates scores
      → Admin submits → gets results (scores, grade)
        → Optional: approval workflow
```

Remove unnecessary complexity:
- ❌ Remove `assessment_code` (auto-generate or use ID)
- ❌ Remove `assessor_id` (use `created_by` — the admin who creates it)
- ❌ Remove configurable `assessment_period` (use simple dropdown: Semester 1/2, or year)
- ❌ Remove `duration_minutes` tracking (not needed)
- ❌ Remove `metadata` JSON field (not used)

---

## 3. Phase 1 — Fix Critical Bugs

> **Priority**: Must do first — system literally doesn't work without these fixes

### 3.1 Fix AssessmentController Column References
Replace non-existent column names with actual model fields:

```php
// Before (broken)
'assessment_code' => '...',
'assessor_id' => '...',
'assessment_date' => '...',
'assessment_year' => '...',
'assessment_period' => '...',

// After (fixed)
'school_id' => $request->school_id,
'instrument_id' => $request->instrument_id,
'respondent_name' => $request->respondent_name,
'respondent_position' => $request->respondent_position,
'filled_at' => $request->filled_at,
'period_year' => $request->period_year,
'semester' => $request->semester,
'assessment_type' => $request->assessment_type,
'status' => 'draft',
```

**Files**: `AssessmentController.php`

### 3.2 Fix Assessment Model — Add Missing Relationship
```php
// Assessment.php — add creator relationship (assessor = creator)
public function creator(): BelongsTo
{
    return $this->belongsTo(User::class, 'created_by');
}
```
Remove or alias `assessor` eager loading to use `creator`.

**Files**: `Assessment.php`, `AssessmentController.php`

### 3.3 Fix AssessmentAnswerController Parameter Mismatch
Fix the `validateAnswer()` call to match service signature:
```php
// Before (broken)
$validation = $validationService->validateAnswer($question, $answerValue, $answerText);

// After (fixed)
$validation = $validationService->validateAnswer([
    'answer_value' => $answerValue,
    'answer_text' => $answerText,
], $question);
```

**Files**: `AssessmentAnswerController.php`

### 3.4 Fix AssessmentAnswerController Column References
Replace `instrument_item_id` and `assessment_question_id` with actual columns:
```php
// AssessmentAnswer uses: assessment_id, question_id
AssessmentAnswer::updateOrCreate(
    ['assessment_id' => $assessment->id, 'question_id' => $question->id],
    ['answer_value' => $value, 'score' => $score]
);
```

**Files**: `AssessmentAnswerController.php`

### 3.5 Fix ScoreCalculationService Column Mismatches
```php
// Fix aspect_name → name
$aspect->name  // not $aspect->aspect_name

// Fix max_score → max_possible_score
$assessment->update(['max_possible_score' => $maxScore]);  // not 'max_score'
```

**Files**: `ScoreCalculationService.php`

### 3.6 Fix JS Bug in answer.blade.php
```javascript
// Before (broken)
inputs.forEach(function(input) {
    if (this.type === 'text' || this.type === 'number') {
    
// After (fixed)
inputs.forEach(function(input) {
    if (input.type === 'text' || input.type === 'number') {
```

**Files**: `resources/views/admin/assessments/answer.blade.php`

### 3.7 Fix Broken HTML in show.blade.php
Find and fix the malformed form tag (missing `>`).

**Files**: `resources/views/admin/assessments/show.blade.php`

### 3.8 Unhide Sidebar Link
Uncomment the "Penilaian" sidebar navigation item.

**Files**: `resources/views/layouts/admin.blade.php`

**Estimated effort**: ~1-2 days

---

## 4. Phase 2 — Simplify Assessment CRUD

### 4.1 Simplify Create Form
Reduce the create form to essential fields only:

```
┌──────────────────────────────────────┐
│ Buat Penilaian Baru                  │
├──────────────────────────────────────┤
│ Sekolah:        [Select school ▼]    │
│ Instrumen:      [Select instrument ▼]│
│ Tahun:          [2026]               │
│ Semester:       [Semester 1 ▼]       │
│ Responden:      [Nama responden]     │
│ Jabatan:        [Jabatan responden]  │
│                                      │
│              [Buat & Isi Jawaban]     │
└──────────────────────────────────────┘
```

Remove: `assessment_code` (auto-generated), `assessor` selector (use logged-in user), complex period options.

**Files**: `create.blade.php`, `AssessmentController@store`

### 4.2 Simplify Index Page
Show a clean table:

| Sekolah | Instrumen | Tahun | Semester | Status | Skor | Aksi |
|---------|-----------|-------|----------|--------|------|------|
| SMK N 1 | KPTK | 2026 | 1 | Draft | - | Isi / Edit / Hapus |

Add simple filters: status dropdown, year dropdown, school search.
Remove: bulk actions, export button (can add back later).

**Files**: `index.blade.php`, `AssessmentController@index`

### 4.3 Streamline Show Page
Simplify to:
- **Info card**: School, instrument, respondent, period
- **Score card**: Total score, percentage, grade (only shown if submitted)
- **Action buttons**: Fill Answers / Submit / Edit / Delete
- **Aspect scores**: Simple bar chart or progress bars per aspect
- Remove: complex timeline, verification actions (move to Phase 5)

**Files**: `show.blade.php`

### 4.4 Clean Up Dead Code
- Delete `InstrumentManagementService.php` (duplicated in controller, never used)
- Remove `AssessmentWorkflowService.php` if not adopting it (or adopt it → see Phase 5)
- Remove orphaned instrument view partials (`filters.blade.php`, `question-selector.blade.php`, `questions-manager.blade.php`, `status-badge.blade.php`)

**Estimated effort**: ~2-3 days

---

## 5. Phase 3 — Answer Entry Flow

The core experience: admin fills in answers for an assessment.

### 5.1 Answer Page Redesign
The current `answer.blade.php` groups questions by aspect with AJAX auto-save. Keep this approach but improve:

**Layout**:
```
┌─ Sidebar (Sticky) ──────┐  ┌─ Main Content ──────────────────────────┐
│                          │  │                                         │
│ Progress: 72% ████░░░    │  │  Aspek 1: Kurikulum                    │
│                          │  │  ┌─────────────────────────────────────┐│
│ • Aspek 1 ✅ (5/5)       │  │  │ 1.1 Indikator Kurikulum            ││
│ • Aspek 2 ⏳ (3/8)       │  │  │                                     ││
│ • Aspek 3 ⬜ (0/4)       │  │  │ Q: Sekolah memiliki kurikulum...?  ││
│ • Aspek 4 ⬜ (0/6)       │  │  │ [Ya] [Tidak]                       ││
│                          │  │  │                                     ││
│ ──────────────────────── │  │  │ Q: Tingkat kesesuaian kurikulum?   ││
│ [Simpan Semua]           │  │  │ [1] [2] [3] [4] [5]               ││
│ [Submit Penilaian]       │  │  │                                     ││
│                          │  │  │ ✅ Tersimpan                        ││
└──────────────────────────┘  └──┴─────────────────────────────────────┘│
```

### 5.2 Auto-Save Behavior
- Save each answer individually via AJAX when the input changes (debounced 1s)
- Show inline "✅ Tersimpan" indicator next to each saved answer
- Show "⏳ Menyimpan..." during save
- Show "❌ Gagal, coba lagi" on error with retry button
- No need for a "Simpan Semua" button if auto-save works, but keep as fallback

### 5.3 Answer Input Components
Reuse the improved `answer-input` partial (from Form Enhancement Plan) with these types:
- **Boolean**: Ya/Tidak toggle buttons
- **Scale**: Pill-style radio buttons with labels
- **Number**: Number input with range info
- **Percentage**: Number input with `%` suffix and 0-100 constraint
- **Text**: Auto-resize textarea
- **Multiple Choice**: Dropdown or radio group
- **Structure/Table**: Editable table (same as public form)

### 5.4 API Endpoint Fix
Fix `AssessmentAnswerController` to properly:
1. Validate answer value against question type
2. Calculate score using `AnswerValidationService`
3. Store via `AssessmentAnswer::updateOrCreate`
4. Return JSON response with saved answer + score

```php
// POST /admin/assessments/{assessment}/answers
public function store(Request $request, Assessment $assessment)
{
    $question = AssessmentQuestion::findOrFail($request->question_id);
    
    $score = $this->scoringService->calculateScore($question, $request->answer_value);
    
    $answer = AssessmentAnswer::updateOrCreate(
        ['assessment_id' => $assessment->id, 'question_id' => $question->id],
        [
            'answer_value' => $request->answer_value,
            'score' => $score,
            'answered_at' => now(),
        ]
    );
    
    return response()->json([
        'success' => true,
        'answer' => $answer,
        'progress' => $assessment->fresh()->completion_percentage,
    ]);
}
```

### 5.5 Progress Tracking
After each answer save, update the assessment's progress:
- `answered_questions` count
- `completion_percentage`
- Update the sidebar progress in real-time via the AJAX response

**Estimated effort**: ~3-4 days

---

## 6. Phase 4 — Scoring & Results

### 6.1 Fix ScoreCalculationService
Fix all column name mismatches (see Phase 1) and ensure:
- Total score = sum of all answer scores
- Max possible score = sum of (question.max_score × question.weight) for all linked questions
- Percentage = (total / max) × 100
- Grade = A/B/C/D/E based on percentage thresholds

### 6.2 Score Results Page
After assessment is submitted, show a **results view**:

```
┌───────────────────────────────────────────┐
│ Hasil Penilaian                           │
│                                           │
│ Sekolah: SMK Negeri 1 Bandung             │
│ Instrumen: KPTK 2024                      │
│                                           │
│ ┌──────────────────┐                      │
│ │   NILAI: 78.5%   │                      │
│ │   GRADE: B       │                      │
│ └──────────────────┘                      │
│                                           │
│ Skor per Aspek:                           │
│ Kurikulum        ████████████░░░ 85%      │
│ Proses Pembelajaran ██████████░░░░ 72%    │
│ Kompetensi Guru  █████████████░░ 90%      │
│ Sarana Prasarana  ███████░░░░░░░░ 52%      │
│                                           │
│ [Lihat Detail] [Export PDF] [Kembali]     │
└───────────────────────────────────────────┘
```

### 6.3 Aspect-Level Score Breakdown
For each aspect, show:
- Aspect name and score percentage
- Progress bar with color coding (green ≥80%, yellow ≥60%, red <60%)
- Expandable detail showing individual indicator/question scores

### 6.4 Recalculate Scores Button
Keep the existing "Recalculate" action but ensure it:
- Recalculates every answer score
- Updates totals
- Updates grade
- Shows before/after comparison

**Estimated effort**: ~2-3 days

---

## 7. Phase 5 — Workflow (Submit → Verify → Approve)

### 7.1 Simplified Workflow
For this government project, simplify to:

```
Draft  →  Submitted  →  Approved
                ↓
             Rejected (back to Draft for revision)
```

Remove "Verified" step — it's redundant when admin both creates and reviews. If needed later, re-add.

### 7.2 Submit Action
When admin clicks "Submit":
- Validate all questions are answered (or at least required ones)
- Calculate final scores
- Change status to `submitted`
- Show confirmation modal first

### 7.3 Approval Action
A senior admin or different admin can:
- Review the assessment (read-only answer view)
- Approve → status = `approved`, saves `approved_by`, `approved_at`
- Reject → status back to `draft`, saves rejection notes
- Optional: require written notes for approval/rejection

### 7.4 Status Display
On the assessment show page, show current status with a simple badge:
- 🟡 Draft — "Belum dikirim"
- 🔵 Submitted — "Menunggu persetujuan"
- 🟢 Approved — "Disetujui"
- 🔴 Rejected — "Ditolak — [alasan]"

### 7.5 Decision: Use AssessmentWorkflowService?
The existing `AssessmentWorkflowService` has all this logic but is **never called**. Options:
- **Option A**: Wire up the controller to use the service (cleaner, service already tested)
- **Option B**: Keep logic in controller directly (simpler, less indirection)

**Recommendation**: Option A — adopt the service. It handles transactions, activity logging, and score calculation in the right order.

**Estimated effort**: ~2-3 days

---

## 8. Phase 6 — Reporting & Analytics

### 8.1 Include Assessments in Analytics
Currently, `AnalyticsController` only queries `Submission::released()`. Add assessment data:
- Show **both** submission-based and assessment-based data in analytics
- Or create a separate "Assessment Analytics" page

### 8.2 Simple Reports
Leverage the existing `ReportingService` (which already has methods):
- **School report**: All assessments for a school with scores over time
- **Instrument report**: All schools' scores for an instrument
- **Trend report**: Year-over-year comparison

### 8.3 Export
- Export individual assessment to PDF (printable report card)
- Export assessment list to Excel (use existing `AssessmentExport`)

**Estimated effort**: ~2-3 days

---

## 9. Phase 7 — UI/UX Polish

### 9.1 Assessment Index Page
- Color-coded status badges
- Clickable row to view details
- Quick actions on hover (edit, delete, submit)
- Empty state when no assessments

### 9.2 Answer Page UX
- Smooth scrolling between aspects
- Highlight current question
- Keyboard navigation between questions (Tab)
- Show skipped/unanswered questions clearly
- Mobile-friendly answer inputs

### 9.3 Results Page
- Print-friendly layout with `@media print`
- Color-coded aspect bars
- School header with logo placeholder
- Date and assessor info in footer

### 9.4 Loading States
- Skeleton loading for answer page
- Spinner on all buttons during AJAX
- Disabled state on submit until 100% completion

**Estimated effort**: ~2-3 days

---

## 10. File Changes Overview

### Must Fix (Phase 1)
| File | Change |
|------|--------|
| `app/Http/Controllers/Admin/AssessmentController.php` | Fix column references, relationship naming, filter logic |
| `app/Http/Controllers/Admin/AssessmentAnswerController.php` | Fix parameter order, column names, API response |
| `app/Services/ScoreCalculationService.php` | Fix `aspect_name` → `name`, `max_score` → `max_possible_score` |
| `app/Models/Assessment.php` | Add `creator` relationship, verify `$fillable` matches actual columns |
| `resources/views/admin/assessments/answer.blade.php` | Fix JS `this` → `input` bug |
| `resources/views/admin/assessments/show.blade.php` | Fix malformed HTML form tag |
| `resources/views/layouts/admin.blade.php` | Uncomment Penilaian sidebar link |

### Simplify (Phase 2)
| File | Change |
|------|--------|
| `resources/views/admin/assessments/create.blade.php` | Simplify to essential fields only |
| `resources/views/admin/assessments/index.blade.php` | Clean table with simple filters |
| `resources/views/admin/assessments/show.blade.php` | Streamline to info + scores + actions |

### Answer Flow (Phase 3)
| File | Change |
|------|--------|
| `resources/views/admin/assessments/answer.blade.php` | Redesign with sidebar progress, proper auto-save |
| `app/Http/Controllers/Admin/AssessmentAnswerController.php` | Fix AJAX endpoints |
| `app/Services/AnswerValidationService.php` | Ensure scoring works for all answer types |

### Results & Workflow (Phase 4-5)
| File | Change |
|------|--------|
| `resources/views/admin/assessments/show.blade.php` | Add results view with score bars |
| `app/Http/Controllers/Admin/AssessmentController.php` | Wire up workflow service |
| `app/Services/AssessmentWorkflowService.php` | Adopt and fix if needed |

### Clean Up
| File | Action |
|------|--------|
| `app/Services/InstrumentManagementService.php` | **DELETE** — dead code |
| `resources/views/admin/instruments/partials/filters.blade.php` | **DELETE** — orphaned |
| `resources/views/admin/instruments/partials/question-selector.blade.php` | **DELETE** — orphaned |
| `resources/views/admin/instruments/partials/questions-manager.blade.php` | **DELETE** — orphaned |
| `resources/views/admin/instruments/partials/status-badge.blade.php` | **DELETE** — orphaned |

---

## 11. Implementation Order

### Priority Order (What to Do First)

```
Phase 1 — Fix Bugs              ██████████  ~1-2 days  ⚡ MUST DO FIRST
├─ Fix controller columns        │ System literally broken without this
├─ Fix service mismatches         │ 
├─ Fix JS bug                    │
├─ Unhide sidebar link           │
└─ Fix HTML                      │

Phase 2 — Simplify CRUD         ██████████  ~2-3 days
├─ Simplify create form          │ Remove unnecessary fields
├─ Clean up index page           │
├─ Streamline show page          │
└─ Delete dead code              │

Phase 3 — Answer Entry          ██████████  ~3-4 days ⭐ CORE FEATURE
├─ Fix API endpoints             │
├─ Redesign answer page          │
├─ Auto-save per question        │
└─ Progress tracking             │

Phase 4 — Scoring & Results     ██████████  ~2-3 days
├─ Fix score calculation         │
├─ Results view with bars        │
├─ Aspect breakdown              │
└─ Recalculate action            │

Phase 5 — Workflow              ██████████  ~2-3 days
├─ Submit with validation        │
├─ Approve / Reject              │
├─ Status display                │
└─ Wire up workflow service      │

Phase 6 — Analytics             ██████████  ~2-3 days
├─ Include in analytics          │
├─ School/instrument reports     │
└─ PDF/Excel export              │

Phase 7 — UI/UX Polish          ██████████  ~2-3 days
├─ Index page polish             │
├─ Answer page UX                │
├─ Results page print            │
└─ Loading states                │
```

**Estimated Total**: ~15-21 days

### Critical Path
```
Phase 1 (bugs) → Phase 3 (answers) → Phase 4 (scoring) → Phase 5 (workflow)
```

This is the minimum viable path to a **working** assessment system. Phases 2, 6, 7 can be done in parallel or after.

### Definition of Done
The assessment system is "done" when:
1. ✅ Admin can create an assessment for a school + instrument
2. ✅ Admin can fill in all answers with auto-save
3. ✅ System calculates scores correctly (total, per-aspect, grade)
4. ✅ Admin can submit the assessment
5. ✅ Results page shows scores with visual breakdown
6. ✅ No console errors, no 500 errors, no broken UI
