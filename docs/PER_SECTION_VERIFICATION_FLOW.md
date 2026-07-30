# Per-Section Verification & Validation Flow (V2 Submissions)

**Date:** July 29, 2026  
**Module:** V2 Instrument Submissions  
**Status:** Implemented & Verified  

---

## 🎯 Overview

The Per-Section Verification & Validation Flow enables Admins and Verifiers to review submission data granularly—section by section—and provide section-level status (`Sesuai` / `Revisi`) and specific notes. The feedback is stored persistently and rendered directly on the School submission detail page so schools know exactly which section requires revision and why.

---

## 💾 1. Database Schema Changes

### Migration
**File:** `database/migrations/2026_02_29_000000_add_section_notes_to_instrument_submissions_v2_table.php`

Added a nullable JSON column `section_notes` to `instrument_submissions_v2`:

```php
Schema::table('instrument_submissions_v2', function (Blueprint $table) {
    if (!Schema::hasColumn('instrument_submissions_v2', 'section_notes')) {
        $table->json('section_notes')->nullable()->after('answers');
    }
});
```

### JSON Data Structure
```json
{
  "A.1.1": {
    "status": "approved",
    "notes": "Data lulusan sudah lengkap dan sesuai.",
    "updated_at": "2026-07-29 15:10:00"
  },
  "A.1.2": {
    "status": "rejected",
    "notes": "Mohon perbaiki data jenjang KKNI pada skema sertifikasi.",
    "updated_at": "2026-07-29 15:10:00"
  }
}
```

---

## 🧩 2. Model Enhancements

**File:** `app/Models/InstrumentSubmissionV2.php`

- Added `section_notes` to `$fillable` and `$casts` as `'array'`.
- Added helper methods:
  - `getSectionStatus(string $sectionCode): ?string`
  - `getSectionNotes(string $sectionCode): ?string`
  - `setSectionReview(string $sectionCode, ?string $status, ?string $notesText): void`

---

## ⚙️ 3. Controller & Route Updates

### Controller
**File:** `app/Http/Controllers/Admin/SubmissionV2Controller.php`

- Updated `verify()`, `reject()`, and `validateSubmission()` to merge incoming `section_notes` payload.
- Added `saveSectionNotes(Request $request, InstrumentSubmissionV2 $submission)` to allow saving section notes at any time during review.

### Routes
**File:** `routes/web.php`

Added `section-notes` routes for both Verifier and Admin:
- `POST /verifier/submissions-v2/{submission}/section-notes` (`verifier.submissions-v2.section-notes`)
- `POST /admin/submissions-v2/{submission}/section-notes` (`admin.submissions-v2.section-notes`)

---

## 🎨 4. View Architecture & Component Integration

### Reusable Partial Component
**File:** `resources/views/admin/submissions-v2/partials/section-review-header.blade.php`

Provides:
1. **Status Badge**: Displays `Disetujui` (green badge) or `Perlu Perbaikan` (red badge) next to section titles.
2. **Alert Banner**: Renders alert box showing section-specific notes.
3. **Review Form Controls**: Shows status radio buttons (`Sesuai` / `Revisi`) and notes input field when `$canReview` is `true`.

### Updated Section Partials
- `resources/views/admin/submissions-v2/partials/section-table.blade.php`
- `resources/views/admin/submissions-v2/partials/section-tracer.blade.php`
- `resources/views/admin/submissions-v2/partials/section-a4.blade.php`
- `resources/views/admin/submissions-v2/partials/section-sapras.blade.php`

Each section partial includes `section-review-header.blade.php` dynamically.

### Updated Detail Views
1. **Admin Detail View**: `resources/views/admin/submissions-v2/show.blade.php`
   - Wrapped Review Jawaban in a section notes form with a **"Simpan Catatan Review"** button.
   - Fixed modal verification button for pending (`submitted`) submissions.
2. **Verifier Detail View**: `resources/views/verifier/submissions-v2/show.blade.php`
   - Configured with section notes review form and submit action.
3. **School Detail View**: `resources/views/school/submissions/show.blade.php`
   - Passes `'canReview' => false` to section partials, displaying section notes callouts and status badges without review inputs.

---

## 📋 5. Summary of Files Changed & Created

| Action | Path | Description |
|---|---|---|
| **CREATED** | `database/migrations/2026_02_29_000000_add_section_notes_to_instrument_submissions_v2_table.php` | Migration for `section_notes` column |
| **CREATED** | `resources/views/admin/submissions-v2/partials/section-review-header.blade.php` | Reusable section header with notes & controls |
| **CREATED** | `docs/PER_SECTION_VERIFICATION_FLOW.md` | Feature documentation |
| **MODIFIED** | `app/Models/InstrumentSubmissionV2.php` | Added fillable, casts, and helper methods |
| **MODIFIED** | `app/Http/Controllers/Admin/SubmissionV2Controller.php` | Updated controller methods to process section notes |
| **MODIFIED** | `routes/web.php` | Added section-notes routes for admin and verifier |
| **MODIFIED** | `resources/views/admin/submissions-v2/index.blade.php` | Fixed modal button target for pending entries & added validate option |
| **MODIFIED** | `resources/views/admin/submissions-v2/show.blade.php` | Form wrapper for section reviews |
| **MODIFIED** | `resources/views/verifier/submissions-v2/show.blade.php` | Form wrapper for section reviews |
| **MODIFIED** | `resources/views/school/submissions/show.blade.php` | Displays section feedback callouts to school users |
| **MODIFIED** | `resources/views/admin/submissions-v2/partials/section-table.blade.php` | Integrated review header partial |
| **MODIFIED** | `resources/views/admin/submissions-v2/partials/section-tracer.blade.php` | Integrated review header partial |
| **MODIFIED** | `resources/views/admin/submissions-v2/partials/section-a4.blade.php` | Integrated review header partial |
| **MODIFIED** | `resources/views/admin/submissions-v2/partials/section-sapras.blade.php` | Integrated review header partial |
