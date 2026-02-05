# Implementation Plan - Core Management Features
**Date:** February 5, 2026
**Status:** Planning Phase
**Based on:** Existing Laravel 10.10 codebase with Sanctum authentication

---

## 📋 Executive Summary

This document outlines the implementation plan for 4 core management features in the Mutu Sekolah system (form-based interfaces, NO file uploads):

1. **Instrument Management** - Admin UI with form builder
2. **Question Library** - Comprehensive question management interface
3. **Assessment Management** - Complete assessment workflow UI
4. **User Management** - Basic CRUD operations (no roles/permissions yet)

---

## 🏗️ Current Architecture Analysis

### Existing Components

**Models (13 total):**
- ✅ User, School, Instrument, InstrumentItem
- ✅ Assessment, AssessmentQuestion, AssessmentAnswer
- ✅ AssessmentAspect, AssessmentIndicator
- ✅ Response, Submission, ScaleTemplate, AnswerOption

**Services (7 total):**
- ✅ InstrumentManagementService
- ✅ AssessmentService, AssessmentWorkflowService
- ✅ InstrumentSubmissionService, SchoolService
- ✅ AnswerValidationService, ScoreCalculationService, ReportingService

**Controllers (API):**
- ✅ InstrumentController
- ✅ QuestionController
- ✅ AssessmentController, AssessmentAnswerController
- ✅ ScaleTemplateController
- ✅ ReportController

**Migrations (19 total):**
- ✅ Core tables (instruments, assessments, questions, etc.)
- ✅ Enhanced schema with relationships, soft deletes
- ✅ Assessment workflow fields

**Authentication:**
- ✅ Laravel Sanctum (API tokens)
- ✅ LoginController with session auth
- ✅ Admin user seeder

**Packages:**
- ✅ Laravel Sanctum (auth)
- ✅ Maatwebsite Excel (import/export)
- ✅ Barryvdh DomPDF (PDF generation)

---

## 🎯 Implementation Plan

---

## 1. INSTRUMENT MANAGEMENT

### Current Status
- ✅ API endpoints (8 routes)
- ✅ InstrumentManagementService
- ✅ Model with relationships
- ✅ Publishing/unpublishing functionality
- ✅ Duplication capability

### Gaps to Fill
- ❌ Admin web UI (Blade views)
- ❌ Instrument form builder
- ❌ Question management in instrument
- ❌ Advanced filtering and search
- ❌ Bulk operations

### Implementation Steps

#### 1.1 Admin Controller
**File:** `app/Http/Controllers/Admin/InstrumentController.php`

**Features:**
- Index with advanced filtering (status, category, version)
- Create/Edit instrument forms
- Instrument detail view
- Publish/Unpublish actions
- Duplicate instrument
- Manage questions in instrument
- Bulk actions (activate, deactivate, delete)
- Export instruments list

**Methods:**
```php
index() - List with filters
create() - Show create form
store(Request) - Create new instrument
show($id) - Show instrument details
edit($id) - Show edit form
update(Request, $id) - Update instrument
destroy($id) - Delete instrument
publish($id) - Publish instrument
unpublish($id) - Unpublish instrument
duplicate($id) - Duplicate instrument
export() - Export to Excel
bulkAction(Request) - Bulk operations
```

#### 1.2 Request Validation
**File:** `app/Http/Requests/InstrumentRequest.php`

**Validation Rules:**
```php
code: required|string|max:50|unique:instruments,code
name: required|string|max:255
description: nullable|string
category: nullable|string|max:100
version: nullable|string|max:20
instructions: nullable|string
estimated_duration: nullable|integer|min:1
scoring_method: nullable|in:simple_sum,weighted_sum,average,percentage,custom
is_active: nullable|boolean
```

#### 1.3 Blade Views

**Directory:** `resources/views/admin/instruments/`

**Files:**

1. **index.blade.php**
   - Data table with columns: Code, Name, Category, Version, Status, Created At, Actions
   - Filters: Status (Draft/Published), Category, Search
   - Bulk action dropdown
   - Pagination
   - Create button
   - Export button

2. **create.blade.php** & **edit.blade.php**
   - Form fields: Code, Name, Description, Category, Version
   - Instructions textarea
   - Estimated duration input
   - Scoring method select
   - Active toggle
   - Questions management section (add/remove/reorder)
   - Save/Cancel buttons

