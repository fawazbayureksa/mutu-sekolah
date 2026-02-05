# Database Schema Enhancement - Unified Assessment & Instrument System

## Overview

This document describes the enhanced database schema that consolidates the Assessment and Instrument systems into a unified, flexible architecture for quality assessment management.

## System Architecture

### Before Enhancement
The system had **two overlapping approaches**:

1. **Assessment System**: `assessment_aspects` → `assessment_indicators` → `assessment_questions` → `assessment_answers`
2. **Instrument System**: `instruments` → `instrument_items` → `responses` → `submissions`

### After Enhancement
The systems are now **unified and complementary**:

- **Assessment Questions Library**: Master repository of all questions organized by aspects and indicators
- **Instruments**: Flexible containers that can use questions from the library or define custom ones
- **Assessments/Submissions**: Actual filled forms with answers and scores

## Database Structure

### Core Tables Hierarchy

```
assessment_aspects (Standards/Categories)
    ↓
assessment_indicators (Specific indicators per aspect)
    ↓
assessment_questions (Individual questions with scoring)
    ↓
assessment_answers (Responses to questions)
    ↑
assessments (Complete assessment submissions)
```

### Instrument System

```
instruments (Assessment forms/templates)
    ↓
instrument_items (Questions in the instrument)
    ↓ (can reference)
assessment_questions (Master question library)
    ↓
submissions (Filled instruments)
    ↓
responses (Individual answers)
```

### Bridge Tables

- `instrument_aspects`: Links instruments to relevant aspects (many-to-many)
- `answer_options`: Stores available options for each question
- `scale_templates`: Reusable scale definitions (Likert, rating, etc.)

## Key Enhancements

### 1. Assessment Questions Table

**New Fields:**
- `question_code`: Unique identifier (e.g., "A.1.1", "B.2.3")
- `answer_options`: JSON field for scale/multiple choice options
- `help_text`: Guidance for answering
- `is_required`: Whether question is mandatory
- `max_score`/`min_score`: Scoring bounds
- `scale_template_id`: Link to reusable scale templates
- `is_active`: Enable/disable questions

**Enhanced Answer Types:**
```php
'boolean'          // Yes/No, Ada/Tidak Ada
'scale'            // 1-5 rating, Likert scales
'number'           // Numeric input (jumlah, persentase)
'text'             // Free text/descriptive
'multiple_choice'  // Pilihan ganda
'percentage'       // Percentage value (0-100)
'file'             // File upload/attachment
```

### 2. Assessment Answers Table

**New Fields:**
- `score`: Calculated score for the answer
- `numeric_value`: Store numeric answers
- `boolean_value`: Store boolean answers
- `notes`: Additional comments/explanation
- `file_path`: Path to uploaded files
- `attachments`: JSON array of supporting documents
- `answered_by`/`answered_at`: Track respondent
- `validation_status`: Workflow status (pending, validated, rejected, needs_revision)
- `validated_by`/`validated_at`: Validation tracking
- `validation_notes`: Validator comments

### 3. Assessments Table

**New Fields:**
- `instrument_id`: Link to instrument template
- `total_score`: Calculated total score
- `max_possible_score`: Maximum achievable score
- `percentage`: Score as percentage (0-100)
- `grade`: Grade category (A, B, C, etc.)
- `academic_year`/`semester`: Academic period
- `assessment_type`: Type of assessment (self-assessment, external-audit, monitoring)
- `total_questions`/`answered_questions`: Progress tracking
- `completion_percentage`: Completion status
- `started_at`/`completed_at`: Time tracking
- `duration_minutes`: Time taken
- `verified_by`/`approved_by`: Approval workflow
- `remarks`: General observations
- `metadata`: Flexible JSON field for custom data
- `deleted_at`: Soft delete support

### 4. Instruments Table

