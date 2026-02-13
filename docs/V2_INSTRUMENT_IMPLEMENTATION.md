# V2 Instrument Form Implementation

**Date:** February 13, 2026  
**Status:** Complete

## Overview

This document describes the V2 Instrument Form feature implementation. The V2 form is a hardcoded form (not database-driven) with support for dynamic rows in specific sections, designed for data collection and verification workflow.

---

## Key Differences from V1

| Feature | V1 | V2 |
|---------|----|----|
| Form Structure | Database-driven (Instrument, Questions, etc.) | Hardcoded in Blade templates |
| Dynamic Rows | Not supported | Supported (B.1.1, C.1.1, C.2.1, C.3.1) |
| Data Storage | Complex relational tables | Single JSON column + detail table for analytics |
| Admin Interface | Separate from V1 | Dedicated V2 admin pages |

---

## Database Structure

### Tables Created

#### 1. `instrument_submissions_v2`
Main submission table storing all form data.

```php
Schema::create('instrument_submissions_v2', function (Blueprint $table) {
    $table->id();
    
    // School Information
    $table->string('school_name');
    $table->string('npsn')->nullable();
    $table->text('address');
    
    // Respondent Information
    $table->string('respondent_name');
    $table->string('respondent_position');
    $table->date('filled_at')->nullable();
    
    // Form Data
    $table->string('form_version')->default('2.0');
    $table->json('answers');  // All section answers stored as JSON
    
    // Workflow Status
    $table->enum('status', ['draft', 'submitted', 'verified', 'validated', 'rejected'])
          ->default('draft');
    
    // Verification tracking
    $table->foreignId('verified_by')->nullable();
    $table->timestamp('verified_at')->nullable();
    $table->text('verification_notes')->nullable();
    
    // Validation tracking
    $table->foreignId('validated_by')->nullable();
    $table->timestamp('validated_at')->nullable();
    $table->text('validation_notes')->nullable();
    
    // One-time update token
    $table->string('update_token')->nullable();
    $table->timestamp('update_token_expires_at')->nullable();
    
    // Analytics
    $table->decimal('completion_percentage', 5, 2)->nullable();
    
    // Metadata
    $table->string('ip_address')->nullable();
    $table->text('user_agent')->nullable();
    $table->timestamps();
});
```

#### 2. `instrument_submission_v2_details`
Section-level detail storage for analytics purposes.

```php
Schema::create('instrument_submission_v2_details', function (Blueprint $table) {
    $table->id();
    $table->foreignId('submission_id')
          ->constrained('instrument_submissions_v2')
          ->onDelete('cascade');
    $table->string('section_code');  // e.g., 'A.1.1', 'B.1.1'
    $table->json('data');
    $table->integer('row_count')->default(0);
    $table->timestamps();
});
```

### Migration File
- `database/migrations/2026_02_13_204937_create_instrument_submissions_v2_table.php`

---

## Models

### 1. InstrumentSubmissionV2
**Path:** `app/Models/InstrumentSubmissionV2.php`

**Key Features:**
- Status constants: `STATUS_DRAFT`, `STATUS_SUBMITTED`, `STATUS_VERIFIED`, `STATUS_VALIDATED`, `STATUS_REJECTED`
- Automatic JSON casting for `answers` field
- Relationships: `verifier()`, `validator()`, `details()`
- Helper methods:
  - `getStatusBadgeClass()` - Returns Bootstrap badge class for status
  - `getStatusLabel()` - Returns Indonesian label for status
  - `generateUpdateToken()` - Creates one-time update token (24h expiry)
  - `hasValidUpdateToken($token)` - Validates update token

### 2. InstrumentSubmissionV2Detail
**Path:** `app/Models/InstrumentSubmissionV2Detail.php`

**Key Features:**
- Belongs to `InstrumentSubmissionV2`
- Helper methods:
  - `getSectionLabel()` - Returns human-readable section name
  - `hasDynamicRows()` - Checks if section supports dynamic rows
- Scopes for filtering by section

---

## Form Sections

The V2 form has the following sections:

### Aspect A - Standar Peserta Didik
| Code | Title | Type |
|------|-------|------|
| A.1.1 | Data Kelulusan Uji Kompetensi dan Sertifikasi | Static Table (3 rows) |
| A.2.1 | Penelusuran Alumni (Tracer Study) | Table with header input |

### Aspect B - Data Sarana Prasarana
| Code | Title | Type |
|------|-------|------|
| B.1.1 | Inventarisasi dan Kesesuaian dengan Standar Industri | **Dynamic Table** |
| B.2.1 | Penilaian Kesiapan Fasilitas | Checklist (Yes/No) |

### Aspect C - Data Tata Kelola
| Code | Title | Type |
|------|-------|------|
| C.1.1 | Kerjasama Industri | **Dynamic Table** |
| C.2.1 | Teaching Factory (TEFA) / Unit Produksi Sekolah | **Dynamic Table** |
| C.3.1 | Data Pelatihan dan Sertifikasi Guru | **Dynamic Table** |
| C.3.2 | Analisis Kebutuhan Pelatihan Guru ke Depan | Form (questionnaire) |

---

## Data Structure (JSON)

Each section stores data in this format:

```javascript
{
    "header": {
        "workshop_name": "Lab Komputer",
        "expertise_field": "TKJ"
    },
    "rows": [
        {
            "label": "Komputer PC",
            "specification": "Intel i5, 8GB RAM",
            "quantity": "20",
            "condition": "Baik",
            "industry_standard": "Ya",
            "remarks": "2022"
        },
        // ... more rows
    ]
}
```

For checklist (B.2.1):
```javascript
{
    "header": {},
    "rows": [
        {
            "layout_industry": "yes",
            "layout_industry_notes": "Sesuai standar",
            "calibration": "yes",
            "calibration_notes": "",
            // ... more items
        }
    ]
}
```

For form (C.3.2):
```javascript
{
    "competency_gap": {
        "answer": "...",
        "reason": "..."
    },
    "industry_alignment": {
        "answer": "...",
        "source": "..."
    },
    "training_priority": {
        "answer": "..."
    }
}
```

---

## Files Created/Modified

### Controllers

| File | Purpose |
|------|---------|
| `app/Http/Controllers/PublicInstrumentV2Controller.php` | Handles public form display and submission |
| `app/Http/Controllers/Admin/SubmissionV2Controller.php` | Admin management with verification workflow |

### Public Form Views

| File | Purpose |
|------|---------|
| `resources/views/instrument/form-v2.blade.php` | Main V2 form view |
| `resources/views/instrument/partials/v2/table-a11.blade.php` | A.1.1 - Static table |
| `resources/views/instrument/partials/v2/table-a21.blade.php` | A.2.1 - Tracer study table |
| `resources/views/instrument/partials/v2/table-b11.blade.php` | B.1.1 - Dynamic inventory table |
| `resources/views/instrument/partials/v2/checklist-b21.blade.php` | B.2.1 - Checklist |
| `resources/views/instrument/partials/v2/table-c11.blade.php` | C.1.1 - Dynamic industry partnership |
| `resources/views/instrument/partials/v2/table-c21.blade.php` | C.2.1 - Dynamic TEFA table |
| `resources/views/instrument/partials/v2/table-c31.blade.php` | C.3.1 - Dynamic teacher training |
| `resources/views/instrument/partials/v2/form-c32.blade.php` | C.3.2 - Questionnaire form |

### Admin Views

| File | Purpose |
|------|---------|
| `resources/views/admin/submissions-v2/index.blade.php` | List all V2 submissions with filters |
| `resources/views/admin/submissions-v2/show.blade.php` | Detail view with verification actions |
| `resources/views/admin/submissions-v2/partials/section-table.blade.php` | Renders table sections |
| `resources/views/admin/submissions-v2/partials/section-tracer.blade.php` | Renders A.2.1 tracer study |
| `resources/views/admin/submissions-v2/partials/section-checklist.blade.php` | Renders B.2.1 checklist |
| `resources/views/admin/submissions-v2/partials/section-form.blade.php` | Renders C.3.2 form |