3. **show.blade.php**
   - Instrument header (code, name, version, status)
   - Description and instructions
   - Questions list (with order, question text, answer type)
   - Aspects list with weights
   - Scoring method display
   - Statistics (total questions, max score)
   - Action buttons: Edit, Duplicate, Publish/Unpublish, Delete

4. **partials/questions-manager.blade.php**
   - List of questions in instrument
   - Add question button (open modal to select from library)
   - Remove question button
   - Reorder functionality (up/down arrows)
   - Question preview with details

5. **partials/question-selector.blade.php**
   - Modal to select questions from library
   - Filters by aspect, indicator, type
   - Search input
   - Checkbox to select multiple questions
   - Add selected button

6. **partials/filters.blade.php**
   - Status filter (checkboxes)
   - Category dropdown
   - Search input
   - Apply/Reset buttons

#### 1.4 Enhanced Features

**Instrument Form Builder:**
- Add questions from library via modal
- Remove questions from instrument
- Reorder questions (up/down buttons)
- Preview instrument with all questions

**Advanced Filtering:**
- By status (draft, published)
- By category
- By version
- By creation date range

**Bulk Operations:**
- Publish multiple instruments
- Unpublish multiple instruments
- Activate/Deactivate
- Delete (with confirmation)
- Export selected

#### 1.5 Routes
**File:** `routes/web.php`

```php
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('instruments', InstrumentController::class);
    Route::post('instruments/{id}/publish', [InstrumentController::class, 'publish'])
        ->name('instruments.publish');
    Route::post('instruments/{id}/unpublish', [InstrumentController::class, 'unpublish'])
        ->name('instruments.unpublish');
    Route::post('instruments/{id}/duplicate', [InstrumentController::class, 'duplicate'])
        ->name('instruments.duplicate');
    Route::get('instruments/export', [InstrumentController::class, 'export'])
        ->name('instruments.export');
    Route::post('instruments/bulk', [InstrumentController::class, 'bulkAction'])
        ->name('instruments.bulk');
});
```

#### 1.6 Estimated Time: 3-4 days

---

## 2. QUESTION LIBRARY

### Current Status
- ✅ API endpoints (5 routes)
- ✅ QuestionController (API)
- ✅ AssessmentQuestion model with full features
- ✅ Scale template integration
- ✅ Answer types (6 types: boolean, scale, number, text, multiple_choice, percentage)
- ✅ Validation rules per question type

### Gaps to Fill
- ❌ Admin web UI (Blade views)
- ❌ Question categorization interface
- ❌ Advanced question search and filter
- ❌ Bulk import from Excel
- ❌ Question usage statistics

### Implementation Steps

#### 2.1 Admin Controller
**File:** `app/Http/Controllers/Admin/QuestionController.php`

**Features:**
- Index with filtering (aspect, indicator, answer type, status)
- Create/Edit question forms
- Question detail view
- Activate/Deactivate
- Bulk import from Excel
- Export questions
- View usage statistics (instruments using this question)

**Methods:**
```php
index() - List with filters
create() - Show create form
store(Request) - Create new question
show($id) - Show question details with usage stats
edit($id) - Show edit form
update(Request, $id) - Update question
destroy($id) - Delete question (with usage check)
activate($id) - Activate question
deactivate($id) - Deactivate question
import(Request) - Import from Excel
export() - Export to Excel
duplicate($id) - Duplicate question
```

#### 2.2 Request Validation
**File:** `app/Http/Requests/QuestionRequest.php`

**Validation Rules:**
```php
question_code: required|string|max:20|unique:assessment_questions,question_code
indicator_id: required|exists:assessment_indicators,id
question_text: required|string|max:1000
answer_type: required|in:boolean,scale,number,text,multiple_choice,percentage
weight: nullable|numeric|min:0|max:100
order: nullable|integer|min:1
help_text: nullable|string|max:500
is_required: nullable|boolean
max_score: required_if:answer_type,scale,number|numeric|min:0
min_score: required_if:answer_type,scale,number|numeric|min:0
scale_template_id: nullable|exists:scale_templates,id
answer_options: nullable|array
```

#### 2.3 Blade Views

**Directory:** `resources/views/admin/questions/`

**Files:**

1. **index.blade.php**
   - Filters: Aspect, Indicator, Answer Type, Status, Search
   - Data table with columns: Code, Question, Type, Aspect, Indicator, Status, Usage Count, Actions
   - Pagination
   - Create button
   - Import/Export buttons
   - Bulk actions dropdown