**New Fields:**
- `category`: Instrument categorization
- `version`: Version control (1.0, 1.1, 2.0)
- `is_active`/`is_published`: Publication status
- `published_at`: Publication date
- `created_by`/`updated_by`: Creator tracking
- `instructions`: General filling instructions
- `estimated_duration`: Expected completion time
- `scoring_method`: How to calculate scores (simple_sum, weighted_sum, average, percentage, custom)
- `deleted_at`: Soft delete support

### 5. Instrument Items Table

**New Fields:**
- `assessment_question_id`: Reference to master question library
- `order`: Question sequence in instrument
- `uses_master_question`: Flag for question source
- `custom_help_text`: Instrument-specific help text override
- `custom_answer_options`: Instrument-specific options override

**Flexibility:**
- Can reference questions from master library
- Can define custom questions specific to instrument
- Can override help text and options per instrument

### 6. New Tables

#### `answer_options`
Stores individual answer options for each question:
- `option_value`: Value stored in database
- `option_label`: Display text
- `score`: Score for this option
- `order`: Display order
- `color`: UI color coding
- `description`: Help text for option

#### `scale_templates`
Reusable scale definitions:
- `code`: Unique identifier (e.g., "LIKERT_5_AGREEMENT")
- `name`: Template name
- `scale_type`: Type (likert, rating, frequency, satisfaction, quality, boolean)
- `scale_options`: JSON array of scale options
- `min_score`/`max_score`: Scoring bounds
- `is_default`: System default templates

**Predefined Templates:**
1. `LIKERT_5_AGREEMENT` - 5-point agreement scale
2. `QUALITY_5` - 5-point quality scale
3. `CONFORMITY_5` - 5-point conformity scale
4. `YES_NO` - Simple yes/no
5. `ADA_TIDAK_ADA` - Available/not available
6. `CONDITION_4` - 4-point condition scale
7. `FREQUENCY_5` - 5-point frequency scale
8. `RATING_1_10` - 1-10 numeric rating

#### `instrument_aspects`
Bridge table linking instruments to aspects:
- `instrument_id`: The instrument
- `aspect_id`: The aspect covered
- `order`: Aspect order in instrument
- `weight`: Aspect weight in scoring

## Usage Examples

### Creating an Instrument from Master Questions

```php
// 1. Create instrument
$instrument = Instrument::create([
    'code' => 'KPTK-2024',
    'name' => 'Instrumen Penjaminan Mutu SMK Bidang KPTK',
    'category' => 'Mutu SMK',
    'version' => '1.0',
    'scoring_method' => 'weighted_sum',
    'estimated_duration' => 60,
]);

// 2. Link to aspects
$instrument->aspects()->attach($aspectId, [
    'order' => 1,
    'weight' => 1.0
]);

// 3. Add questions from master library
InstrumentItem::create([
    'instrument_id' => $instrument->id,
    'assessment_question_id' => $questionId, // From master
    'section' => 'Peserta Didik',
    'order' => 1,
    'uses_master_question' => true,
]);

// 4. Or add custom question
InstrumentItem::create([
    'instrument_id' => $instrument->id,
    'section' => 'Custom Section',
    'indicator_code' => 'CUSTOM-1',
    'indicator_text' => 'Custom question text',
    'answer_type' => 'scale',
    'order' => 2,
    'uses_master_question' => false,
]);
```

### Creating an Assessment

```php
// 1. Create assessment
$assessment = Assessment::create([
    'instrument_id' => $instrumentId,
    'school_id' => $schoolId,
    'respondent_name' => 'John Doe',
    'respondent_position' => 'Kepala Sekolah',
    'filled_at' => now(),
    'period_year' => '2024',
    'academic_year' => '2024/2025',
    'semester' => '1',
    'assessment_type' => 'self-assessment',
    'status' => 'draft',
    'started_at' => now(),
]);

// 2. Answer questions
AssessmentAnswer::create([
    'assessment_id' => $assessment->id,
    'question_id' => $questionId,
    'answer_value' => '5', // Scale answer
    'numeric_value' => 5,
    'score' => 100.00, // Auto-calculated
    'answered_by' => 'John Doe',
    'answered_at' => now(),
]);

// 3. Calculate total score
$assessment->update([
    'total_score' => $assessment->calculateTotalScore(),
    'answered_questions' => $assessment->answers()->count(),
    'completion_percentage' => ($answeredCount / $totalCount) * 100,
]);

// 4. Submit
$assessment->update([
    'status' => 'submitted',
    'submitted_at' => now(),
    'completed_at' => now(),
]);
```

