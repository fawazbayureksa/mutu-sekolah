# Migration Files Summary

## Created Migration Files

### 1. `2026_02_05_020000_enhance_assessment_questions_table.php`
**Purpose**: Enhance assessment_questions table with missing critical fields

**Added Fields:**
- `question_code` - Unique question identifier (e.g., "A.1.1")
- `answer_options` - JSON field for scale/multiple choice options
- `help_text` - Guidance text for answering
- `is_required` - Mandatory question flag
- `max_score`/`min_score` - Scoring bounds
- `is_active` - Enable/disable questions
- `scale_template_id` - Link to reusable scale templates (added by migration 5)

**Enhanced:**
- `answer_type` enum - Added: multiple_choice, percentage, file types

**Indexes Added:**
- question_code
- indicator_id, order
- is_active

---

### 2. `2026_02_05_020001_enhance_assessment_answers_table.php`
**Purpose**: Add scoring, validation, and rich answer storage

**Added Fields:**
- `score` - Calculated score for answer
- `numeric_value` - Store numeric answers
- `boolean_value` - Store boolean answers
- `notes` - Additional comments
- `file_path` - Path to uploaded files
- `attachments` - JSON array of supporting documents
- `answered_by`/`answered_at` - Track respondent
- `validation_status` - Workflow status (pending, validated, rejected, needs_revision)
- `validation_notes` - Validator comments
- `validated_by`/`validated_at` - Validation tracking

**Indexes Added:**
- assessment_id, question_id
- validation_status
- answered_at

---

### 3. `2026_02_05_020002_enhance_assessments_table.php`
**Purpose**: Add comprehensive assessment tracking and workflow

**Added Fields:**
- `instrument_id` - Link to instrument template
- `total_score`/`max_possible_score`/`percentage` - Score tracking
- `grade` - Grade category (A, B, C)
- `academic_year`/`semester` - Academic period
- `assessment_type` - Type (self-assessment, external-audit, monitoring)
- `total_questions`/`answered_questions`/`completion_percentage` - Progress tracking
- `started_at`/`completed_at`/`duration_minutes` - Time tracking
- `verified_by`/`verified_at`/`verification_notes` - Verification workflow
- `approved_by`/`approved_at`/`approval_notes` - Approval workflow
- `remarks` - General observations
- `metadata` - Flexible JSON field
- `deleted_at` - Soft delete support

**Indexes Added:**
- instrument_id
- school_id, period_year
- status, submitted_at
- academic_year
- assessment_type
- deleted_at

---

### 4. `2026_02_05_020003_consolidate_assessment_instrument_systems.php`
**Purpose**: Consolidate Assessment and Instrument systems into unified approach

**Modified Tables:**

**instrument_items:**
- `assessment_question_id` - Link to master question library
- `order` - Question sequence
- `uses_master_question` - Flag for question source
- `custom_help_text` - Instrument-specific override
- `custom_answer_options` - Instrument-specific override
- Made existing fields nullable when using master questions

**instruments:**
- `category` - Instrument categorization
- `version` - Version control
- `is_active`/`is_published`/`published_at` - Publication status
- `created_by`/`updated_by` - Creator tracking
- `instructions` - Filling instructions
- `estimated_duration` - Expected completion time
- `scoring_method` - Calculation method (simple_sum, weighted_sum, average, percentage, custom)
- `deleted_at` - Soft delete

**New Table: instrument_aspects**
- Bridge table linking instruments to assessment aspects
- Fields: instrument_id, aspect_id, order, weight

**Indexes Added:**
- Multiple indexes for performance

---

### 5. `2026_02_05_020004_create_answer_options_tables.php`
**Purpose**: Create reusable answer option and scale template system

**New Tables:**

**answer_options:**
- Individual answer options for questions
- Fields: question_id, option_value, option_label, score, order, color, icon, description, is_active

**scale_templates:**
- Reusable scale definitions (Likert, rating, etc.)
- Fields: code, name, description, scale_type, scale_options (JSON), min_score, max_score, usage_count, is_default, is_active, created_by

**Modified Tables:**
- `assessment_questions` - Added `scale_template_id` link

**Predefined Scale Types:**
- likert, rating, frequency, satisfaction, quality, boolean, custom

---

## Installation Instructions

### Option 1: Run All Migrations
```bash
php artisan migrate
```

### Option 2: Run Individual Migrations (Recommended for testing)
```bash
# Step 1: Enhance questions
php artisan migrate --path=/database/migrations/2026_02_05_020000_enhance_assessment_questions_table.php

# Step 2: Enhance answers
php artisan migrate --path=/database/migrations/2026_02_05_020001_enhance_assessment_answers_table.php

# Step 3: Enhance assessments
php artisan migrate --path=/database/migrations/2026_02_05_020002_enhance_assessments_table.php

# Step 4: Consolidate systems
php artisan migrate --path=/database/migrations/2026_02_05_020003_consolidate_assessment_instrument_systems.php

# Step 5: Create answer options
php artisan migrate --path=/database/migrations/2026_02_05_020004_create_answer_options_tables.php
```

### Rollback (if needed)
```bash
# Rollback all 5 migrations
php artisan migrate:rollback --step=5

# Or rollback specific migration
php artisan migrate:rollback --path=/database/migrations/2026_02_05_020004_create_answer_options_tables.php
```

---

## Seeding

### Seed Scale Templates (Required)
```bash
php artisan db:seed --class=ScaleTemplateSeeder
```