2. **create.blade.php** & **edit.blade.php**
   - Question code input
   - Question text textarea
   - Indicator dropdown (cascading with aspect)
   - Answer type select
   - Weight input
   - Order input
   - Help text textarea
   - Required toggle
   - Score range (min/max) - conditional based on type
   - Scale template selector - conditional for scale type
   - Answer options editor - for multiple_choice
   - Save/Cancel buttons

3. **show.blade.php**
   - Question header (code, text, status)
   - Question details (type, weight, indicator, aspect)
   - Answer options display
   - Validation rules preview
   - Usage statistics (instruments count, assessments count)
   - Action buttons: Edit, Duplicate, Activate/Deactivate, Delete

4. **partials/answer-options-editor.blade.php**
   - Add option button
   - Option rows (value, label, score)
   - Remove option button
   - Preview section

5. **partials/scale-template-selector.blade.php**
   - Template dropdown
   - Template preview (showing labels for 1-5 scale)
   - Custom scale option

6. **partials/usage-stats.blade.php**
   - Instruments using this question
   - Total assessments answered
   - Average score (if applicable)
   - Recent activity

7. **import.blade.php**
   - File upload (Excel/CSV)
   - Template download
   - Import preview
   - Import button

#### 2.4 Question Import Service
**File:** `app/Services/QuestionImportService.php`

**Features:**
- Parse Excel file with questions
- Validate data
- Handle multiple questions in batch
- Create indicators/aspects if they don't exist
- Import error reporting

**Excel Format:**
```
Code | Question Text | Indicator | Aspect | Answer Type | Weight | Required | Min Score | Max Score
```

#### 2.5 Enhanced Features

**Advanced Search:**
- Full-text search in question text
- Filter by aspect, indicator
- Filter by answer type
- Filter by status (active/inactive)
- Filter by usage (unused, used)

**Question Duplication:**
- Clone question with auto-generated code
- Option to modify before saving

**Usage Statistics:**
- Count instruments using this question
- Count assessments with answers
- Last used date

**Bulk Operations:**
- Activate/Deactivate multiple questions
- Delete unused questions
- Export selected questions

#### 2.6 Routes
**File:** `routes/web.php`

```php
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('questions', QuestionController::class);
    Route::post('questions/{id}/activate', [QuestionController::class, 'activate'])
        ->name('questions.activate');
    Route::post('questions/{id}/deactivate', [QuestionController::class, 'deactivate'])
        ->name('questions.deactivate');
    Route::post('questions/{id}/duplicate', [QuestionController::class, 'duplicate'])
        ->name('questions.duplicate');
    Route::get('questions/import', [QuestionController::class, 'showImport'])
        ->name('questions.import');
    Route::post('questions/import', [QuestionController::class, 'import'])
        ->name('questions.import.store');
    Route::get('questions/export', [QuestionController::class, 'export'])
        ->name('questions.export');
    Route::post('questions/bulk', [QuestionController::class, 'bulkAction'])
        ->name('questions.bulk');
});
```

#### 2.7 Estimated Time: 3-4 days

---

## 3. ASSESSMENT MANAGEMENT

### Current Status
- ✅ API endpoints (13 routes)
- ✅ AssessmentController (API)
- ✅ Assessment model with workflow fields
- ✅ AssessmentAnswerController for answers
- ✅ AssessmentService, AssessmentWorkflowService
- ✅ Score calculation service
- ✅ Status workflow (draft, in_progress, submitted, verified, approved, rejected)

### Gaps to Fill
- ❌ Admin web UI (Blade views)
- ❌ Assessment creation wizard
- ❌ Answer management interface
- ❌ Review and verification workflow UI
- ❌ Score visualization
- ❌ Bulk operations

### Implementation Steps

#### 3.1 Admin Controller
**File:** `app/Http/Controllers/Admin/AssessmentController.php`

**Features:**
- Index with advanced filtering (status, school, instrument, date range)
- Create assessment wizard (select school, instrument, period)
- Assessment detail view with all answers
- Edit assessment metadata
- View and edit answers
- Submit, Verify, Approve, Reject actions
- Recalculate scores
- View score breakdown by aspect
- Export assessment report (PDF)
- Bulk operations (approve, reject, delete)

