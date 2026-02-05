@extends('layouts.admin')

@section('title', isset($assessment) ? 'Edit Assessment' : 'Create Assessment')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">{{ isset($assessment) ? 'Edit Assessment' : 'Create New Assessment' }}</h1>
            <a href="{{ route('admin.assessments.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validation Errors:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form
            action="{{ isset($assessment) ? route('admin.assessments.update', $assessment) : route('admin.assessments.store') }}"
            method="POST">
            @csrf
            @if (isset($assessment))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Assessment Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="school_id" class="form-label">School <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('school_id') is-invalid @enderror" id="school_id"
                                        name="school_id" required>
                                        <option value="">Select School</option>
                                        @foreach ($schools as $school)
                                            <option value="{{ $school->id }}"
                                                {{ old('school_id', $assessment->school_id ?? '') == $school->id ? 'selected' : '' }}>
                                                {{ $school->school_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('school_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="instrument_id" class="form-label">Instrument <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('instrument_id') is-invalid @enderror"
                                        id="instrument_id" name="instrument_id" required>
                                        <option value="">Select Instrument</option>
                                        @foreach ($instruments as $instrument)
                                            <option value="{{ $instrument->id }}"
                                                {{ old('instrument_id', $assessment->instrument_id ?? '') == $instrument->id ? 'selected' : '' }}>
                                                {{ $instrument->instrument_name }} (v{{ $instrument->version }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('instrument_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="assessment_date" class="form-label">Assessment Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date"
                                        class="form-control @error('assessment_date') is-invalid @enderror"
                                        id="assessment_date" name="assessment_date"
                                        value="{{ old('assessment_date', isset($assessment) ? $assessment->assessment_date : date('Y-m-d')) }}"
                                        required>
                                    @error('assessment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="assessment_year" class="form-label">Assessment Year <span
                                            class="text-danger">*</span></label>
                                    <input type="number"
                                        class="form-control @error('assessment_year') is-invalid @enderror"
                                        id="assessment_year" name="assessment_year" min="2020" max="2030"
                                        value="{{ old('assessment_year', $assessment->assessment_year ?? date('Y')) }}"
                                        required>
                                    @error('assessment_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="assessment_period" class="form-label">Assessment Period <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('assessment_period') is-invalid @enderror"
                                        id="assessment_period" name="assessment_period" required>
                                        <option value="">Select Period</option>
                                        <option value="semester1"
                                            {{ old('assessment_period', $assessment->assessment_period ?? '') == 'semester1' ? 'selected' : '' }}>
                                            Semester 1</option>
                                        <option value="semester2"
                                            {{ old('assessment_period', $assessment->assessment_period ?? '') == 'semester2' ? 'selected' : '' }}>
                                            Semester 2</option>
                                        <option value="annual"
                                            {{ old('assessment_period', $assessment->assessment_period ?? '') == 'annual' ? 'selected' : '' }}>
                                            Annual</option>
                                        <option value="midterm"
                                            {{ old('assessment_period', $assessment->assessment_period ?? '') == 'midterm' ? 'selected' : '' }}>
                                            Mid-term</option>
                                        <option value="final"
                                            {{ old('assessment_period', $assessment->assessment_period ?? '') == 'final' ? 'selected' : '' }}>
                                            Final</option>
                                    </select>
                                    @error('assessment_period')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="assessor_id" class="form-label">Assessor</label>
                                <select class="form-select @error('assessor_id') is-invalid @enderror" id="assessor_id"
                                    name="assessor_id">
                                    <option value="">Select Assessor (default: current user)</option>
                                    @foreach ($assessors as $assessor)
                                        <option value="{{ $assessor->id }}"
                                            {{ old('assessor_id', $assessment->assessor_id ?? '') == $assessor->id ? 'selected' : '' }}>
                                            {{ $assessor->name }} ({{ $assessor->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('assessor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Leave blank to assign to yourself</small>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes (Optional)</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $assessment->notes ?? '') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Additional notes or context for this assessment</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.assessments.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i>
                            {{ isset($assessment) ? 'Update Assessment' : 'Create Assessment' }}
                        </button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Help & Guidelines</h5>
                        </div>
                        <div class="card-body">
                            <h6>Steps to Complete Assessment:</h6>
                            <ol class="small">
                                <li>Fill in basic assessment information</li>
                                <li>Select the school to be assessed</li>
                                <li>Choose the appropriate instrument</li>
                                <li>Set the assessment date and period</li>
                                <li>Click "Create Assessment"</li>
                                <li>Start filling in answers</li>
                                <li>Submit for review when complete</li>
                            </ol>

                            <hr>

                            <h6>Assessment Periods:</h6>
                            <ul class="small">
                                <li><strong>Semester 1:</strong> First half of academic year</li>
                                <li><strong>Semester 2:</strong> Second half of academic year</li>
                                <li><strong>Annual:</strong> Full year assessment</li>
                                <li><strong>Mid-term:</strong> Mid-period check-in</li>
                                <li><strong>Final:</strong> Final evaluation</li>
                            </ul>

                            @if (isset($assessment))
                                <hr>
                                <h6>Assessment Info:</h6>
                                <ul class="small mb-0">
                                    <li>Code: <code>{{ $assessment->assessment_code }}</code></li>
                                    <li>Status: @include('admin.assessments.partials.status-badge', [
                                        'status' => $assessment->status,
                                    ])</li>
                                    <li>Created: {{ $assessment->created_at->format('M d, Y') }}</li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
