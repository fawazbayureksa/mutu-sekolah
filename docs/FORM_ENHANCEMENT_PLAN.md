# Form (Public Instrument) — Enhancement Plan

> **Date**: February 11, 2026  
> **Scope**: UI/UX improvements for the public-facing instrument form at `/instrumen`  
> **Goal**: Make form filling easier, more reliable, and user-friendly for school respondents

---

## Table of Contents

1. [Current State](#1-current-state)
2. [Critical Issues](#2-critical-issues)
3. [Phase 1 — Multi-Step Wizard](#3-phase-1--multi-step-wizard)
4. [Phase 2 — Auto-Save & Draft](#4-phase-2--auto-save--draft)
5. [Phase 3 — Answer Input Improvements](#5-phase-3--answer-input-improvements)
6. [Phase 4 — Form Validation & Feedback](#6-phase-4--form-validation--feedback)
7. [Phase 5 — Visual Polish](#7-phase-5--visual-polish)
8. [File Changes](#8-file-changes)
9. [Implementation Order](#9-implementation-order)

---

## 1. Current State

### How It Works Now
- User visits `/instrumen` (no authentication required)
- **One single long page** with ALL sections: school identity, respondent info, and every question grouped by aspect → indicator
- User fills everything at once and clicks "Kirim Data Instrumen"
- JS confirmation dialog → POST → redirect to landing page with success flash
- **No save/draft** — browser close = all data lost

### What Exists
| Component | Status |
|-----------|--------|
| School identity fields (name, NPSN, address) | ✅ Working |
| Respondent fields (name, position) | ✅ Working |
| Hierarchical question display (aspect → indicator → question) | ✅ Working |
| Answer types: boolean, scale, number, percentage, text, structure/table | ✅ Working |
| Legacy flat display (fallback) | ✅ Working but deprecated |
| Confirm dialog before submit | ✅ Working |
| Table/structure inputs with calculated columns | ✅ Working |

### Known Issues
| # | Problem | Impact |
|---|---------|--------|
| 1 | All questions on one page — very long scroll | High — respondents lose their place |
| 2 | No save/draft — data lost if browser closes | High — frustrating for users |
| 3 | No progress indicator — user never knows how far along | Medium |
| 4 | No client-side validation feedback until submit | Medium |
| 5 | Navbar links point to landing page anchors (broken on form page) | Low |
| 6 | `components/answer-input.blade.php` exists but is NOT used (duplicate code) | Tech debt |
| 7 | Table JS uses `Function()` eval — potential XSS | Security |
| 8 | No mobile optimization | Medium |

---

## 2. Critical Issues

### 2.1 Duplicate Answer Input Components
Two files render answer inputs:
- `resources/views/instrument/partials/answer-input.blade.php` — **used by the form**
- `resources/views/components/answer-input.blade.php` — **NOT used** (supports file uploads but form doesn't)

**Action**: Consolidate into ONE component. Keep the partials version (it handles `structure` type). Remove the unused component or merge file upload support into the partial.

### 2.2 Legacy Flat Display Code
Lines ~299-362 of `form.blade.php` contain a legacy rendering path with hardcoded options (`Sangat Baik`, `Baik`, etc.) that bypasses the answer-input partial.

**Action**: Remove the legacy path. All instruments should use hierarchical display with the shared partial.

### 2.3 Security — `evaluateExpression()`
The `Function()` constructor is used for evaluating calculated table columns. While inputs are partially sanitized, this is risky.

**Action**: Replace with a safe math parser (simple arithmetic only: `+`, `-`, `*`, `/`) instead of `Function()`.

---

## 3. Phase 1 — Multi-Step Wizard

Convert the single long form into a **step wizard** with clear progress.

### 3.1 Steps Structure
```
Step 1: Identitas Sekolah (school name, NPSN, address)
Step 2: Data Responden (name, position)
Step 3+: One step per Aspect (e.g., "Aspek 1 - Kurikulum", "Aspek 2 - Proses Pembelajaran")
Final: Review & Submit
```

### 3.2 Progress Bar
A horizontal stepper at the top showing:
- Step numbers/names
- Current step highlighted
- Completed steps with checkmark
- Percentage complete text (e.g., "Langkah 3 dari 7 — 43%")

```html
<div class="form-stepper">
    <div class="stepper-item completed">
        <div class="step-number"><i class="bi bi-check-lg"></i></div>
        <span>Identitas</span>
    </div>
    <div class="stepper-item active">
        <div class="step-number">2</div>
        <span>Responden</span>
    </div>
    <div class="stepper-item">
        <div class="step-number">3</div>
        <span>Aspek 1</span>
    </div>
    <!-- ... -->
</div>
```

### 3.3 Navigation
- **Next / Previous** buttons at the bottom of each step
- Next button validates current step before proceeding
- Back button always available (no data loss)
- Steps also clickable in the progress bar (only completed + next step)
- Keyboard: `Enter` to next step (except on textareas)

### 3.4 Implementation Approach
Use client-side step switching (hide/show `<div>` sections) — NOT separate page loads. This keeps all data in the form and avoids needing backend draft saving for step navigation.

**Files to change**: `form.blade.php` (restructure HTML into step divs + add stepper JS)

---

## 4. Phase 2 — Auto-Save & Draft

### 4.1 `localStorage` Auto-Save
- Save form state to `localStorage` every 30 seconds and on every input change (debounced)
- On page load, check for saved data and offer to restore:
  ```
  "Kami menemukan data yang belum dikirim dari sesi sebelumnya. Muat kembali?"
  [Ya, Muat Data] [Tidak, Mulai Baru]
  ```
- Clear saved data after successful submission
- Key format: `instrument_form_{instrument_id}`

### 4.2 Visual Save Indicator
Show a small indicator near the top:
```
💾 Tersimpan otomatis pada 14:32
```
Updates every time auto-save triggers.

### 4.3 Server-Side Draft (Optional — Future)
If needed later, add a `POST /instrumen/draft` endpoint that saves a `Submission` with status `draft`. But for simplicity, `localStorage` is sufficient for this project.

**Files to change**: `form.blade.php` (add JS for localStorage save/restore)

---

## 5. Phase 3 — Answer Input Improvements

### 5.1 Boolean (Ya/Tidak)
**Current**: Bootstrap button group — works fine.
**Improve**: Add subtle color feedback — green background for "Ya", soft red for "Tidak" when selected.

### 5.2 Scale (Radio Options)
**Current**: Pill-style radio buttons.
**Improve**:
- Show current selection with a check icon
- Add tooltip on hover showing the label text for scales with numeric values
- Larger touch targets for mobile (min 44px height)

### 5.3 Number & Percentage
**Current**: Plain `<input type="number">`.
**Improve**:
- Show input range info below the field ("Rentang: 0 - 100")
- Add `+` / `-` stepper buttons for easier mobile input
- Real-time validation (red border immediately if out of range)

### 5.4 Text
**Current**: Plain `<textarea>`.
**Improve**:
- Auto-resize textarea as user types
- Character count indicator (if there's a max length)

### 5.5 Structure/Table
**Current**: Editable table with calculated columns and hidden JSON.
**Improve**:
- Better mobile layout — stack columns vertically on small screens
- Clearer "calculated" column indicator (gray background + "otomatis" label)
- Input validation per cell (show red border for invalid numbers)
- Replace `Function()` eval with safe math parser

### 5.6 Consolidate Components
Merge `components/answer-input.blade.php` features (file upload) into `partials/answer-input.blade.php`, then delete the component. One source of truth.

**Files to change**: `partials/answer-input.blade.php`, `form.blade.php` (CSS), delete `components/answer-input.blade.php`

---

## 6. Phase 4 — Form Validation & Feedback

### 6.1 Per-Step Validation
Before moving to the next step:
- Check all required fields are filled
- Check numeric fields are within range
- Highlight invalid fields with red border + error message
- Scroll to the first error

### 6.2 Required Field Indicators
- Add red asterisk `*` next to required field labels (already present for school fields, add for all questions)
- Show "Wajib diisi" text on required questions

### 6.3 Unanswered Question Highlight
In the review step (or any step), show:
- Count of unanswered required questions per aspect
- Red dot on the step indicator if that step has unanswered questions
- List of unanswered questions with jump links

### 6.4 Submit Button State
- Disable submit button until all required fields are filled
- Show completion count: "42 dari 45 pertanyaan terisi"
- Loading state after click (spinner + "Mengirim...")

### 6.5 Success & Error Pages
- **Success**: Show a clean confirmation page with submission summary (school name, respondent, timestamp) instead of just a flash message on the landing page
- **Error**: Show inline errors with "Kembali ke pertanyaan" links

**Files to change**: `form.blade.php` (JS validation), possibly new `instrument/success.blade.php`

---

## 7. Phase 5 — Visual Polish

### 7.1 Responsive Design
- Stack form sections vertically on mobile
- Full-width buttons on mobile
- Horizontal scroll indicator for structure tables
- Stepper becomes vertical or accordion on mobile

### 7.2 Section Cards
Clean card styling per section:
- White card with subtle shadow
- Section header with icon and aspect name
- Numbered questions with clear spacing
- Help text styled as a tooltip or collapsible

### 7.3 Typography & Spacing
- Consistent font sizes: labels 0.9rem, inputs 1rem, help text 0.8rem
- Adequate spacing between questions (at least 1.5rem)
- Subtle separator lines between questions

### 7.4 Loading State
- Show skeleton animation while form data loads (if slow)
- Spinner on submit button during POST

### 7.5 Navbar Fix
When on the form page, either:
- Hide the landing page navbar, OR
- Replace anchor links with actual page links (e.g., link to `/` with anchors)

**Files to change**: `form.blade.php` (CSS + HTML), `layouts/app.blade.php` (navbar conditional)

---

## 8. File Changes

| File | Changes |
|------|---------|
| `resources/views/instrument/form.blade.php` | Restructure into multi-step wizard, add stepper UI, add localStorage auto-save, JS validation, responsive CSS, remove legacy flat display |
| `resources/views/instrument/partials/answer-input.blade.php` | Merge file upload support, improve boolean/scale/number styling, fix structure table mobile, replace `Function()` eval |
| `resources/views/components/answer-input.blade.php` | **DELETE** — merge into partial |
| `resources/views/instrument/success.blade.php` | **NEW** — success confirmation page |
| `resources/views/layouts/app.blade.php` | Fix navbar for form page context |
| `app/Http/Controllers/PublicInstrumentController.php` | Add success page route/return |
| `public/assets/css/custom.css` | Responsive form styles |

---

## 9. Implementation Order

### Quick Wins (Ship First — ~4 hours)
| # | Item | Effort |
|---|------|--------|
| 1 | Fix navbar links on form page | 15 min |
| 2 | Add red asterisk to required questions | 15 min |
| 3 | Disable submit button during POST (prevent double-click) | 20 min |
| 4 | Remove legacy flat display code path | 30 min |
| 5 | Auto-resize textareas | 15 min |
| 6 | Add completion count near submit button | 30 min |
| 7 | Replace `Function()` eval with safe math | 1 hr |
| 8 | Delete unused `components/answer-input.blade.php` | 15 min |

### Phase Implementation
```
Phase 1 — Multi-Step Wizard        ████████  ~3-4 days
├─ Restructure HTML into steps     │ Core change
├─ Build stepper UI component      │ CSS + HTML
├─ Step navigation JS              │ Show/hide + state
└─ Per-step validation             │ JS

Phase 2 — Auto-Save & Draft       ████████  ~1-2 days
├─ localStorage save/restore       │ JS
├─ Restore prompt UI               │ HTML + JS
└─ Save indicator                  │ CSS + JS

Phase 3 — Answer Input Improve    ████████  ~2-3 days
├─ Boolean color feedback          │ CSS
├─ Scale selection UI              │ CSS + JS
├─ Number range info + steppers    │ HTML + JS
├─ Structure table mobile          │ CSS
└─ Consolidate components          │ Refactor

Phase 4 — Validation & Feedback   ████████  ~2-3 days
├─ Client-side validation          │ JS
├─ Unanswered question markers     │ JS + CSS
├─ Submit button state             │ JS
└─ Success page                    │ New view + controller

Phase 5 — Visual Polish           ████████  ~1-2 days
├─ Responsive design               │ CSS
├─ Section card styling            │ CSS
├─ Typography consistency          │ CSS
└─ Loading states                  │ CSS + JS
```

**Estimated Total**: ~10-14 days

### Recommended Priority
1. **Quick Wins** → ship immediately
2. **Phase 1** (Multi-Step Wizard) → biggest UX improvement
3. **Phase 2** (Auto-Save) → biggest reliability improvement
4. **Phase 4** (Validation) → prevents bad data
5. **Phase 3 + 5** (Polish) → final refinement