**Methods:**
```php
index() - List with filters
create() - Show create form (wizard step 1: select school/instrument)
store(Request) - Create assessment
show($id) - Show assessment details with scores and answers
edit($id) - Show edit form (metadata only)
update(Request, $id) - Update assessment metadata
destroy($id) - Delete assessment
submit($id) - Submit assessment
verify($id) - Verify assessment
approve($id) - Approve assessment
reject(Request, $id) - Reject assessment with reason
recalculateScores($id) - Recalculate all scores
export($id) - Export PDF report
bulkAction(Request) - Bulk operations
getAnswers($id) - Get all answers for assessment
updateAnswer(Request, $id, $answerId) - Update specific answer
```

#### 3.2 Assessment Answer Management
**File:** `app/Http/Controllers/Admin/AssessmentAnswerController.php`

**Features:**
- List all answers for an assessment
- View/edit individual answer
- Validate answer
- Bulk update answers

**Methods:**
```php
index($assessmentId) - List answers
store(Request, $assessmentId) - Create answer
show($assessmentId, $answerId) - Show answer
update(Request, $assessmentId, $answerId) - Update answer
destroy($assessmentId, $answerId) - Delete answer
validate($assessmentId, $answerId) - Validate answer
```

#### 3.3 Request Validation
**File:** `app/Http/Requests/AssessmentRequest.php`

**Validation Rules:**
```php
school_id: required|exists:schools,id
instrument_id: required|exists:instruments,id
period_year: required|string|max:20
semester: nullable|in:1,2
assessment_type: nullable|string|max:50
remarks: nullable|string|max:1000
metadata: nullable|array
```

**File:** `app/Http/Requests/AssessmentAnswerRequest.php`

**Validation Rules:**
```php
question_id: required|exists:assessment_questions,id
answer: required
```

#### 3.4 Blade Views

**Directory:** `resources/views/admin/assessments/`

**Files:**

1. **index.blade.php**
   - Filters: Status, School, Instrument, Date Range, Academic Year, Semester
   - Data table with columns: ID, School, Instrument, Period, Status, Score, Grade, Date, Actions
   - Status badges (draft, submitted, verified, approved, rejected)
   - Score display with color coding
   - Pagination
   - Create button
   - Bulk actions dropdown
   - Export button

2. **create.blade.php** (Wizard)
   - Step 1: Select school (searchable dropdown)
   - Step 2: Select instrument
   - Step 3: Set period (academic year, semester)
   - Step 4: Review and create
   - Progress indicator
   - Back/Next/Cancel buttons

3. **show.blade.php**
   - Assessment header: School, Instrument, Period, Status, Grade, Score
   - Status badge
   - Score visualization (gauge chart)
   - Tabs: Details, Answers, Scores, History

   **Details Tab:**
   - School information
   - Instrument information
   - Assessment metadata
   - Completion statistics
   - Time tracking

   **Answers Tab:**
   - Grouped by aspect/section
   - Each question with current answer
   - Edit answer button
   - Validation status
   - Progress bar (answered/total)

   **Scores Tab:**
   - Overall score
   - Score breakdown by aspect
   - Aspect comparison (radar chart)
   - Indicator scores

   **History Tab:**
   - Audit trail (created, submitted, verified, approved)
   - User actions with timestamps
   - Notes and remarks

   - Action buttons based on status:
     - Draft: Submit, Edit
     - Submitted: Verify, Return
     - Verified: Approve, Reject
     - Approved: View only, Export
     - Rejected: View only, Resubmit

4. **edit.blade.php**
   - Editable metadata fields
   - Period, type, remarks
   - Read-only: school, instrument, scores

5. **answer-form.blade.php** (for answering questions)
   - Progress indicator
   - Sections based on instrument
   - Question cards with:
     - Question text
     - Help text
     - Answer input (based on type: checkbox, radio, text, number)
     - Validation messages
   - Save draft / Submit buttons
   - Navigation (Next/Previous question)

6. **partials/score-breakdown.blade.php**
   - Aspect list with scores
   - Visual progress bars
   - Color coding (green: good, yellow: warning, red: poor)
   - Percentage display

7. **partials/status-badge.blade.php**
   - Status badge with appropriate color
   - Draft (gray), Submitted (blue), Verified (purple), Approved (green), Rejected (red)

8. **partials/actions.blade.php**
   - Context-aware action buttons
   - Based on assessment status

