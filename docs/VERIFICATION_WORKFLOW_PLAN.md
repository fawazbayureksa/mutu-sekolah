# Verification Workflow Implementation Plan

## Overview

Implement a multi-stage verification workflow for instrument submissions from schools.

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│   SCHOOL        │     │   VERIFIER      │     │   ADMIN         │     │   RELEASED      │
│   Input Form    │ ──► │   Verification  │ ──► │   Validation    │ ──► │   Analytics     │
│                 │     │                 │     │   (BPPMPV KPTK) │     │                 │
└─────────────────┘     └─────────────────┘     └─────────────────┘     └─────────────────┘
     Status:                 Status:                 Status:                 Status:
     "submitted"            "verified"              "validated"             "released"
```

---

## Current State vs Target State

### Current State ✓
- [x] Schools can input instrument data via public form
- [x] Admin accounts exist
- [x] Submission list view exists (`admin/submissions/index`)
- [x] User management exists

### Target State 🎯
- [ ] Verifier role for initial verification
- [ ] Verification UI for verifier users
- [ ] Validation UI for admin (BPPMPV KPTK)
- [ ] Release mechanism for validated data
- [ ] Analytics access for released data
- [ ] Hide assessment feature temporarily

---

## Phase 1: Database & Model Updates

### 1.1 Update Submission Status Flow

**File:** `database/migrations/xxxx_update_submissions_status.php`

```php
// Add new status values and tracking fields
Schema::table('submissions', function (Blueprint $table) {
    // Update status enum: submitted -> verified -> validated -> released -> rejected
    $table->string('status')->default('submitted')->change();
    
    // Verification tracking
    $table->unsignedBigInteger('verified_by')->nullable();
    $table->timestamp('verified_at')->nullable();
    $table->text('verification_notes')->nullable();
    
    // Validation tracking (admin)
    $table->unsignedBigInteger('validated_by')->nullable();
    $table->timestamp('validated_at')->nullable();
    $table->text('validation_notes')->nullable();
    
    // Release tracking
    $table->unsignedBigInteger('released_by')->nullable();
    $table->timestamp('released_at')->nullable();
    
    // Foreign keys
    $table->foreign('verified_by')->references('id')->on('users')->nullOnDelete();
    $table->foreign('validated_by')->references('id')->on('users')->nullOnDelete();
    $table->foreign('released_by')->references('id')->on('users')->nullOnDelete();
});
```

### 1.2 Add Verifier Role

**File:** `database/seeders/RoleSeeder.php`

```php
// Add 'verifier' role alongside existing roles
$roles = ['admin', 'verifier', 'school'];
```

### 1.3 Update Submission Model

**File:** `app/Models/Submission.php`

```php
// Add status constants
const STATUS_SUBMITTED = 'submitted';
const STATUS_VERIFIED = 'verified';
const STATUS_VALIDATED = 'validated';
const STATUS_RELEASED = 'released';
const STATUS_REJECTED = 'rejected';

// Add relationships
public function verifier(): BelongsTo
{
    return $this->belongsTo(User::class, 'verified_by');
}

public function validator(): BelongsTo
{
    return $this->belongsTo(User::class, 'validated_by');
}

public function releaser(): BelongsTo
{
    return $this->belongsTo(User::class, 'released_by');
}

// Add scope methods
public function scopePendingVerification($query)
{
    return $query->where('status', self::STATUS_SUBMITTED);
}

public function scopePendingValidation($query)
{
    return $query->where('status', self::STATUS_VERIFIED);
}

