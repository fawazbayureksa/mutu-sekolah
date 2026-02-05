{{-- Answer input partial for different question types --}}
@php
    // Get answer options from question or scale template
    $options = [];
    if ($question->scale_template_id && $question->scaleTemplate) {
        $options = $question->scaleTemplate->getOptions();
    } elseif ($question->answer_options) {
        $options = is_array($question->answer_options)
            ? $question->answer_options
            : json_decode($question->answer_options, true) ?? [];
    }

    $inputName = "answers[{$question->id}]";
    $oldValue = old("answers.{$question->id}");
@endphp

<div class="answer-input mt-3">
    @switch($question->answer_type)
        @case('boolean')
            <div class="btn-group" role="group" aria-label="Yes/No options">
                @forelse($options as $option)
                    <input type="radio" class="btn-check" name="{{ $inputName }}"
                        id="q{{ $question->id }}_{{ $option['value'] }}" value="{{ $option['value'] }}"
                        @if ($oldValue === $option['value']) checked @endif {{ $question->is_required ? 'required' : '' }}>
                    <label class="btn btn-outline-primary" for="q{{ $question->id }}_{{ $option['value'] }}"
                        style="border-color: {{ $option['color'] ?? '#0d6efd' }};">
                        {{ $option['label'] }}
                    </label>
                @empty
                    {{-- Fallback to default Yes/No if no options --}}
                    <input type="radio" class="btn-check" name="{{ $inputName }}" id="yes_{{ $question->id }}"
                        value="yes" @if ($oldValue === 'yes') checked @endif
                        {{ $question->is_required ? 'required' : '' }}>
                    <label class="btn btn-outline-primary" for="yes_{{ $question->id }}">Ya</label>

                    <input type="radio" class="btn-check" name="{{ $inputName }}" id="no_{{ $question->id }}"
                        value="no" @if ($oldValue === 'no') checked @endif>
                    <label class="btn btn-outline-primary" for="no_{{ $question->id }}">Tidak</label>
                @endforelse
            </div>
        @break

        @case('scale')
        @case('multiple_choice')
            <div class="scale-options">
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($options as $option)
                        <div class="form-check form-check-inline scale-option">
                            <input type="radio" class="btn-check" name="{{ $inputName }}"
                                id="q{{ $question->id }}_opt{{ $loop->index }}" value="{{ $option['value'] }}"
                                @if ($oldValue === (string) $option['value']) checked @endif
                                {{ $question->is_required ? 'required' : '' }}>
                            <label class="btn btn-outline-secondary scale-btn"
                                for="q{{ $question->id }}_opt{{ $loop->index }}" data-score="{{ $option['score'] ?? '' }}"
                                style="--option-color: {{ $option['color'] ?? '#6c757d' }}">
                                <span class="option-label">{{ $option['label'] }}</span>
                                @if (isset($option['score']))
                                    <small class="d-block text-muted">({{ $option['score'] }} poin)</small>
                                @endif
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        @break

        @case('number')
            <input type="number" name="{{ $inputName }}" class="form-control" value="{{ $oldValue }}"
                placeholder="Masukkan nilai" @if ($question->min_score !== null) min="{{ $question->min_score }}" @endif
                @if ($question->max_score !== null) max="{{ $question->max_score }}" @endif
                {{ $question->is_required ? 'required' : '' }}>
            @if ($question->min_score !== null || $question->max_score !== null)
                <small class="text-muted">
                    @if ($question->min_score !== null && $question->max_score !== null)
                        Nilai antara {{ $question->min_score }} - {{ $question->max_score }}
                    @elseif($question->min_score !== null)
                        Nilai minimum: {{ $question->min_score }}
                    @else
                        Nilai maksimum: {{ $question->max_score }}
                    @endif
                </small>
            @endif
        @break

        @case('percentage')
            <div class="input-group" style="max-width: 200px;">
                <input type="number" name="{{ $inputName }}" class="form-control" value="{{ $oldValue }}"
                    placeholder="0-100" min="0" max="100" {{ $question->is_required ? 'required' : '' }}>
                <span class="input-group-text">%</span>
            </div>
        @break

        @case('text')

            @default
                <textarea name="{{ $inputName }}" class="form-control" rows="3" placeholder="Masukkan jawaban Anda"
                    {{ $question->is_required ? 'required' : '' }}>{{ $oldValue }}</textarea>
            @break

        @endswitch

        @error("answers.{$question->id}")
            <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror
    </div>

    <style>
        .scale-options .scale-btn {
            min-width: 120px;
            padding: 0.75rem 1rem;
            text-align: center;
            transition: all 0.2s;
            border-radius: 0.5rem !important;
        }

        .scale-options .scale-btn:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.1);
        }

        .scale-options .btn-check:checked+.scale-btn {
            background-color: var(--option-color, #0d6efd);
            color: white;
            border-color: var(--option-color, #0d6efd);
        }

        .scale-option .option-label {
            font-weight: 500;
        }
    </style>