9. **partials/filters.blade.php**
   - Status checkboxes
   - School dropdown (searchable)
   - Instrument dropdown
   - Date range picker
   - Academic year/semester filters
   - Apply/Reset buttons

10. **reject-modal.blade.php**
    - Rejection reason textarea
    - Reject/Cancel buttons

#### 3.5 Assessment Workflow UI

**Status Transitions:**
```
Draft → Submitted → Verified → Approved
                    ↓
                 Rejected
                    ↓
                  Draft (after resubmit)
```

**Workflow Actions:**
- **Submit:** Validates all answers, marks as submitted
- **Verify:** Verifies answers, marks as verified
- **Approve:** Final approval, calculates final grade
- **Reject:** Returns to draft with rejection reason
- **Recalculate:** Recomputes all scores manually

#### 3.6 Score Visualization

**Visual Elements:**
- Overall score gauge (0-100)
- Aspect breakdown (bar charts)
- Aspect comparison radar chart
- Indicator-level scores
- Trend analysis (if multiple assessments for school)

**Chart Library:** Chart.js

#### 3.7 Bulk Operations

**Bulk Actions:**
- Approve multiple assessments
- Reject multiple assessments
- Delete multiple assessments
- Export multiple assessments

#### 3.8 Routes
**File:** `routes/web.php`

```php
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('assessments', AssessmentController::class);
    Route::post('assessments/{id}/submit', [AssessmentController::class, 'submit'])
        ->name('assessments.submit');
    Route::post('assessments/{id}/verify', [AssessmentController::class, 'verify'])
        ->name('assessments.verify');
    Route::post('assessments/{id}/approve', [AssessmentController::class, 'approve'])
        ->name('assessments.approve');
    Route::post('assessments/{id}/reject', [AssessmentController::class, 'reject'])
        ->name('assessments.reject');
    Route::post('assessments/{id}/recalculate', [AssessmentController::class, 'recalculateScores'])
        ->name('assessments.recalculate');
    Route::get('assessments/{id}/export', [AssessmentController::class, 'export'])
        ->name('assessments.export');
    Route::post('assessments/bulk', [AssessmentController::class, 'bulkAction'])
        ->name('assessments.bulk');

    Route::prefix('assessments/{assessmentId}/answers')->name('assessments.answers.')->group(function () {
        Route::get('/', [AssessmentAnswerController::class, 'index'])
            ->name('index');
        Route::get('/answer', [AssessmentAnswerController::class, 'answer'])
            ->name('form');
        Route::post('/', [AssessmentAnswerController::class, 'store'])
            ->name('store');
        Route::get('/{answerId}', [AssessmentAnswerController::class, 'show'])
            ->name('show');
        Route::put('/{answerId}', [AssessmentAnswerController::class, 'update'])
            ->name('update');
        Route::delete('/{answerId}', [AssessmentAnswerController::class, 'destroy'])
            ->name('destroy');
        Route::post('/{answerId}/validate', [AssessmentAnswerController::class, 'validate'])
            ->name('validate');
    });
});
```

#### 3.9 Estimated Time: 5-6 days

---

## 4. USER MANAGEMENT

### Current Status
- ✅ User model with basic fields (name, email, password)
- ✅ Laravel Sanctum (API tokens)
- ✅ Authentication system (login/logout)
- ✅ AdminUserSeeder
- ✅ Basic user authentication

### Gaps to Fill
- ❌ Admin web UI (Blade views)
- ❌ User CRUD operations
- ❌ Password reset functionality
- ❌ User activation/deactivation
- ❌ Profile management
- ❌ Activity tracking

### Implementation Steps

#### 4.1 Database Migration
**File:** `database/migrations/XXXX_XX_XX_000000_add_user_fields.php`

**New Fields:**
```php
$table->string('phone')->nullable()->after('email');
$table->boolean('is_active')->default(true)->after('remember_token');
$table->timestamp('last_login_at')->nullable()->after('is_active');
$table->text('bio')->nullable()->after('last_login_at');
$table->string('role')->default('user')->after('bio'); // Basic role for now
```

**Role Options (basic, no permissions):**
- admin
- user

#### 4.2 Admin Controller
**File:** `app/Http/Controllers/Admin/UserController.php`

**Features:**
- Index with search and filter
- Create new user
- Edit user profile
- Change user password
- Activate/Deactivate user
- Delete user (soft delete)
- View user details
- User activity log