public function scopeReleased($query)
{
    return $query->where('status', self::STATUS_RELEASED);
}
```

---

## Phase 2: Role & Permission Setup

### 2.1 User Roles Structure

| Role | Description | Permissions |
|------|-------------|-------------|
| `admin` | BPPMPV KPTK Administrator | Full access, validate submissions, release data |
| `verifier` | Verification Officer | View & verify submitted data |
| `school` | School User | Submit instruments, view own submissions |

### 2.2 Create Middleware

**File:** `app/Http/Middleware/CheckRole.php`

```php
public function handle($request, Closure $next, ...$roles)
{
    if (!auth()->check()) {
        return redirect('login');
    }
    
    if (!in_array(auth()->user()->role, $roles)) {
        abort(403, 'Unauthorized');
    }
    
    return $next($request);
}
```

### 2.3 Register Middleware

**File:** `app/Http/Kernel.php`

```php
protected $middlewareAliases = [
    // ...
    'role' => \App\Http\Middleware\CheckRole::class,
];
```

---

## Phase 3: Verifier Module

### 3.1 Routes

**File:** `routes/web.php`

```php
// Verifier routes
Route::prefix('verifier')->middleware(['auth', 'role:verifier'])->name('verifier.')->group(function () {
    Route::get('/dashboard', [VerifierDashboardController::class, 'index'])->name('dashboard');
    Route::get('/submissions', [VerifierSubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/{submission}', [VerifierSubmissionController::class, 'show'])->name('submissions.show');
    Route::post('/submissions/{submission}/verify', [VerifierSubmissionController::class, 'verify'])->name('submissions.verify');
    Route::post('/submissions/{submission}/reject', [VerifierSubmissionController::class, 'reject'])->name('submissions.reject');
});
```

### 3.2 Controller

**File:** `app/Http/Controllers/Verifier/VerifierSubmissionController.php`

```php
class VerifierSubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::with(['school', 'instrument'])
            ->pendingVerification()
            ->latest()
            ->paginate(15);
            
        return view('verifier.submissions.index', compact('submissions'));
    }
    
    public function show(Submission $submission)
    {
        $submission->load(['school', 'instrument', 'responses.instrumentItem']);
        return view('verifier.submissions.show', compact('submission'));
    }
    
    public function verify(Request $request, Submission $submission)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000'
        ]);
        
        $submission->update([
            'status' => Submission::STATUS_VERIFIED,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'verification_notes' => $request->notes,
        ]);
        
        return redirect()->route('verifier.submissions.index')
            ->with('success', 'Submission berhasil diverifikasi');
    }
    
    public function reject(Request $request, Submission $submission)
    {
        $request->validate([
            'notes' => 'required|string|max:1000'
        ]);
        
        $submission->update([
            'status' => Submission::STATUS_REJECTED,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'verification_notes' => $request->notes,
        ]);
        
        return redirect()->route('verifier.submissions.index')
            ->with('success', 'Pengajuan Ditolak');
    }
}
```

### 3.3 Views Structure

```
resources/views/verifier/
├── layouts/
│   └── verifier.blade.php       # Verifier layout (similar to admin)
├── dashboard.blade.php          # Verifier dashboard
└── submissions/
    ├── index.blade.php          # List pending verifications
    └── show.blade.php           # Detail view with verify/reject buttons
```

---

## Phase 4: Admin Validation Module

### 4.1 Update Admin Routes

**File:** `routes/web.php`

```php
// Add validation routes to admin group
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    // Existing routes...
    
    // Validation routes
    Route::get('/validations', [AdminValidationController::class, 'index'])->name('validations.index');
    Route::get('/validations/{submission}', [AdminValidationController::class, 'show'])->name('validations.show');
    Route::post('/validations/{submission}/validate', [AdminValidationController::class, 'validate'])->name('validations.validate');
    Route::post('/validations/{submission}/reject', [AdminValidationController::class, 'reject'])->name('validations.reject');
    Route::post('/validations/{submission}/release', [AdminValidationController::class, 'release'])->name('validations.release');
    
    // Bulk release
    Route::post('/validations/bulk-release', [AdminValidationController::class, 'bulkRelease'])->name('validations.bulk-release');
});
```

### 4.2 Admin Validation Controller

**File:** `app/Http/Controllers/Admin/AdminValidationController.php`

```php
class AdminValidationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'verified');
        
        $submissions = Submission::with(['school', 'instrument', 'verifier'])
            ->when($status === 'verified', fn($q) => $q->pendingValidation())
            ->when($status === 'validated', fn($q) => $q->where('status', 'validated'))
            ->when($status === 'released', fn($q) => $q->released())
            ->latest()
            ->paginate(15);
            
        return view('admin.validations.index', compact('submissions', 'status'));
    }
    
    public function validate(Request $request, Submission $submission)
    {
        $request->validate(['notes' => 'nullable|string']);
        
        $submission->update([
            'status' => Submission::STATUS_VALIDATED,
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'validation_notes' => $request->notes,
        ]);
        
        return back()->with('success', 'Data berhasil divalidasi');
    }
    
    public function release(Submission $submission)
    {
        $submission->update([
            'status' => Submission::STATUS_RELEASED,
            'released_by' => auth()->id(),
            'released_at' => now(),
        ]);
        
        return back()->with('success', 'Data berhasil dirilis untuk analytics');
    }
    
    public function bulkRelease(Request $request)
    {
        $request->validate([
            'submission_ids' => 'required|array',
            'submission_ids.*' => 'exists:submissions,id'
        ]);
        
        Submission::whereIn('id', $request->submission_ids)
            ->where('status', Submission::STATUS_VALIDATED)
            ->update([
                'status' => Submission::STATUS_RELEASED,
                'released_by' => auth()->id(),
                'released_at' => now(),
            ]);
            
        return back()->with('success', count($request->submission_ids) . ' data berhasil dirilis');
    }
}
```

### 4.3 Admin Views Structure

```
resources/views/admin/validations/
├── index.blade.php              # List submissions by status (tabs)
└── show.blade.php               # Detail with validate/reject/release buttons
```

### 4.4 Update Admin Sidebar

**File:** `resources/views/layouts/admin.blade.php`

Add new menu item for validations:

```html
<li class="sidebar-menu-item">
    <a href="{{ route('admin.validations.index') }}"
        class="sidebar-menu-link {{ request()->is('admin/validations*') ? 'active' : '' }}">
        <i class="bi bi-check2-square"></i>
        <span>Validasi Data</span>
    </a>
