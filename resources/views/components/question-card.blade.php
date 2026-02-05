@props([
    'question',
    'answer' => null,
    'errors' => [],
])

@php
    $fieldName = 'answers[' . $question->id . ']';
    $value = $answer['answer_value'] ?? null;
    $error = $errors->first($fieldName);
    $answerOptions = $question->getAnswerOptionsArray();
    $isRequired = $question->is_required;
@endphp

<div class="indicator-item mb-3">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            @if($question->question_code)
                <span class="indicator-code">{{ $question->question_code }}</span>
            @endif
            <h6 class="mb-1 fw-semibold">{{ $question->question_text }}</h6>
            @if($question->help_text)
                <p class="small text-muted mb-0">{{ $question->help_text }}</p>
            @endif
        </div>
        @if($isRequired)
            <span class="badge bg-danger small">Wajib</span>
        @endif
    </div>

    <div class="answer-container">
        <x-answer-input 
            :question="$question" 
            :value="$value" 
            :error="$error"
            :required="$isRequired" />
    </div>

    @if($question->answer_type === 'file' || ($answerOptions && isset($answerOptions[0]['description'])))
        <div class="mt-2">
            @if($question->answer_type === 'file')
                <div class="form-text">
                    <i class="bi bi-info-circle me-1"></i>
                    Unggah file pendukung (maks 10MB)
                </div>
            @elseif($answerOptions)
                <div class="accordion accordion-flush small">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed py-2 px-0" type="button" 
                                data-bs-toggle="collapse" data-bs-target="#desc_{{ $question->id }}">
                                <i class="bi bi-question-circle me-2"></i>Lihat deskripsi opsi
                            </button>
                        </h2>
                        <div id="desc_{{ $question->id }}" class="accordion-collapse collapse">
                            <div class="accordion-body px-0 py-2">
                                <ul class="mb-0">
                                    @foreach($answerOptions as $option)
                                        @if(isset($option['description']))
                                            <li class="mb-1">
                                                <strong>{{ $option['label'] }}:</strong> {{ $option['description'] }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <div class="mt-3">
        <textarea 
            name="{{ $fieldName }}_notes" 
            class="form-control form-control-sm"
            rows="2"
            placeholder="Catatan tambahan (opsional)">{{ $answer['notes'] ?? '' }}</textarea>
    </div>
</div>