**Methods:**
```php
index() - List users with filters
create() - Show create form
store(Request) - Create new user
show($id) - Show user details
edit($id) - Show edit form
update(Request, $id) - Update user
destroy($id) - Delete user
activate($id) - Activate user
deactivate($id) - Deactivate user
changePassword(Request, $id) - Change user password
profile($id) - Show user profile
updateProfile(Request, $id) - Update user profile
activity($id) - Show user activity log
```

#### 4.3 Request Validation
**File:** `app/Http/Requests/UserRequest.php`

**Validation Rules:**
```php
name: required|string|max:255
email: required|email|unique:users,email
password: required|min:8|confirmed
phone: nullable|string|max:20
is_active: nullable|boolean
role: nullable|in:admin,user
bio: nullable|string|max:500
```

**File:** `app/Http/Requests/PasswordChangeRequest.php`

**Validation Rules:**
```php
current_password: required|current_password
password: required|min:8|confirmed
```

#### 4.4 Blade Views

**Directory:** `resources/views/admin/users/`

**Files:**

1. **index.blade.php**
   - Search input
   - Filters: Role, Status (Active/Inactive)
   - Data table with columns: Name, Email, Phone, Role, Status, Last Login, Actions
   - Status badge (Active/Inactive)
   - Pagination
   - Create button
   - Bulk actions dropdown

2. **create.blade.php** & **edit.blade.php**
   - Name input
   - Email input
   - Password input (create only) with confirm
   - Phone input
   - Role select (admin/user)
   - Active toggle
   - Bio textarea
   - Save/Cancel buttons

3. **show.blade.php**
   - User profile card: Name, Email, Phone, Role
   - Status badge
   - User details
   - Last login timestamp
   - Account creation date
   - Activity summary (login count, assessments created, etc.)
   - Action buttons: Edit, Change Password, Activate/Deactivate, Delete

4. **partials/change-password.blade.php**
   - Current password input
   - New password input
   - Confirm password input
   - Save/Cancel buttons
   - Password strength indicator

5. **partials/activity-log.blade.php**
   - Activity table: Date, Action, IP Address
   - Pagination
   - Filter by date range

6. **partials/filters.blade.php**
   - Search input
   - Role dropdown
   - Status checkboxes
   - Apply/Reset buttons

#### 4.5 Password Reset System

**Controller:** `app/Http/Controllers/Auth/ForgotPasswordController.php`

**Features:**
- Forgot password form
- Email with reset link
- Reset password form
- Token validation
- Expire after 1 hour

**Views:**
- `resources/views/auth/forgot-password.blade.php`
- `resources/views/auth/reset-password.blade.php`

**Routes:**
```php
Route::middleware(['guest'])->prefix('password')->group(function () {
    Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');
    Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    Route::get('reset/{token}', [ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('reset', [ForgotPasswordController::class, 'reset'])
        ->name('password.update');
});
```

#### 4.6 Activity Logging

**Model:** `app/Models/ActivityLog.php`

**Migration:**
```php
$table->id();
$table->foreignId('user_id')->constrained()->onDelete('cascade');
$table->string('action');
$table->string('model_type')->nullable();
$table->unsignedBigInteger('model_id')->nullable();
$table->text('description')->nullable();
$table->ipAddress('ip_address')->nullable();
$table->text('user_agent')->nullable();
$table->json('old_values')->nullable();
$table->json('new_values')->nullable();
$table->timestamps();
```

**Log Activities:**
- User login/logout
- User created/updated/deleted
- Assessment created/updated/deleted
- Instrument created/updated/deleted
- Question created/updated/deleted
- School created/updated/deleted

#### 4.7 Enhanced Features

**User Search:**
- Full-text search by name, email
- Filter by role (admin, user)
- Filter by status (active, inactive)
- Filter by last login date

**Bulk Operations:**
- Activate multiple users
- Deactivate multiple users
- Delete multiple users
- Send password reset to multiple users

**User Statistics:**
- Total users
- Active users
- New users this month
- Users by role

#### 4.8 Routes
**File:** `routes/web.php`

```php
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::post('users/{id}/activate', [UserController::class, 'activate'])
        ->name('users.activate');
    Route::post('users/{id}/deactivate', [UserController::class, 'deactivate'])
        ->name('users.deactivate');
    Route::post('users/{id}/password', [UserController::class, 'changePassword'])
        ->name('users.password');
    Route::get('users/{id}/activity', [UserController::class, 'activity'])
        ->name('users.activity');
    Route::post('users/bulk', [UserController::class, 'bulkAction'])
        ->name('users.bulk');
});
```