</li>
```

---

## Phase 5: Update Submission Detail View

### 5.1 Admin Submission Show with Status Actions

**File:** `resources/views/admin/submissions/show.blade.php`

```html
<!-- Status Badge & Timeline -->
<div class="card mb-4">
    <div class="card-header">
        <h5>Status Workflow</h5>
    </div>
    <div class="card-body">
        <!-- Status Progress Bar -->
        <div class="progress-workflow mb-4">
            <div class="step {{ $submission->status !== 'rejected' ? 'completed' : '' }}">
                <i class="bi bi-upload"></i>
                <span>Submitted</span>
                <small>{{ $submission->filled_at?->format('d M Y H:i') }}</small>
            </div>
            <div class="step {{ in_array($submission->status, ['verified', 'validated', 'released']) ? 'completed' : '' }}">
                <i class="bi bi-check-circle"></i>
                <span>Verified</span>
                <small>{{ $submission->verified_at?->format('d M Y H:i') }}</small>
            </div>
            <div class="step {{ in_array($submission->status, ['validated', 'released']) ? 'completed' : '' }}">
                <i class="bi bi-shield-check"></i>
                <span>Validated</span>
                <small>{{ $submission->validated_at?->format('d M Y H:i') }}</small>
            </div>
            <div class="step {{ $submission->status === 'released' ? 'completed' : '' }}">
                <i class="bi bi-broadcast"></i>
                <span>Released</span>
                <small>{{ $submission->released_at?->format('d M Y H:i') }}</small>
            </div>
        </div>
        
        <!-- Action Buttons based on current status -->
        @if($submission->status === 'submitted')
            <div class="alert alert-info">
                Menunggu verifikasi dari verifier
            </div>
        @elseif($submission->status === 'verified')
            <form action="{{ route('admin.validations.validate', $submission) }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-success">
                    <i class="bi bi-check-lg"></i> Validasi
                </button>
            </form>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                <i class="bi bi-x-lg"></i> Tolak
            </button>
        @elseif($submission->status === 'validated')
            <form action="{{ route('admin.validations.release', $submission) }}" method="POST" class="d-inline">
                @csrf
                <button class="btn btn-primary">
                    <i class="bi bi-broadcast"></i> Release untuk Analytics
                </button>
            </form>
        @elseif($submission->status === 'released')
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> Data sudah dirilis dan tersedia di Analytics
            </div>
        @endif
    </div>
</div>

<!-- Response Data Table -->
<div class="card">
    <div class="card-header">
        <h5>Data Jawaban</h5>
    </div>
    <div class="card-body">
        @foreach($submission->responses as $response)
            <!-- Display response data including table/structure type -->
        @endforeach
    </div>
</div>
```

---

## Phase 6: Analytics Module (Released Data Only)

### 6.1 Analytics Controller

**File:** `app/Http/Controllers/Admin/AnalyticsController.php`

```php
class AnalyticsController extends Controller
{
    public function index()
    {
        // Only show released submissions
        $stats = [
            'total_released' => Submission::released()->count(),
            'total_schools' => Submission::released()->distinct('school_id')->count('school_id'),
            'by_instrument' => Submission::released()
                ->selectRaw('instrument_id, count(*) as count')
                ->groupBy('instrument_id')
                ->with('instrument')
                ->get(),
        ];
        
        return view('admin.analytics.index', compact('stats'));
    }
    
