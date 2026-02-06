@props(['question', 'item'])

@php
    $isRequired = $question->is_required;
    $answerType = $question->answer_type;
    $options = $question->getAnswerOptionsArray();
    $scaleTemplate = $question->scaleTemplate;
    $itemId = $item->id;
    $inputName = "answers[{$itemId}]";
    $oldValue = old("answers.{$itemId}");
@endphp

<div class="answer-input-container">
    {{-- STRUCTURE / TABLE TYPE --}}
    @if ($answerType === 'structure')
        @php
            $config = $options;
            $columns = $config['columns'] ?? [];
            $rows = $config['rows'] ?? [];
            $tableId = "table-{$itemId}";
        @endphp

        <div class="table-responsive">
            <input type="hidden" name="{{ $inputName }}" id="{{ $tableId }}-input" value="{{ $oldValue }}">
            <table class="table table-bordered table-hover instrument-table" id="{{ $tableId }}"
                data-item-id="{{ $itemId }}">
                <thead class="table-light">
                    <tr>
                        <th>Uraian</th>
                        @foreach ($columns as $col)
                            <th style="width: {{ $col['width'] ?? 'auto' }}">{{ $col['label'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $rowIndex => $row)
                        <tr data-row-index="{{ $rowIndex }}">
                            <td>{{ $row['label'] }}</td>
                            @foreach ($columns as $colIndex => $col)
                                <td>
                                    @if ($col['read_only'] ?? false)
                                        <input type="text" class="form-control form-control-sm table-input"
                                            data-type="{{ $col['type'] }}" data-key="{{ $col['key'] }}" disabled
                                            readonly>
                                    @else
                                        <input
                                            type="{{ $col['type'] === 'number' || $col['type'] === 'percentage' ? 'number' : 'text' }}"
                                            class="form-control form-control-sm table-input"
                                            data-type="{{ $col['type'] }}" data-key="{{ $col['key'] }}"
                                            data-row="{{ $rowIndex }}"
                                            @if ($col['type'] === 'percentage') min="0" max="100" step="0.01" @endif
                                            @if (isset($col['calculate'])) data-calculate="{{ $col['calculate'] }}" @endif
                                            onchange="updateTableValue('{{ $tableId }}')">
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- SCALE / RADIO TYPE --}}
    @elseif($answerType === 'scale' || $answerType === 'multiple_choice')
        <div class="d-flex flex-wrap gap-3">
            @foreach ($options as $opt)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="{{ $inputName }}"
                        id="opt-{{ $itemId }}-{{ $loop->index }}" value="{{ $opt['value'] }}"
                        {{ $oldValue == $opt['value'] ? 'checked' : '' }} {{ $isRequired ? 'required' : '' }}>
                    <label class="form-check-label" for="opt-{{ $itemId }}-{{ $loop->index }}">
                        {{ $opt['label'] }}
                    </label>
                </div>
            @endforeach
        </div>

        {{-- BOOLEAN TYPE --}}
    @elseif($answerType === 'boolean')
        <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="{{ $inputName }}" id="bool-y-{{ $itemId }}"
                value="Yes" {{ $oldValue === 'Yes' ? 'checked' : '' }} {{ $isRequired ? 'required' : '' }}>
            <label class="btn btn-outline-success" for="bool-y-{{ $itemId }}">Ya</label>

            <input type="radio" class="btn-check" name="{{ $inputName }}" id="bool-n-{{ $itemId }}"
                value="No" {{ $oldValue === 'No' ? 'checked' : '' }} {{ $isRequired ? 'required' : '' }}>
            <label class="btn btn-outline-danger" for="bool-n-{{ $itemId }}">Tidak</label>
        </div>

        {{-- NUMBER / PERCENTAGE TYPE --}}
    @elseif($answerType === 'number' || $answerType === 'percentage')
        <input type="number" class="form-control" style="max-width: 200px" name="{{ $inputName }}"
            value="{{ $oldValue }}" {{ $isRequired ? 'required' : '' }}
            @if ($answerType === 'percentage') min="0" max="100" @endif>

        {{-- TEXT / TEXTAREA TYPE --}}
    @elseif($answerType === 'text')
        <textarea class="form-control" name="{{ $inputName }}" rows="3" {{ $isRequired ? 'required' : '' }}>{{ $oldValue }}</textarea>
    @endif
</div>
