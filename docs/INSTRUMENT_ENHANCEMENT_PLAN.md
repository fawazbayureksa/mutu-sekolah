# Instrument Admin — Enhancement Plan

> **Date**: February 11, 2026  
> **Scope**: Simplify and polish the Instrument management module  
> **Philosophy**: This is a simple government project. Instruments are standardized and rarely change. Keep it simple.

---

## Table of Contents

1. [Current State](#1-current-state)
2. [Simplification Strategy](#2-simplification-strategy)
3. [Phase 1 — Clean Up Dead Code](#3-phase-1--clean-up-dead-code)
4. [Phase 2 — UI/UX Improvements](#4-phase-2--uiux-improvements)
5. [Phase 3 — Question Management](#5-phase-3--question-management)
6. [File Changes Overview](#6-file-changes-overview)
7. [Implementation Order](#7-implementation-order)

---

## 1. Current State

### What Exists
The admin can manage "Instrumen" — questionnaire templates that define what questions schools need to answer. Each instrument links to questions from a master question library.

| Feature | Status |
|---------|--------|
| CRUD (create/read/update/delete) | ✅ Working |
| Publish / Unpublish | ✅ Working |
| Duplicate instrument | ✅ Working |
| Bulk actions (activate/deactivate/delete) | ✅ Working |
| CSV Export | ✅ Basic (TODO for Excel) |
| Question selection in create/edit | ✅ Working (checkbox table) |
| Activity logging | ✅ Working |
| Views: index, create, edit, show | ✅ All exist |

### What's Overly Complex

This project has ~5-10 instruments at most. The current system is built like it manages hundreds. Here's what's unnecessary:

| Feature | Why It's Too Much |
|---------|-------------------|
| 5 scoring methods (simple_sum, weighted, average, percentage, custom) | Government instruments use fixed scoring — one method is enough |
| Instrument versioning with version field + filter | Instruments change maybe once per year — use date/name instead |
| Duplicate instrument feature | With <10 instruments, just create a new one |
| Bulk actions (activate/deactivate/delete multiple) | Never needed with <10 items |
| CSV export of instrument list | Not useful for <10 items |
| `InstrumentManagementService.php` (175 lines) | Dead code — controller does everything directly |
| 4 orphaned partial views | Never included anywhere |
| Complex filter bar (category + version + status + search) | Simple search is enough |

### What's Actually Important
For a government school quality system, admins need to:
1. Create an instrument with a name and description
2. Add questions to it (from the master question library)
3. Set order of questions
4. Publish it so schools can fill it
5. View what questions an instrument contains

That's it. Everything else is nice-to-have.

---

## 2. Simplification Strategy

### Keep
- ✅ Basic CRUD (create, view, edit, delete)
- ✅ Publish / Unpublish toggle
- ✅ Question assignment (link questions to instrument)
- ✅ Instrument detail view
- ✅ Activity logging (it's already there and useful)

### Simplify
- 🔄 Create/edit form — reduce to essential fields only
- 🔄 Index page — simpler table, basic search only
- 🔄 Show page — cleaner layout, fix broken HTML

### Remove
- ❌ `InstrumentManagementService.php` — dead code
- ❌ 4 orphaned partial views
- ❌ Duplicate instrument feature (or demote to low-priority)
- ❌ Bulk actions (not needed for <10 instruments)
- ❌ Complex filter bar (keep simple search)

---

## 3. Phase 1 — Clean Up Dead Code

### 3.1 Delete Unused Files

| File | Reason |
|------|--------|
| `app/Services/InstrumentManagementService.php` | Not called anywhere — controller has all logic inline |
| `resources/views/admin/instruments/partials/filters.blade.php` | Not `@include`d — index has inline filters |
| `resources/views/admin/instruments/partials/question-selector.blade.php` | Not `@include`d — uses jQuery (`$()`) but project uses vanilla JS. The `openQuestionSelector()` function called in create.blade.php is undefined |
| `resources/views/admin/instruments/partials/questions-manager.blade.php` | Not `@include`d — orphaned |
| `resources/views/admin/instruments/partials/status-badge.blade.php` | Not `@include`d — index/show have inline badge logic |

### 3.2 Fix Broken HTML in show.blade.php
The duplicate form tag has a malformed `>`. Find and fix.

### 3.3 Remove Duplicate Create/Edit Logic
`create.blade.php` has `isset($instrument)` checks to double as edit form, but a dedicated `edit.blade.php` exists. Remove the edit-mode logic from create.blade.php.

### 3.4 Move Misplaced Repository Methods
`InstrumentRepository` has `storeSchool()` and `storeResponses()` — these belong in a `SubmissionRepository` or the service layer, not the instrument repository. Move or refactor.

**Estimated effort**: ~0.5 day

---

## 4. Phase 2 — UI/UX Improvements

### 4.1 Index Page — Simplified

**Current**: Complex table with inline filters, bulk actions, export, 8+ columns.

**Improved**:
```
┌──────────────────────────────────────────────────────────────┐
│ Instrumen                               [+ Buat Instrumen]  │
│                                                              │
│ 🔍 [Search by name...                  ]                     │
│                                                              │
│ ┌────────────────────────────────────────────────────────┐   │
│ │ Nama           │ Kategori  │ Jumlah │ Status  │ Aksi   │   │
│ │                │           │ Soal   │         │        │   │
│ ├────────────────┼───────────┼────────┼─────────┼────────┤   │
│ │ KPTK 2024      │ KPTK      │ 45     │ 🟢 Aktif│ ⚙️     │   │
│ │ KPTK ADV 2024  │ KPTK      │ 52     │ 🟢 Aktif│ ⚙️     │   │
│ │ Test Instrument│ Lainnya   │ 10     │ ⬜ Draft│ ⚙️     │   │
│ └────────────────┴───────────┴────────┴─────────┴────────┘   │
│                                                              │
│ Menampilkan 3 instrumen                                      │
└──────────────────────────────────────────────────────────────┘
```

Changes:
- Remove: version column, bulk checkboxes, export button, complex filter bar
- Keep: search, status badge, question count, action dropdown
- Add: better empty state message
- Improve: hoverable rows, cleaner action dropdown (View / Edit / Publish / Delete)

### 4.2 Create Form — Simplified

```
┌──────────────────────────────────────────────────────────────┐
│ Buat Instrumen Baru                                          │
│                                                              │
│ Kode:           [AUTO-KPTK-001          ]                    │
│ Nama:           [Instrumen KPTK 2026     ]                   │
│ Kategori:       [KPTK ▼]                                     │
│ Deskripsi:      [____________________________]               │
│                 [____________________________]               │
│ Petunjuk:       [____________________________]               │
│                                                              │
│ ── Pilih Pertanyaan ──────────────────────────────────────  │
│                                                              │
│ 🔍 [Filter pertanyaan...]                                    │
│                                                              │
│ ☑ A1.1 - Sekolah memiliki kurikulum...         [Boolean]     │
│ ☑ A1.2 - Tingkat kesesuaian kurikulum          [Scale]       │
│ ☐ A2.1 - Rasio guru terhadap siswa             [Number]      │
│ ☐ A2.2 - Persentase guru bersertifikat         [Percentage]  │
│ ...                                                          │
│                                                              │
│ 12 pertanyaan dipilih                                        │
│                                                              │
│ [Simpan] [Batal]                                             │
└──────────────────────────────────────────────────────────────┘
```

Changes:
- Remove: version field, scoring method selector, estimated duration, is_active toggle (default active)
- Keep: code, name, category, description, instructions, question selection
- Improve: better question selection with search/filter and count indicator
- Question selection: show question type badge, aspect grouping

### 4.3 Show/Detail Page — Cleaner

```
┌──────────────────────────────────────────────────────────────┐
│ 🔙 Kembali                                                  │
│                                                              │
│ KPTK 2024                                    [Edit] [⚙️ ▼]  │
│ Instrumen Penjaminan Mutu Bidang KPTK                        │
│                                                              │
│ ┌──────────────┬──────────────┬──────────────┐               │
│ │ 📋 45 Soal    │ 📁 KPTK      │ 🟢 Published  │               │
│ └──────────────┴──────────────┴──────────────┘               │
│                                                              │
│ Deskripsi:                                                   │
│ Lorem ipsum dolor sit amet...                                │
│                                                              │
│ ── Daftar Pertanyaan ─────────────────────────────────────── │
│                                                              │
│  Aspek 1: Kurikulum                                          │
│  ├─ 1.1 Indikator Kurikulum                                 │
│  │  ├─ A1.1 Sekolah memiliki kurikulum...     [Boolean]      │
│  │  └─ A1.2 Tingkat kesesuaian kurikulum      [Scale 1-5]    │
│  └─ 1.2 Indikator Implementasi                              │
│     └─ A1.3 Kurikulum diimplementasikan...    [Scale 1-5]    │
│                                                              │
│  Aspek 2: Proses Pembelajaran                                │
│  ├─ ...                                                      │
│                                                              │
│ ── Info ──────────────────────────────────────────────────── │
│ Dibuat: 01 Jan 2026 oleh Admin                               │
│ Terakhir diubah: 05 Feb 2026                                 │
│ Digunakan: 12 submission, 3 assessment                       │
└──────────────────────────────────────────────────────────────┘
```

Changes:
- Remove: complex right sidebar with stats/help text
- Show questions in a **tree view** (aspect → indicator → question) — easier to scan
- Clean stat cards at the top
- Fix broken HTML

### 4.4 Edit Page — Match Create
Same simplified layout as create, but:
- Code field is readonly
- Pre-selected questions shown
- Show warning if instrument has existing submissions: "Instrumen ini sudah memiliki X submission. Mengubah pertanyaan dapat mempengaruhi data."

**Estimated effort**: ~2-3 days

---

## 5. Phase 3 — Question Management

### 5.1 Better Question Selection
The current question selection in create/edit uses a basic checkbox table. Improve:

- Group questions by aspect/indicator in an accordion
- Show question type with colored badge (Boolean=green, Scale=blue, Number=orange, etc.)
- Add search within questions
- Show selected count: "12 dari 45 pertanyaan dipilih"
- Allow drag-and-drop reordering of selected questions (or simple up/down arrows)

### 5.2 Question Order
Currently questions are ordered by `InstrumentItem.order`. Add:
- Order numbers visible in the question list
- Up/down arrow buttons to reorder
- Or just follow the natural aspect → indicator → question order (simplest approach)

### 5.3 Question Preview
On hover or click, show a preview of what the question looks like:
- Question text + help text
- Answer type visualization (e.g., preview of scale options)
- This helps admin verify they're selecting the right question

**Estimated effort**: ~1-2 days

---

## 6. File Changes Overview

| File | Action |
|------|--------|
| `app/Services/InstrumentManagementService.php` | **DELETE** |
| `resources/views/admin/instruments/partials/filters.blade.php` | **DELETE** |
| `resources/views/admin/instruments/partials/question-selector.blade.php` | **DELETE** |
| `resources/views/admin/instruments/partials/questions-manager.blade.php` | **DELETE** |
| `resources/views/admin/instruments/partials/status-badge.blade.php` | **DELETE** |
| `resources/views/admin/instruments/index.blade.php` | Simplify: remove bulk actions, export, complex filters |
| `resources/views/admin/instruments/create.blade.php` | Simplify: remove version, scoring method, duration, edit-mode logic |
| `resources/views/admin/instruments/edit.blade.php` | Match simplified create layout, add submission warning |
| `resources/views/admin/instruments/show.blade.php` | Redesign: tree view for questions, stat cards, fix broken HTML |
| `app/Http/Controllers/Admin/InstrumentController.php` | Remove bulk actions, simplify filters, remove export (or keep minimal) |
| `app/Repositories/InstrumentRepository.php` | Move `storeSchool()`/`storeResponses()` to appropriate location |

---

## 7. Implementation Order

```
Phase 1 — Clean Up               ██████████  ~0.5 day
├─ Delete 5 unused files          │
├─ Fix broken HTML                │
├─ Remove create/edit duplication │
└─ Move misplaced repo methods    │

Phase 2 — UI/UX Improvements     ██████████  ~2-3 days
├─ Simplify index page            │
├─ Simplify create form           │
├─ Redesign show page             │
└─ Update edit page               │

Phase 3 — Question Management     ██████████  ~1-2 days
├─ Grouped question selection     │
├─ Question ordering              │
└─ Question preview               │
```

**Estimated Total**: ~4-5 days

### Priority
1. **Phase 1** (Clean Up) — do immediately, zero risk
2. **Phase 2** (UI/UX) — biggest user-facing improvement
3. **Phase 3** (Questions) — nice-to-have, current checkbox table works fine

### What NOT to Build
For this simple government project, these features are **not worth building**:
- ❌ Complex scoring method configuration (use one fixed method)
- ❌ Instrument versioning system
- ❌ Batch import/export of instruments
- ❌ Instrument comparison/diffing
- ❌ Role-based instrument permissions
- ❌ Custom instrument themes/styling
- ❌ Instrument templates marketplace

Keep it simple. An instrument is just a named list of questions.
