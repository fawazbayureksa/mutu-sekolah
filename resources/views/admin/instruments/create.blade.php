@extends('layouts.admin')

@section('title', isset($instrument) ? 'Edit Instrument' : 'Create New Instrument')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">{{ isset($instrument) ? 'Edit Instrument' : 'Create New Instrument' }}</h2>
            <p class="text-muted mb-0">
                {{ isset($instrument) ? 'Update instrument details' : 'Create a new assessment instrument' }}
            </p>
        </div>
        <a href="{{ route('admin.instruments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Instruments
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ isset($instrument) ? route('admin.instruments.update', $instrument) : route('admin.instruments.store') }}"
                        method="POST">
                        @if (isset($instrument))
                            @method('PUT')
                        @endif
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Instrument Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" class="form-control"
                                    value="{{ old('code', $instrument->code ?? '') }}" required>
                                @error('code')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Instrument Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $instrument->name ?? '') }}" required>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    <option value="">Select category</option>
                                    <option value="akreditasi"
                                        {{ old('category', $instrument->category ?? '') === 'akreditasi' ? 'selected' : '' }}>
                                        Akreditasi</option>
                                    <option value="sertifikasi"
                                        {{ old('category', $instrument->category ?? '') === 'sertifikasi' ? 'selected' : '' }}>
                                        Sertifikasi</option>
                                    <option value="pelatihan"
                                        {{ old('category', $instrument->category ?? '') === 'pelatihan' ? 'selected' : '' }}">
                                        Pelatihan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Version</label>
                                <input type="text" name="version" class="form-control"
                                    value="{{ old('version', $instrument->version ?? '1.0') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $instrument->description ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Instructions</label>
                            <textarea name="instructions" class="form-control" rows="2">{{ old('instructions', $instrument->instructions ?? '') }}</textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Estimated Duration (minutes)</label>
                                <input type="number" name="estimated_duration" class="form-control"
                                    value="{{ old('estimated_duration', $instrument->estimated_duration ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Scoring Method</label>
                                <select name="scoring_method" class="form-select">
                                    <option value="simple_sum">Simple Sum</option>
                                    <option value="weighted_sum" selected>Weighted Sum</option>
                                    <option value="average">Average</option>
                                    <option value="percentage">Percentage</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active Instrument</label>
                            </div>
                        </div>

                        <div class="card bg-light p-3 mb-4">
                            <h6 class="mb-3"><i class="bi bi-people me-2"></i>Questions Management</h6>
                            <p class="text-muted mb-3">Select questions from library to add to this instrument</p>

                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 40px">
                                            <input type="checkbox" class="form-check-input" id="selectAllQuestions">
                                        </th>
                                        <th>Question</th>
                                        <th>Type</th>
                                        <th>Aspect</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions as $question)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="form-check-input question-checkbox"
                                                    name="questions[]" value="{{ $question->id }}">
                                            </td>
                                            <td>
                                                <strong>{{ $question->question_code ?? 'Q' . $loop->iteration }}</strong>
                                                <small
                                                    class="text-muted">{{ Str::limit($question->question_text, 80) }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $question->answer_type }}</span>
                                            </td>
                                            <td>
                                                @if ($question->indicator && $question->indicator->aspect)
                                                    <span
                                                        class="badge bg-info">{{ $question->indicator->aspect->name }}</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="mt-3">
                                <button type="button" class="btn btn-outline-secondary btn-sm"
                                    onclick="openQuestionSelector()">
                                    <i class="bi bi-list-check me-1"></i>Select More Questions
                                </button>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i
                                    class="bi bi-check-lg me-2"></i>{{ isset($instrument) ? 'Update Instrument' : 'Create Instrument' }}
                            </button>
                            <a href="{{ route('admin.instruments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Help & Information</strong>
                </div>
                <div class="card-body">
                    <h6 class="mb-3">Instrument Categories</h6>
                    <ul class="mb-0">
                        <li><strong>Akreditasi:</strong> General accreditation instruments</li>
                        <li><strong>Sertifikasi:</strong> Certification instruments</li>
                        <li><strong>Pelatihan:</strong> Workshop/training instruments</li>
                    </ul>
                    <hr>
                    <h6 class="mb-3">Scoring Methods</h6>
                    <ul class="mb-0">
                        <li><strong>Simple Sum:</strong> All questions have equal weight</li>
                        <li><strong>Weighted Sum:</strong> Questions can have different weights</li>
                        <li><strong>Average:</strong> Scores are averaged</li>
                        <li><strong>Percentage:</strong> Scores converted to percentage</li>
                        <li><strong>Custom:</strong> Use custom scoring formula</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('selectAllQuestions')?.addEventListener('change', function() {
            document.querySelectorAll('.question-checkbox').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
@endsection