### Using Scale Templates

```php
// 1. Get a scale template
$template = ScaleTemplate::where('code', 'LIKERT_5_AGREEMENT')->first();

// 2. Create question with template
$question = AssessmentQuestion::create([
    'indicator_id' => $indicatorId,
    'question_code' => 'A.1.1',
    'question_text' => 'Apakah fasilitas sesuai standar?',
    'answer_type' => 'scale',
    'scale_template_id' => $template->id,
    'weight' => 1.0,
    'is_required' => true,
]);

// 3. Template automatically provides answer options
$options = json_decode($template->scale_options, true);
// [
//   {"value": "1", "label": "Sangat Tidak Setuju", "score": 20.00},
//   {"value": "2", "label": "Tidak Setuju", "score": 40.00},
//   ...
// ]
```

## Migration Order

Run migrations in this order:

```bash
php artisan migrate --path=/database/migrations/2026_02_05_020000_enhance_assessment_questions_table.php
php artisan migrate --path=/database/migrations/2026_02_05_020001_enhance_assessment_answers_table.php
php artisan migrate --path=/database/migrations/2026_02_05_020002_enhance_assessments_table.php
php artisan migrate --path=/database/migrations/2026_02_05_020003_consolidate_assessment_instrument_systems.php
php artisan migrate --path=/database/migrations/2026_02_05_020004_create_answer_options_tables.php
```

Or simply:
```bash
php artisan migrate
```

## Seeding

```bash
# 1. Seed scale templates first
php artisan db:seed --class=ScaleTemplateSeeder

# 2. Seed assessment structure (aspects, indicators, questions)
php artisan db:seed --class=InstrumentSeeder

# 3. Seed instruments
php artisan db:seed --class=PublicInstrumentSeeder
```

## Benefits of Unified System

1. **Reusability**: Questions can be reused across multiple instruments
2. **Consistency**: Standardized scales and scoring across assessments
3. **Flexibility**: Can use master questions or define custom ones
4. **Version Control**: Track instrument versions over time
5. **Workflow Support**: Built-in validation and approval workflow
6. **Rich Metadata**: Comprehensive tracking of completion, timing, scoring
7. **Soft Deletes**: Safe deletion with data retention
8. **Performance**: Proper indexes for fast queries
9. **Extensibility**: JSON fields for custom data without schema changes
10. **Type Safety**: Separate fields for different answer types

## Next Steps

1. Update Model relationships to reflect new structure
2. Create service classes for score calculation
3. Implement validation logic for answers
4. Create API endpoints for assessment workflow
5. Build UI components for different answer types
6. Implement reporting and analytics
7. Add export functionality (PDF, Excel)
8. Create admin panel for instrument management

## Notes

- All migrations are reversible (include `down()` methods)
- Existing data is preserved (columns made nullable where needed)
- Foreign keys include proper cascade/set null behavior
- Indexes added for common query patterns
- Soft deletes enable data recovery
- JSON fields provide flexibility without frequent migrations



- Created migration to consolidate assessment and instrument systems into a unified approach.
- Added foreign key reference to assessment_questions in instrument_items for a reusable question library.
- Enhanced instruments table with new fields for categorization, version control, and metadata.
- Introduced a new bridge table (instrument_aspects) to link instruments with assessment aspects.
- Created migration for reusable answer options and scale templates to standardize responses across questions.
- Added seeder for predefined scale templates to facilitate quick setup of common scales.
- Documented migration summary and schema enhancements for clarity and future reference.