### Modified Files

| File | Changes |
|------|---------|
| `routes/web.php` | Added V2 public routes and admin routes |
| `resources/views/layouts/admin.blade.php` | Added "Pengajuan V2" sidebar menu item |

---

## Routes

### Public Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/instrumen/v2` | `instrument.v2.form` | Display V2 form |
| POST | `/instrumen/v2` | `instrument.v2.submit` | Submit V2 form |

### Admin Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/admin/submissions-v2` | `admin.submissions-v2.index` | List submissions |
| GET | `/admin/submissions-v2/{id}` | `admin.submissions-v2.show` | View detail |
| POST | `/admin/submissions-v2/{id}/verify` | `admin.submissions-v2.verify` | Verify submission |
| POST | `/admin/submissions-v2/{id}/reject` | `admin.submissions-v2.reject` | Reject submission |
| POST | `/admin/submissions-v2/{id}/validate` | `admin.submissions-v2.validate` | Validate submission |
| POST | `/admin/submissions-v2/{id}/generate-token` | `admin.submissions-v2.generate-token` | Generate update link |
| GET | `/admin/submissions-v2/export/all` | `admin.submissions-v2.export` | Export data |
| DELETE | `/admin/submissions-v2/{id}` | `admin.submissions-v2.destroy` | Delete submission |

---

## Verification Workflow

```
┌─────────────┐
│   draft     │  (Not used in current implementation - direct submit)
└──────┬──────┘
       │
       ▼
┌─────────────┐
│  submitted  │  User submits form
└──────┬──────┘
       │
       ├────────────────┐
       │                │
       ▼                ▼
┌─────────────┐   ┌─────────────┐
│  verified   │   │  rejected   │
└──────┬──────┘   └──────┬──────┘
       │                 │
       ▼                 │ Generate update token
┌─────────────┐          │ User can edit & resubmit
│  validated  │          │
└─────────────┘          └───► Returns to submitted
```

---

## Admin Features

### Index Page (`/admin/submissions-v2`)
- Statistics cards: Total, Submitted, Verified, Validated, Rejected counts
- Filter tabs by status
- Table with: School name, NPSN, Respondent, Date, Completion %, Status
- Quick actions: View, Verify/Reject (via modals)
- Pagination support

### Detail Page (`/admin/submissions-v2/{id}`)
- School information card
- Respondent information card
- Status card with progress bar
- Verification/Validation history
- Full answer review by section
- Action buttons based on status:
  - `submitted`: Verify / Reject
  - `verified`: Validate
  - `rejected`: Generate Update Link

---

## JavaScript Features (form-v2.blade.php)

### Dynamic Row Management
- Add/Remove rows for sections B.1.1, C.1.1, C.2.1, C.3.1
- Automatic row renumbering
- Minimum row validation

### Auto-calculation
- A.1.1: Pass rate auto-calculated from participants/passed

### Data Collection
- `collectTableData(table)` - Collects header and row data
- `collectFormData(formId)` - Collects form questionnaire data
- `collectAllTableData()` - Called on form submit

---

## Future Enhancements (TODO)

1. **Update Token Route** - Need to create separate controller for V2 update flow
2. **Export Functionality** - Implement Excel/CSV export
3. **Bulk Actions** - Bulk verify/validate
4. **Analytics Dashboard** - Aggregate data visualization
5. **Email Notifications** - Notify on status changes

---

## Migration Commands

```bash
# Run migration
php artisan migrate

# If needed, fresh migration with seeding
php artisan migrate:fresh --seed
```

---

## Testing URLs

- Public Form: `http://localhost:8000/instrumen/v2`
- Admin List: `http://localhost:8000/admin/submissions-v2`
- Admin Detail: `http://localhost:8000/admin/submissions-v2/{id}`

---

## Related Documentation

- [API_ENDPOINTS.md](./API_ENDPOINTS.md)
- [AUTHENTICATION_SETUP.md](./AUTHENTICATION_SETUP.md)
- [ONE_TIME_ACCESS_URL.md](./ONE_TIME_ACCESS_URL.md)