#### 4.9 Estimated Time: 2-3 days

---

## 🗂️ Directory Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── InstrumentController.php     (NEW)
│   │   │   ├── QuestionController.php       (NEW)
│   │   │   ├── AssessmentController.php    (NEW)
│   │   │   ├── AssessmentAnswerController.php (NEW)
│   │   │   └── UserController.php          (NEW)
│   │   └── Auth/
│   │       └── ForgotPasswordController.php (NEW)
│   └── Requests/
│       ├── InstrumentRequest.php          (NEW)
│       ├── QuestionRequest.php            (NEW)
│       ├── AssessmentRequest.php          (NEW)
│       ├── AssessmentAnswerRequest.php    (NEW)
│       ├── UserRequest.php                (NEW)
│       └── PasswordChangeRequest.php       (NEW)
├── Services/
│   ├── QuestionImportService.php           (NEW)
│   └── ActivityLogService.php             (NEW)
├── Models/
│   ├── ActivityLog.php                    (NEW)
│   └── User.php                           (UPDATE)
└── Repositories/
    ├── InstrumentRepository.php           (UPDATE)
    ├── QuestionRepository.php             (NEW)
    ├── AssessmentRepository.php           (NEW)
    └── UserRepository.php                 (NEW)

resources/
└── views/
    └── admin/
        ├── instruments/
        │   ├── index.blade.php            (NEW)
        │   ├── create.blade.php           (NEW)
        │   ├── edit.blade.php             (NEW)
        │   ├── show.blade.php             (NEW)
        │   └── partials/
        │       ├── questions-manager.blade.php (NEW)
        │       ├── question-selector.blade.php (NEW)
        │       └── filters.blade.php      (NEW)
        ├── questions/
        │   ├── index.blade.php            (NEW)
        │   ├── create.blade.php           (NEW)
        │   ├── edit.blade.php             (NEW)
        │   ├── show.blade.php             (NEW)
        │   ├── import.blade.php           (NEW)
        │   └── partials/
        │       ├── answer-options-editor.blade.php (NEW)
        │       ├── scale-template-selector.blade.php (NEW)
        │       ├── usage-stats.blade.php (NEW)
        │       └── filters.blade.php      (NEW)
        ├── assessments/
        │   ├── index.blade.php            (NEW)
        │   ├── create.blade.php           (NEW)
        │   ├── edit.blade.php             (NEW)
        │   ├── show.blade.php             (NEW)
        │   ├── answer-form.blade.php      (NEW)
        │   └── partials/
        │       ├── score-breakdown.blade.php (NEW)
        │       ├── status-badge.blade.php (NEW)
        │       ├── actions.blade.php      (NEW)
        │       ├── filters.blade.php      (NEW)
        │       └── reject-modal.blade.php (NEW)
        ├── users/
        │   ├── index.blade.php            (NEW)
        │   ├── create.blade.php           (NEW)
        │   ├── edit.blade.php             (NEW)
        │   ├── show.blade.php             (NEW)
        │   └── partials/
        │       ├── change-password.blade.php (NEW)
        │       ├── activity-log.blade.php (NEW)
        │       └── filters.blade.php      (NEW)
        └── auth/
            ├── forgot-password.blade.php   (NEW)
            └── reset-password.blade.php   (NEW)

database/
└── migrations/
    └── XXXX_XX_XX_000000_add_user_fields.php (NEW)
    └── XXXX_XX_XX_000000_create_activity_logs_table.php (NEW)
