@extends('layouts.admin')

@section('title', 'Edit Instrument')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Edit Instrument</h2>
            <p class="text-muted mb-0">Update instrument details and questions</p>
        </div>
        <a href="{{ route('admin.instruments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Instruments
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.instruments.update', $instrument) }}" method="POST">
                        @method('PUT')
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Instrument Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" class="form-control"
                                    value="{{ old('code', $instrument->code) }}" required readonly>
                                <small class="text-muted">Code cannot be changed after creation</small>
                                @error('code')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Instrument Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $instrument->name) }}" required>
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
                                        {{ old('category', $instrument->category) === 'akreditasi' ? 'selected' : '' }}>
                                        Akreditasi</option>
                                    <option value="sertifikasi"
                                        {{ old('category', $instrument->category) === 'sertifikasi' ? 'selected' : '' }}>
                                        Sertifikasi</option>
                                    <option value="pelatihan"
                                        {{ old('category', $instrument->category) === 'pelatihan' ? 'selected' : '' }}>
                                        Pelatihan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Version</label>
                                <input type="text" name="version" class="form-control"
                                    value="{{ old('version', $instrument->version) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $instrument->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Instructions</label>
                            <textarea name="instructions" class="form-control" rows="2">{{ old('instructions', $instrument->instructions) }}</textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Estimated Duration (minutes)</label>
                                <input type="number" name="estimated_duration" class="form-control"
                                    value="{{ old('estimated_duration', $instrument->estimated_duration) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Scoring Method</label>
                                <select name="scoring_method" class="form-select">
                                    <option value="simple_sum"
                                        {{ old('scoring_method', $instrument->scoring_method) === 'simple_sum' ? 'selected' : '' }}>
                                        Simple Sum</option>
                                    <option value="weighted_sum"
                                        {{ old('scoring_method', $instrument->scoring_method) === 'weighted_sum' ? 'selected' : '' }}>
                                        Weighted Sum</option>
                                    <option value="average"
                                        {{ old('scoring_method', $instrument->scoring_method) === 'average' ? 'selected' : '' }}>
                                        Average</option>
                                    <option value="percentage"
                                        {{ old('scoring_method', $instrument->scoring_method) === 'percentage' ? 'selected' : '' }}>
                                        Percentage</option>
                                    <option value="custom"
                                        {{ old('scoring_method', $instrument->scoring_method) === 'custom' ? 'selected' : '' }}>
                                        Custom</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                    {{ old('is_active', $instrument->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active Instrument</label>
                            </div>
                        </div>

                        <div class="card bg-light p-3 mb-4">
                            <h6 class="mb-3"><i class="bi bi-list-check me-2"></i>Questions Management</h6>
                            <p class="text-muted mb-3">Select questions from library to add to this instrument</p>

                            @if ($instrument->items->count() > 0)
                                <div class="alert alert-info mb-3">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Current instrument has <strong>{{ $instrument->items->count() }}</strong> question(s).
                                    Updating questions will replace the current selection.
                                </div>
                            @endif

                            <div class="table-responsive">
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
                                        @php
                                            $selectedQuestionIds = $instrument->items
                                                ->pluck('assessment_question_id')
                                                ->toArray();
                                        @endphp
                                        @foreach ($questions as $question)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input question-checkbox"
                                                        name="questions[{{ $loop->index }}][question_id]"
                                                        value="{{ $question->id }}"
                                                        {{ in_array($question->id, $selectedQuestionIds) ? 'checked' : '' }}>
                                                </td>
                                                <td>
                                                    <strong>{{ $question->question_code ?? 'Q' . $loop->iteration }}</strong><br>
                                                    <small
                                                        class="text-muted">{{ Str::limit($question->question_text, 80) }}</small>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-light text-dark">{{ ucfirst($question->answer_type) }}</span>
                                                </td>
                                                <td>
                                                    @if ($question->indicator && $question->indicator->aspect)
                                                        <span
                                                            class="badge bg-info">{{ $question->indicator->aspect->aspect_name }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>Update Instrument
                            </button>
                            <a href="{{ route('admin.instruments.show', $instrument) }}"
                                class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Instrument Information</strong>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Created At</small>
                        <div>{{ $instrument->created_at->format('d M Y H:i') }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Last Updated</small>
                        <div>{{ $instrument->updated_at->format('d M Y H:i') }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Status</small>
                        <div>
                            @if ($instrument->is_published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                            @if ($instrument->is_active)
                                <span class="badge bg-info">Active</span>
                            @else
                                <span class="badge bg-warning">Inactive</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <small class="text-muted">Total Questions</small>
                        <div><strong>{{ $instrument->items->count() }}</strong> question(s)</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <strong>Help & Information</strong>
                </div>
                <div class="card-body">
                    <h6 class="mb-3">Instrument Categories</h6>
                    <ul class="mb-3">
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

    @push('scripts')
        <script>
            document.getElementById('selectAllQuestions')?.addEventListener('change', function() {
                document.querySelectorAll('.question-checkbox').forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            document.querySelectorAll('.question-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allCheckboxes = document.querySelectorAll('.question-checkbox');
                    const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
                    document.getElementById('selectAllQuestions').checked = allChecked;
                });
            });
        </script>
    @endpush
@endsection
