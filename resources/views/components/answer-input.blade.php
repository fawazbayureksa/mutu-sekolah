@props([
    'question',
    'value' => null,
    'error' => null,
    'required' => true,
])

@php
    $answerOptions = $question->getAnswerOptionsArray();
    $fieldName = 'answers[' . $question->id . ']';
    $fieldId = 'answer_' . $question->id;
@endphp

<div class="answer-input-wrapper" data-question-id="{{ $question->id }}" data-answer-type="{{ $question->answer_type }}">
    @if ($error)
        <div class="alert alert-danger small mb-2">{{ $error }}</div>
    @endif

    @switch($question->answer_type)
        @case('boolean')
            <div class="btn-group w-100" role="group">
                <input type="radio" 
                    class="btn-check" 
                    name="{{ $fieldName }}" 
                    id="{{ $fieldId }}_yes" 
                    value="1"
                    @if($value === true || $value === '1' || $value === 'Yes' || $value === 'Ya') checked @endif
                    {{ $required ? 'required' : '' }}>
                <label class="btn btn-outline-primary" for="{{ $fieldId }}_yes">
                    <i class="bi bi-check-circle me-1"></i>Ya
                </label>

                <input type="radio" 
                    class="btn-check" 
                    name="{{ $fieldName }}" 
                    id="{{ $fieldId }}_no" 
                    value="0"
                    @if($value === false || $value === '0' || $value === 'No' || $value === 'Tidak') checked @endif>
                <label class="btn btn-outline-primary" for="{{ $fieldId }}_no">
                    <i class="bi bi-x-circle me-1"></i>Tidak
                </label>
            </div>
            @break

        @case('scale')
            @if($answerOptions)
                <div class="d-flex flex-wrap gap-2">
                    @foreach($answerOptions as $index => $option)
                        <input type="radio" 
                            class="btn-check scale-option" 
                            name="{{ $fieldName }}" 
                            id="{{ $fieldId }}_{{ $index }}" 
                            value="{{ $option['value'] }}"
                            @if($value == $option['value']) checked @endif
                            {{ $required ? 'required' : '' }}>
                        <label class="btn btn-outline-primary scale-label" for="{{ $fieldId }}_{{ $index }}"
                            title="{{ $option['label'] }}"
                            data-score="{{ $option['score'] ?? '' }}">
                            {{ $option['label'] }}
                        </label>
                    @endforeach
                </div>
            @else
                <input type="range" 
                    name="{{ $fieldName }}" 
                    class="form-range"
                    id="{{ $fieldId }}"
                    min="{{ $question->min_score ?? 1 }}"
                    max="{{ $question->max_score ?? 5 }}"
                    step="1"
                    value="{{ $value ?? $question->min_score ?? 1 }}"
                    {{ $required ? 'required' : '' }}
                    oninput="this.nextElementSibling.value = this.value">
                <output class="ms-2 fw-bold text-primary">{{ $value ?? $question->min_score ?? 1 }}</output>
            @endif
            @break

        @case('number')
            <div class="input-group">
                <input type="number" 
                    name="{{ $fieldName }}" 
                    class="form-control @if($error) is-invalid @endif"
                    id="{{ $fieldId }}"
                    value="{{ $value }}"
                    placeholder="Masukkan angka"
                    @if($question->min_score !== null) min="{{ $question->min_score }}" @endif
                    @if($question->max_score !== null) max="{{ $question->max_score }}" @endif
                    step="any"
                    {{ $required ? 'required' : '' }}>
                @if($question->min_score !== null || $question->max_score !== null)
                    <span class="input-group-text">
                        @if($question->min_score !== null)
                            Min: {{ $question->min_score }}
                        @endif
                        @if($question->max_score !== null)
                            {{ $question->min_score !== null ? '|' : '' }} Max: {{ $question->max_score }}
                        @endif
                    </span>
                @endif
            </div>
            @break

        @case('percentage')
            <div class="input-group">
                <input type="number" 
                    name="{{ $fieldName }}" 
                    class="form-control @if($error) is-invalid @endif"
                    id="{{ $fieldId }}"
                    value="{{ $value }}"
                    placeholder="0-100"
                    min="0"
                    max="100"
                    step="0.01"
                    {{ $required ? 'required' : '' }}>
                <span class="input-group-text">%</span>
            </div>
            @break

        @case('text')
            <textarea 
                name="{{ $fieldName }}" 
                class="form-control @if($error) is-invalid @endif"
                id="{{ $fieldId }}"
                rows="4"
                placeholder="Ketik jawaban Anda di sini..."
                {{ $required ? 'required' : '' }}>{{ $value }}</textarea>
            @break

        @case('multiple_choice')
            @if($answerOptions)
                <select 
                    name="{{ $fieldName }}" 
                    class="form-select @if($error) is-invalid @endif"
                    id="{{ $fieldId }}"
                    {{ $required ? 'required' : '' }}>
                    <option value="">Pilih opsi</option>
                    @foreach($answerOptions as $option)
                        <option value="{{ $option['value'] }}" @if($value == $option['value']) selected @endif>
                            {{ $option['label'] }}
                        </option>
                    @endforeach
                </select>
            @else
                <input type="text" 
                    name="{{ $fieldName }}" 
                    class="form-control @if($error) is-invalid @endif"
                    id="{{ $fieldId }}"
                    value="{{ $value }}"
                    placeholder="Pilih opsi..."
                    {{ $required ? 'required' : '' }}>
            @endif
            @break

        @case('file')
            <div class="mb-3">
                <input type="file" 
                    name="{{ $fieldName }}" 
                    class="form-control @if($error) is-invalid @endif"
                    id="{{ $fieldId }}"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                    {{ $required ? 'required' : '' }}>
                @if($value)
                    <div class="mt-2">
                        <a href="{{ asset('storage/' . $value) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-download me-1"></i>Lihat File
                        </a>
                    </div>
                @endif
                <div class="form-text small text-muted">
                    Format: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG. Maks 10MB.
                </div>
            </div>
            @break

        @default
            <input type="text" 
                name="{{ $fieldName }}" 
                class="form-control @if($error) is-invalid @endif"
                id="{{ $fieldId }}"
                value="{{ $value }}"
                placeholder="Jawaban Anda"
                {{ $required ? 'required' : '' }}>
    @endswitch
</div>
