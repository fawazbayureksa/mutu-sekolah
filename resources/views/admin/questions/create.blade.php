@extends('layouts.admin')

@section('title', isset($question) ? 'Edit Question' : 'Create Question')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">{{ isset($question) ? 'Edit Question' : 'Create New Question' }}</h1>
            <a href="{{ route('admin.questions.index') }}" class="btn btn-outline-secondary">
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

        <form action="{{ isset($question) ? route('admin.questions.update', $question) : route('admin.questions.store') }}"
            method="POST">
            @csrf
            @if (isset($question))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Question Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="question_code" class="form-label">Question Code <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('question_code') is-invalid @enderror"
                                    id="question_code" name="question_code"
                                    value="{{ old('question_code', $question->question_code ?? '') }}" required>
                                @error('question_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Unique identifier for this question (e.g., Q001,
                                    ASP1_IND1_Q1)</small>
                            </div>

                            <div class="mb-3">
                                <label for="question_text" class="form-label">Question Text <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('question_text') is-invalid @enderror" id="question_text" name="question_text"
                                    rows="4" required>{{ old('question_text', $question->question_text ?? '') }}</textarea>
                                @error('question_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="help_text" class="form-label">Help Text (Optional)</label>
                                <textarea class="form-control @error('help_text') is-invalid @enderror" id="help_text" name="help_text" rows="2">{{ old('help_text', $question->help_text ?? '') }}</textarea>
                                @error('help_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror>
                                <small class="form-text text-muted">Additional guidance or explanation for
                                    respondents</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="aspect_id" class="form-label">Assessment Aspect <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('aspect_id') is-invalid @enderror" id="aspect_id"
                                        required>
                                        <option value="">Select Aspect</option>
                                        @foreach ($aspects as $aspect)
                                            <option value="{{ $aspect->id }}"
                                                {{ old('aspect_id', $question->indicator->aspect_id ?? '') == $aspect->id ? 'selected' : '' }}>
                                                {{ $aspect->aspect_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('aspect_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="indicator_id" class="form-label">Indicator <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('indicator_id') is-invalid @enderror"
                                        id="indicator_id" name="indicator_id" required>
                                        <option value="">Select Indicator</option>
                                        @if (isset($question) && $question->indicator)
                                            <option value="{{ $question->indicator_id }}" selected>
                                                {{ $question->indicator->indicator_name }}
                                            </option>
                                        @endif
                                    </select>
                                    @error('indicator_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="answer_type" class="form-label">Answer Type <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('answer_type') is-invalid @enderror" id="answer_type"
                                        name="answer_type" required>
                                        <option value="">Select Type</option>
                                        <option value="text"
                                            {{ old('answer_type', $question->answer_type ?? '') == 'text' ? 'selected' : '' }}>
                                            Text</option>
                                        <option value="number"
                                            {{ old('answer_type', $question->answer_type ?? '') == 'number' ? 'selected' : '' }}>
                                            Number</option>
                                        <option value="scale"
                                            {{ old('answer_type', $question->answer_type ?? '') == 'scale' ? 'selected' : '' }}>
                                            Scale (Rating)</option>
                                        <option value="choice"
                                            {{ old('answer_type', $question->answer_type ?? '') == 'choice' ? 'selected' : '' }}>
                                            Multiple Choice</option>
                                        <option value="date"
                                            {{ old('answer_type', $question->answer_type ?? '') == 'date' ? 'selected' : '' }}>
                                            Date</option>
                                    </select>
                                    @error('answer_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="weight" class="form-label">Weight</label>
                                    <input type="number" class="form-control @error('weight') is-invalid @enderror"
                                        id="weight" name="weight" min="1" max="10" step="1"
                                        value="{{ old('weight', $question->weight ?? 1) }}">
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="order" class="form-label">Display Order</label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                                        id="order" name="order" min="1"
                                        value="{{ old('order', $question->order ?? 999) }}">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dynamic fields based on answer type -->
                            <div id="scaleOptions" style="display: none;">
                                <div class="mb-3">
                                    <label for="scale_template_id" class="form-label">Scale Template</label>
                                    <select class="form-select" id="scale_template_id" name="scale_template_id">
                                        <option value="">Select Template</option>
                                        @foreach ($scaleTemplates as $template)
                                            <option value="{{ $template->id }}" data-min="{{ $template->min_value }}"
                                                data-max="{{ $template->max_value }}"
                                                {{ old('scale_template_id', $question->scale_template_id ?? '') == $template->id ? 'selected' : '' }}>
                                                {{ $template->name }} ({{ $template->min_value }} -
                                                {{ $template->max_value }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Or set custom min/max scores below</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="min_score" class="form-label">Minimum Score</label>
                                        <input type="number" class="form-control" id="min_score" name="min_score"
                                            value="{{ old('min_score', $question->min_score ?? 1) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="max_score" class="form-label">Maximum Score</label>
                                        <input type="number" class="form-control" id="max_score" name="max_score"
                                            value="{{ old('max_score', $question->max_score ?? 5) }}">
                                    </div>
                                </div>
                            </div>

                            <div id="choiceOptions" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label">Answer Options (One per line)</label>
                                    <textarea class="form-control" id="answer_options" name="answer_options" rows="5"
                                        placeholder="Option 1&#10;Option 2&#10;Option 3">{{ old('answer_options', is_array($question->answer_options ?? null) ? implode("\n", $question->answer_options) : '') }}</textarea>
                                    <small class="form-text text-muted">Each option on a new line</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_required" name="is_required"
                                        value="1"
                                        {{ old('is_required', $question->is_required ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_required">
                                        Required Question
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> {{ isset($question) ? 'Update Question' : 'Create Question' }}
                        </button>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Help & Guidelines</h5>
                        </div>
                        <div class="card-body">
                            <h6>Question Types:</h6>
                            <ul class="small">
                                <li><strong>Text:</strong> Free-form text response</li>
                                <li><strong>Number:</strong> Numeric input only</li>
                                <li><strong>Scale:</strong> Rating scale (e.g., 1-5, 1-10)</li>
                                <li><strong>Choice:</strong> Multiple options to choose from</li>
                                <li><strong>Date:</strong> Date picker input</li>
                            </ul>

                            <h6 class="mt-3">Best Practices:</h6>
                            <ul class="small">
                                <li>Use clear, concise question text</li>
                                <li>Provide help text for complex questions</li>
                                <li>Set appropriate weights for scoring</li>
                                <li>Link questions to correct indicators</li>
                                <li>Test questions before publishing</li>
                            </ul>

                            @if (isset($question))
                                <hr>
                                <h6>Question Info:</h6>
                                <ul class="small mb-0">
                                    <li>Created: {{ $question->created_at->format('M d, Y') }}</li>
                                    <li>Updated: {{ $question->updated_at->format('M d, Y') }}</li>
                                    <li>Status: {{ $question->is_active ? 'Active' : 'Inactive' }}</li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Store aspect indicators data
            const aspectIndicators = @json($aspects);

            // Update indicators when aspect changes
            document.getElementById('aspect_id').addEventListener('change', function() {
                const aspectId = parseInt(this.value);
                const indicatorSelect = document.getElementById('indicator_id');

                indicatorSelect.innerHTML = '<option value="">Select Indicator</option>';

                if (aspectId) {
                    const aspect = aspectIndicators.find(a => a.id === aspectId);
                    if (aspect && aspect.indicators) {
                        aspect.indicators.forEach(indicator => {
                            const option = document.createElement('option');
                            option.value = indicator.id;
                            option.textContent = indicator.indicator_name;
                            indicatorSelect.appendChild(option);
                        });
                    }
                }
            });

            // Show/hide fields based on answer type
            document.getElementById('answer_type').addEventListener('change', function() {
                const scaleOptions = document.getElementById('scaleOptions');
                const choiceOptions = document.getElementById('choiceOptions');

                scaleOptions.style.display = 'none';
                choiceOptions.style.display = 'none';

                if (this.value === 'scale') {
                    scaleOptions.style.display = 'block';
                } else if (this.value === 'choice') {
                    choiceOptions.style.display = 'block';
                }
            });

            // Trigger change on page load to show correct fields
            document.getElementById('answer_type').dispatchEvent(new Event('change'));

            // Update min/max scores when scale template changes
            document.getElementById('scale_template_id')?.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    document.getElementById('min_score').value = selectedOption.dataset.min;
                    document.getElementById('max_score').value = selectedOption.dataset.max;
                }
            });
        </script>
    @endpush
@endsection