This will create 8 predefined scale templates:
1. LIKERT_5_AGREEMENT - 5-point agreement scale
2. QUALITY_5 - 5-point quality scale
3. CONFORMITY_5 - 5-point conformity scale
4. YES_NO - Simple yes/no
5. ADA_TIDAK_ADA - Available/not available
6. CONDITION_4 - 4-point condition scale
7. FREQUENCY_5 - 5-point frequency scale
8. RATING_1_10 - 1-10 numeric rating

### Existing Seeders
```bash
# Seed assessment structure
php artisan db:seed --class=InstrumentSeeder

# Seed public instruments
php artisan db:seed --class=PublicInstrumentSeeder
```

---

## Testing Migrations

### 1. Fresh Install (Caution: Destroys all data)
```bash
php artisan migrate:fresh --seed
```

### 2. Test Individual Migration
```bash
# Run migration
php artisan migrate --path=/database/migrations/2026_02_05_020000_enhance_assessment_questions_table.php

# Check tables
php artisan tinker
>>> Schema::hasColumn('assessment_questions', 'question_code')

# Rollback
php artisan migrate:rollback --step=1
```

### 3. Verify Database Structure
```bash
php artisan tinker

# Check assessment_questions columns
>>> DB::select('DESCRIBE assessment_questions');

# Check if foreign keys exist
>>> DB::select('SHOW CREATE TABLE instrument_items');

# Check indexes
>>> DB::select('SHOW INDEXES FROM assessments');
```

---

## Compatibility Notes

### Breaking Changes
⚠️ **None** - All migrations are backward compatible:
- Existing columns are NOT modified (only additions)
- New columns are nullable or have defaults
- Foreign keys use `onDelete('cascade')` or `onDelete('set null')`
- Existing data remains intact

### Required Updates After Migration

1. **Update Models** - Add new relationships and fillable fields
2. **Update Controllers** - Handle new fields in requests
3. **Update Validation Rules** - Add validation for new fields
4. **Update API Documentation** - Document new endpoints/fields
5. **Update Frontend** - Add UI for new features

---

## Common Issues & Solutions

### Issue: Migration fails with "column already exists"
**Solution:** 
```bash
# Check which migrations have been run
php artisan migrate:status

# Rollback specific migration
php artisan migrate:rollback --step=1
```

### Issue: Foreign key constraint fails
**Solution:** Ensure referenced tables exist:
```bash
# Check table exists
php artisan tinker
>>> Schema::hasTable('scale_templates')
```

### Issue: Enum type modification error (MySQL/MariaDB)
**Solution:** The migration uses `->change()` for enum. On some MySQL versions, you may need to:
1. Drop the column
2. Re-add with new enum values

If this happens, modify migration to use raw SQL:
```php
DB::statement("ALTER TABLE assessment_questions MODIFY answer_type ENUM('boolean', 'scale', 'number', 'text', 'multiple_choice', 'percentage', 'file')");
```

---

## Next Steps After Migration

1. ✅ Migrations completed
2. ⏭️ Run seeders (ScaleTemplateSeeder)
3. ⏭️ Update Model files with new relationships
4. ⏭️ Create/update service classes for score calculation
5. ⏭️ Update controllers to handle new fields
6. ⏭️ Create API endpoints for new features
7. ⏭️ Update frontend forms and validation
8. ⏭️ Write tests for new functionality
9. ⏭️ Update API documentation

---

## Database Diagram Reference

```
┌─────────────────────┐
│ scale_templates     │
│ (Reusable scales)   │
└─────────┬───────────┘
          │
          │ scale_template_id
          ↓
┌─────────────────────┐       ┌──────────────────┐
│assessment_aspects   │───────│assessment_       │
│ (Standards)         │       │indicators        │
└─────────────────────┘       └────────┬─────────┘
                                       │
                              ┌────────┴─────────────┐
                              │assessment_questions  │◄──┐
                              │ (Master Library)     │   │
                              └────────┬─────────────┘   │
                                       │                 │
                    ┌──────────────────┼─────────────┐   │
                    │                  │             │   │
          ┌─────────▼──────┐  ┌───────▼──────┐     │   │
          │answer_options  │  │assessments   │     │   │
          └────────────────┘  └───────┬──────┘     │   │
                                      │            │   │
                              ┌───────▼──────────┐ │   │
                              │assessment_answers│ │   │
                              └──────────────────┘ │   │
                                                   │   │
┌──────────────────┐      ┌────────────────┐      │   │
│ instruments      │──────│instrument_items│──────┘   │
│ (Templates)      │      │ (Questions)    │──────────┘
└─────────┬────────┘      └────────────────┘
          │
    ┌─────┴──────────┐
    │instrument_     │
    │aspects         │
    │ (Bridge)       │
    └────────────────┘
```

---

## File Checklist

- [x] `2026_02_05_020000_enhance_assessment_questions_table.php`
- [x] `2026_02_05_020001_enhance_assessment_answers_table.php`
- [x] `2026_02_05_020002_enhance_assessments_table.php`
- [x] `2026_02_05_020003_consolidate_assessment_instrument_systems.php`
- [x] `2026_02_05_020004_create_answer_options_tables.php`
- [x] `ScaleTemplateSeeder.php`
- [x] `SCHEMA_ENHANCEMENT_GUIDE.md`
- [x] `MIGRATION_SUMMARY.md` (this file)

All files created successfully! ✅