```

---

## 📊 Summary

### Files to Create: ~50-60 files
- Controllers: 5
- Request classes: 6
- Services: 2
- Models: 1
- Repositories: 3
- Blade views: ~30
- Migrations: 2

### Estimated Total Time: 13-17 days (3-4 weeks)

### Time Breakdown:
1. **Instrument Management:** 3-4 days
2. **Question Library:** 3-4 days
3. **Assessment Management:** 5-6 days
4. **User Management:** 2-3 days

---

## 🚀 Implementation Order

### Week 1: User Management + Basic Infrastructure
- Day 1-2: User Management (easiest to implement)
- Day 3: Activity logging system
- Day 4: Basic layout and navigation
- Day 5: Testing and refinement

### Week 2: Question Library
- Day 1-2: Question CRUD operations
- Day 3: Question import/export
- Day 4: Advanced features
- Day 5: Testing and refinement

### Week 3: Instrument Management
- Day 1-2: Instrument CRUD operations
- Day 3: Questions management in instrument
- Day 4: Advanced features
- Day 5: Testing and refinement

### Week 4: Assessment Management (Most Complex)
- Day 1-2: Assessment CRUD operations
- Day 3: Answer management
- Day 4: Workflow and score visualization
- Day 5: Testing and refinement

---

## 📋 Prerequisites

Before starting implementation:

1. **Database Migration:**
   - Run all existing migrations
   - Create user fields migration
   - Create activity logs migration

2. **Dependencies:**
   - Maatwebsite Excel (already installed)
   - Barryvdh DomPDF (already installed)
   - Chart.js for visualizations

3. **Configuration:**
   - Update .env with email settings (for password reset)
   - Configure session settings

4. **Testing:**
   - Create test data
   - Seed database with sample data

---

## ✅ Acceptance Criteria

### Instrument Management
- [ ] Can list all instruments with filtering
- [ ] Can create new instrument
- [ ] Can edit instrument details
- [ ] Can view instrument details
- [ ] Can publish/unpublish instrument
- [ ] Can duplicate instrument
- [ ] Can delete instrument
- [ ] Can export instruments to Excel
- [ ] Can perform bulk operations
- [ ] Can add/remove questions from instrument
- [ ] Can reorder questions

### Question Library
- [ ] Can list all questions with filtering
- [ ] Can create new question
- [ ] Can edit question details
- [ ] Can view question details with usage stats
- [ ] Can activate/deactivate question
- [ ] Can delete question (with usage check)
- [ ] Can import questions from Excel
- [ ] Can export questions to Excel
- [ ] Can duplicate question
- [ ] Can configure answer options
- [ ] Can view question usage statistics

### Assessment Management
- [ ] Can list all assessments with filtering
- [ ] Can create new assessment (wizard)
- [ ] Can view assessment details
- [ ] Can edit assessment metadata
- [ ] Can answer assessment questions
- [ ] Can submit assessment
- [ ] Can verify assessment
- [ ] Can approve/reject assessment
- [ ] Can view score breakdown
- [ ] Can export assessment report
- [ ] Can perform bulk operations
- [ ] Can recalculate scores
- [ ] Can track assessment workflow

### User Management
- [ ] Can list all users with filtering
- [ ] Can create new user
- [ ] Can edit user profile
- [ ] Can change user password
- [ ] Can view user details
- [ ] Can activate/deactivate user
- [ ] Can delete user
- [ ] Can send password reset
- [ ] Can view user activity log

---

## 🔧 Technical Considerations

### Code Style
- Follow Laravel conventions
- Use Service-Repository pattern
- Implement Request validation
- Use Blade components for reusable UI

### Security
- Validate all inputs
- Use CSRF protection
- Implement proper authorization (basic middleware)
- Hash passwords

### Performance
- Use eager loading
- Implement pagination
- Cache frequently accessed data
- Optimize database queries

### User Experience
- Responsive design (mobile-friendly)
- Intuitive navigation
- Clear error messages
- Loading indicators
- Confirmation dialogs

---

## 📝 Notes

1. **No File Uploads:** All file upload features removed (no avatar uploads, no file answer types, no attachment uploads).

2. **No Roles/Permissions:** User management will have basic roles (admin, user) but no granular permissions system at this stage. This can be added later with Spatie Permission package.

3. **Chart.js Integration:** For score visualization, we'll use Chart.js library. Include via CDN in layout.

4. **Question Management in Instrument:** Use modal-based question selector from library, with up/down buttons for reordering (no drag-drop for now).

5. **Answer Types:** Limited to 6 types (boolean, scale, number, text, multiple_choice, percentage) - removed "file" type.

6. **Email Configuration:** Password reset requires proper email configuration in .env file.

---

## 🎯 Success Metrics

- All 4 features fully functional
- Clean, maintainable code
- User-friendly interfaces
- Comprehensive error handling
- Responsive design
- Proper validation
- Security best practices
- Well-documented code

---

**Document Version:** 2.0
**Created:** February 5, 2026
**Updated:** February 5, 2026 (Removed all file upload features)
**Status:** Ready for Implementation
