@extends('layouts.admin')

@section('title', 'Fill Assessment Answers')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Fill Assessment Answers</h1>
                <p class="text-muted mb-0">
                    <code>{{ $assessment->assessment_code }}</code> -
                    {{ $assessment->school->school_name }}
                </p>
            </div>
            <div>
                <a href="{{ route('admin.assessments.show', $assessment) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Assessment
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
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

                @if ($assessment->status === 'rejected' && $assessment->rejection_reason)
                    <div class="alert alert-warning">
                        <h6><i class="bi bi-exclamation-triangle"></i> This assessment was rejected</h6>
                        <p class="mb-0"><strong>Reason:</strong> {{ $assessment->rejection_reason }}</p>
                    </div>
                @endif

                <form id="answersForm">
                    @csrf
                    @foreach ($itemsByAspect as $aspectName => $items)
                        <div class="card mb-3">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title mb-0">{{ $aspectName }}</h5>
                            </div>
                            <div class="card-body">
                                @foreach ($items as $item)
                                    @php
                                        $question = $item->question;
                                        $existingAnswer = $existingAnswers->get($item->id);
                                    @endphp

                                    <div class="mb-4 pb-3 border-bottom question-item" data-item-id="{{ $item->id }}">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="mb-1">
                                                    {{ $loop->parent->index + 1 }}.{{ $loop->iteration }}.
                                                    {{ $question->question_text }}
                                                    @if ($question->is_required)
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </h6>
                                                @if ($question->help_text)
                                                    <small class="text-muted">{{ $question->help_text }}</small>
                                                @endif
                                            </div>
                                            <span class="badge bg-secondary">{{ ucfirst($question->answer_type) }}</span>
                                        </div>

                                        <div class="answer-field">
                                            @switch($question->answer_type)
                                                @case('text')
                                                    <textarea class="form-control answer-input" data-item-id="{{ $item->id }}" rows="3"
                                                        placeholder="Enter your answer...">{{ $existingAnswer->answer_text ?? '' }}</textarea>
                                                @break

                                                @case('number')
                                                    <input type="number" class="form-control answer-input"
                                                        data-item-id="{{ $item->id }}" placeholder="Enter a number"
                                                        value="{{ $existingAnswer->answer_value ?? '' }}">
                                                @break

                                                @case('scale')
                                                    <div class="d-flex align-items-center gap-3">
                                                        <span class="text-muted">{{ $question->min_score }}</span>
                                                        <input type="range" class="form-range answer-input flex-grow-1"
                                                            data-item-id="{{ $item->id }}" min="{{ $question->min_score }}"
                                                            max="{{ $question->max_score }}"
                                                            value="{{ $existingAnswer->answer_value ?? $question->min_score }}"
                                                            oninput="document.getElementById('scale-value-{{ $item->id }}').innerText = this.value">
                                                        <span class="text-muted">{{ $question->max_score }}</span>
                                                        <span class="badge bg-primary" id="scale-value-{{ $item->id }}">
                                                            {{ $existingAnswer->answer_value ?? $question->min_score }}
                                                        </span>
                                                    </div>
                                                @break

                                                @case('choice')
                                                    @if (is_array($question->answer_options))
                                                        @foreach ($question->answer_options as $option)
                                                            <div class="form-check">
                                                                <input class="form-check-input answer-input" type="radio"
                                                                    name="answer_{{ $item->id }}"
                                                                    data-item-id="{{ $item->id }}" value="{{ $option }}"
                                                                    id="option_{{ $item->id }}_{{ $loop->index }}"
                                                                    {{ ($existingAnswer->answer_text ?? '') == $option ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="option_{{ $item->id }}_{{ $loop->index }}">
                                                                    {{ $option }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @break

                                                @case('date')
                                                    <input type="date" class="form-control answer-input"
                                                        data-item-id="{{ $item->id }}"
                                                        value="{{ $existingAnswer->answer_text ?? '' }}">
                                                @break
                                            @endswitch
                                        </div>

                                        <div class="mt-2 save-status" id="status-{{ $item->id }}"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </form>
            </div>

            <div class="col-md-3">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Progress</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Completion</span>
                                <span id="completion-text">0%</span>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" id="completion-bar" style="width: 0%;"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    0%
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary" id="saveAllBtn">
                                <i class="bi bi-save"></i> Save All Answers
                            </button>
                            <a href="{{ route('admin.assessments.show', $assessment) }}" class="btn btn-secondary">
                                <i class="bi bi-eye"></i> Preview Assessment
                            </a>
                        </div>

                        <hr>

                        <h6 class="mb-2">Instructions:</h6>
                        <ul class="small">
                            <li>Answers are auto-saved as you type</li>
                            <li>Required questions marked with <span class="text-danger">*</span></li>
                            <li>Complete all questions to submit</li>
                            <li>Use "Save All" to ensure changes</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const assessmentId = {{ $assessment->id }};
            let saveTimeout;

            // Auto-save answer when input changes
            document.querySelectorAll('.answer-input').forEach(input => {
                input.addEventListener('change', function() {
                    saveAnswer(this);
                });

                // For text inputs, save after typing stops
                if (this.type === 'text' || this.tagName === 'TEXTAREA') {
                    input.addEventListener('input', function() {
                        clearTimeout(saveTimeout);
                        saveTimeout = setTimeout(() => saveAnswer(this), 1000);
                    });
                }
            });

            function saveAnswer(element) {
                const itemId = element.dataset.itemId;
                let answerValue = null;
                let answerText = null;

                // Get value based on input type
                if (element.type === 'radio') {
                    if (!element.checked) return;
                    answerText = element.value;
                } else if (element.type === 'range' || element.type === 'number') {
                    answerValue = element.value;
                } else if (element.type === 'date') {
                    answerText = element.value;
                } else {
                    answerText = element.value;
                }

                // Show saving status
                const statusEl = document.getElementById(`status-${itemId}`);
                statusEl.innerHTML = '<small class="text-muted"><i class="bi bi-arrow-clockwise spin"></i> Saving...</small>';

                // Send AJAX request
                fetch(`/admin/assessments/${assessmentId}/answers`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            instrument_item_id: itemId,
                            answer_value: answerValue,
                            answer_text: answerText
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            statusEl.innerHTML =
                                '<small class="text-success"><i class="bi bi-check-circle"></i> Saved</small>';
                            updateProgress(data.data.completion_percentage);
                            setTimeout(() => {
                                statusEl.innerHTML = '';
                            }, 2000);
                        } else {
                            statusEl.innerHTML = '<small class="text-danger"><i class="bi bi-x-circle"></i> ' + data
                                .message + '</small>';
                        }
                    })
                    .catch(error => {
                        statusEl.innerHTML =
                            '<small class="text-danger"><i class="bi bi-x-circle"></i> Error saving</small>';
                        console.error('Error:', error);
                    });
            }

            function updateProgress(percentage) {
                const progressBar = document.getElementById('completion-bar');
                const progressText = document.getElementById('completion-text');

                progressBar.style.width = percentage + '%';
                progressBar.setAttribute('aria-valuenow', percentage);
                progressBar.textContent = percentage + '%';
                progressText.textContent = percentage + '%';

                // Change color based on completion
                progressBar.className = 'progress-bar';
                if (percentage >= 100) {
                    progressBar.classList.add('bg-success');
                } else if (percentage >= 75) {
                    progressBar.classList.add('bg-info');
                } else if (percentage >= 50) {
                    progressBar.classList.add('bg-warning');
                }
            }

            // Save all button
            document.getElementById('saveAllBtn')?.addEventListener('click', function() {
                const button = this;
                button.disabled = true;
                button.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i> Saving...';

                // Trigger save for all inputs
                document.querySelectorAll('.answer-input').forEach(input => {
                    if (input.type !== 'radio' || input.checked) {
                        saveAnswer(input);
                    }
                });

                setTimeout(() => {
                    button.disabled = false;
                    button.innerHTML = '<i class="bi bi-check-circle"></i> All Saved!';
                    setTimeout(() => {
                        button.innerHTML = '<i class="bi bi-save"></i> Save All Answers';
                    }, 2000);
                }, 1000);
            });

            // Calculate initial progress
            document.addEventListener('DOMContentLoaded', function() {
                const totalQuestions = document.querySelectorAll('.question-item').length;
                const answeredQuestions = document.querySelectorAll(
                    '.answer-input[value]:not([value=""]), .answer-input:checked, textarea:not(:empty)').length;
                const percentage = totalQuestions > 0 ? Math.round((answeredQuestions / totalQuestions) * 100) : 0;
                updateProgress(percentage);
            });
        </script>

        <style>
            .spin {
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }
        </style>
    @endpush
@endsection