    public function export(Request $request)
    {
        // Export only released data
        return Excel::download(
            new ReleasedSubmissionsExport($request->all()),
            'released_data_' . now()->format('Ymd') . '.xlsx'
        );
    }
}
```

---

## Phase 7: Hide Assessment Feature

### 7.1 Comment Out Assessment Menu

**File:** `resources/views/layouts/admin.blade.php`

```html
{{-- TEMPORARILY HIDDEN
<li class="sidebar-menu-item">
    <a href="{{ route('admin.assessments.index') }}"
        class="sidebar-menu-link {{ request()->is('admin/assessments*') ? 'active' : '' }}">
        <i class="bi bi-clipboard-check"></i>
        <span>Penilaian</span>
    </a>
</li>
--}}
```

### 7.2 Add Middleware Protection (Optional)

```php
// In routes/web.php, add feature flag
Route::prefix('admin/assessments')->middleware(['auth', 'role:admin', 'feature:assessments'])->group(function () {
    // Assessment routes
});
```

---

## Implementation Checklist

### Week 1: Database & Models
- [ ] Create migration for submission status fields
- [ ] Run migration
- [ ] Update Submission model with new relationships & scopes
- [ ] Add verifier role to seeder
- [ ] Create/update User model role handling

### Week 2: Verifier Module
- [ ] Create CheckRole middleware
- [ ] Register middleware in Kernel
- [ ] Create verifier routes
- [ ] Create VerifierSubmissionController
- [ ] Create verifier layout view
- [ ] Create verifier dashboard view
- [ ] Create verifier submissions list view
- [ ] Create verifier submission detail view with verify/reject buttons

### Week 3: Admin Validation Module
- [ ] Create AdminValidationController
- [ ] Add validation routes
- [ ] Create admin validations index view (with status tabs)
- [ ] Create admin validations show view
- [ ] Update admin sidebar with new menu item
- [ ] Update existing submission show view with workflow status

### Week 4: Release & Analytics
- [ ] Implement release functionality
- [ ] Implement bulk release
- [ ] Create AnalyticsController (released data only)
- [ ] Create analytics dashboard view
- [ ] Create export for released data

### Week 5: Testing & Polish
- [ ] Test full workflow: submit → verify → validate → release
- [ ] Test rejection flows
- [ ] Add notification emails (optional)
- [ ] Hide assessment feature
- [ ] UI/UX improvements
- [ ] Documentation

---

## File Structure Summary

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── AdminValidationController.php    # NEW
│   │   │   └── AnalyticsController.php          # NEW
│   │   └── Verifier/
│   │       ├── VerifierDashboardController.php  # NEW
│   │       └── VerifierSubmissionController.php # NEW
│   └── Middleware/
│       └── CheckRole.php                        # NEW
├── Models/
│   └── Submission.php                           # UPDATE

database/
└── migrations/
    └── xxxx_update_submissions_for_workflow.php # NEW

resources/views/
├── admin/
│   ├── validations/
│   │   ├── index.blade.php                      # NEW
│   │   └── show.blade.php                       # NEW
│   └── analytics/
│       └── index.blade.php                      # NEW
├── verifier/
│   ├── layouts/
│   │   └── verifier.blade.php                   # NEW
│   ├── dashboard.blade.php                      # NEW
│   └── submissions/
│       ├── index.blade.php                      # NEW
│       └── show.blade.php                       # NEW
└── layouts/
    └── admin.blade.php                          # UPDATE (add menu, hide assessment)

routes/
└── web.php                                      # UPDATE (add verifier & validation routes)
```

---

## Status Flow Diagram

```
                    ┌──────────────┐
                    │   REJECTED   │
                    └──────────────┘
                          ▲
                          │ reject (with notes)
                          │
┌──────────────┐    ┌──────────────┐    ┌──────────────┐    ┌──────────────┐
│  SUBMITTED   │───►│   VERIFIED   │───►│  VALIDATED   │───►│   RELEASED   │
└──────────────┘    └──────────────┘    └──────────────┘    └──────────────┘
     │                    │                    │                    │
     │                    │                    │                    │
   School              Verifier             Admin               Analytics
   Input               Review              Validate              Ready
```

---

## Notes

1. **Released = Available for Analytics**: Once data is "released", it becomes available in the analytics/reporting modules

2. **Rejection**: Can happen at verification or validation stage, requires notes explaining why

3. **Audit Trail**: All status changes are tracked with who/when for accountability

4. **Future Enhancements**:
   - Email notifications on status change
   - School portal to track submission status
   - Dashboard widgets for pending items
   - Automatic reminders for pending verifications
