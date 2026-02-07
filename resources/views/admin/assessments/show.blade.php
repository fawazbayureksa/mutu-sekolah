@extends('layouts.admin')

@section('title', 'Assessment Details')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Assessment Details</h1>
            <div>
                @if (in_array($assessment->status, ['draft', 'rejected']))
                    <a href="{{ route('admin.assessments.answers.index', $assessment) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Fill Answers
                    </a>
                @endif
                <a href="{{ route('admin.assessments.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-clipboard-check"></i> Assessment Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Assessment Code:</strong>
                            </div>
                            <div class="col-md-8">
                                <code class="fs-6">{{ $assessment->assessment_code }}</code>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>School:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $assessment->school->school_name }}
                                <br><small class="text-muted">{{ $assessment->school->school_code }}</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Instrument:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $assessment->instrument->name }}
                                <br><small class="text-muted">Version {{ $assessment->instrument->version }}</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Assessment Period:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $assessment->assessment_year }} - {{ ucfirst($assessment->assessment_period) }}
                                <br><small class="text-muted">Date:
                                    {{ \Carbon\Carbon::parse($assessment->assessment_date)->format('F d, Y') }}</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Assessor:</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $assessment->assessor->name ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Status:</strong>
                            </div>
                            <div class="col-md-8">
                                @include('admin.assessments.partials.status-badge', [
                                    'status' => $assessment->status,
                                ])
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Completion:</strong>
                            </div>
                            <div class="col-md-8">
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $completionPercentage }}%;"
                                        aria-valuenow="{{ $completionPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $completionPercentage }}%
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($assessment->notes)
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong>Notes:</strong>
                                </div>
                                <div class="col-md-8">
                                    <p class="mb-0">{{ $assessment->notes }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($assessment->rejection_reason)
                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-danger">
                                        <h6><i class="bi bi-exclamation-triangle"></i> Rejection Reason:</h6>
                                        <p class="mb-0">{{ $assessment->rejection_reason }}</p>
                                        <small class="text-muted">Rejected by {{ $assessment->rejecter->name ?? 'N/A' }} on
                                            {{ $assessment->rejected_at?->format('M d, Y H:i') }}</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($assessment->total_score)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-graph-up"></i> Score Breakdown by Aspect
                            </h5>
                        </div>
                        <div class="card-body">
                            @include('admin.assessments.partials.score-breakdown', [
                                'scoreByAspect' => $scoreByAspect,
                            ])
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-clock-history"></i> Timeline
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="timeline">
                            <li>
                                <strong>Created:</strong> {{ $assessment->created_at->format('M d, Y H:i') }}
                            </li>
                            @if ($assessment->submitted_at)
                                <li>
                                    <strong>Submitted:</strong> {{ $assessment->submitted_at->format('M d, Y H:i') }}
                                    <small class="text-muted">(by {{ $assessment->submitter->name ?? 'N/A' }})</small>
                                </li>
                            @endif
                            @if ($assessment->verified_at)
                                <li>
                                    <strong>Verified:</strong> {{ $assessment->verified_at->format('M d, Y H:i') }}
                                    <small class="text-muted">(by {{ $assessment->verifier->name ?? 'N/A' }})</small>
                                </li>
                            @endif
                            @if ($assessment->approved_at)
                                <li>
                                    <strong>Approved:</strong> {{ $assessment->approved_at->format('M d, Y H:i') }}
                                    <small class="text-muted">(by {{ $assessment->approver->name ?? 'N/A' }})</small>
                                </li>
                            @endif
                            @if ($assessment->rejected_at)
                                <li class="text-danger">
                                    <strong>Rejected:</strong> {{ $assessment->rejected_at->format('M d, Y H:i') }}
                                    <small>(by {{ $assessment->rejecter->name ?? 'N/A' }})</small>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quick Stats</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <h3 class="mb-0">{{ $completionPercentage }}%</h3>
                                <small class="text-muted">Completion</small>
                            </div>
                            <div class="col-6 mb-3">
                                @if ($assessment->total_score)
                                    <h3 class="mb-0">{{ number_format($assessment->total_score, 2) }}</h3>
                                    <small class="text-muted">Total Score</small>
                                @else
                                    <h3 class="mb-0">-</h3>
                                    <small class="text-muted">Not Scored</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if (in_array($assessment->status, ['draft', 'rejected']))
                                <a href="{{ route('admin.assessments.answers.index', $assessment) }}"
                                    class="btn btn-primary">
                                    <i class="bi bi-pencil-square"></i> Fill Answers
                                </a>
                                <a href="{{ route('admin.assessments.edit', $assessment) }}" class="btn btn-secondary">
                                    <i class="bi bi-gear"></i> Edit Assessment Info
                                </a>
                            @endif

                            @if ($assessment->status === 'draft' && $completionPercentage == 100)
                                <form action="{{ route('admin.assessments.submit', $assessment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-send"></i> Submit for Review
                                    </button>
                                </form>
                            @endif

                            @if ($assessment->status === 'submitted')
                                <form action="{{ route('admin.assessments.verify', $assessment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-check-circle"></i> Verify Assessment
                                    </button>
                                </form>
                            @endif

                            @if ($assessment->status === 'verified')
                                <form action="{{ route('admin.assessments.approve', $assessment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-check-all"></i> Approve Assessment
                                    </button>
                                </form>
                            @endif

                            @if (in_array($assessment->status, ['submitted', 'verified']))
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#rejectModal">
                                    <i class="bi bi-x-circle"></i> Reject Assessment
                                </button>
                            @endif

                            @if ($assessment->total_score)
                                <form action="{{ route('admin.assessments.recalculateScores', $assessment) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-secondary w-100">
                                        <i class="bi bi-arrow-clockwise"></i> Recalculate Scores
                                    </button>
                                </form>
                            @endif

                            <hr>

                            @if ($assessment->status === 'draft')
                                <form action="{{ route('admin.assessments.destroy', $assessment) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this assessment? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-trash"></i> Delete Assessment
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.assessments.reject', $assessment) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Reject Assessment</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="rejection_reason" class="form-label">Rejection Reason <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" required
                                placeholder="Please provide a detailed reason for rejection..."></textarea>
                            <small class="form-text text-muted">This will be visible to the assessor</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Assessment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
