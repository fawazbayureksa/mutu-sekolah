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

            // If no rows defined, create default rows (e.g., for year-based tables)
            if (empty($rows) && !empty($columns)) {
                // Check if first column is a year type
                $firstColKey = $columns[0]['key'] ?? '';
                if (in_array($firstColKey, ['year', 'tahun'])) {
                    // Create rows for last 3 years
                    $currentYear = date('Y');
                    $rows = [
                        ['label' => (string) ($currentYear - 2)],
                        ['label' => (string) ($currentYear - 1)],
                        ['label' => (string) $currentYear],
                    ];
                } else {
                    // Create 3 generic rows
                    $rows = [['label' => 'Data 1'], ['label' => 'Data 2'], ['label' => 'Data 3']];
                }
            }
        @endphp

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3">
            <div class="card-header bg-white border-bottom-0 py-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3" style="width: 40px; height: 40px; font-size: 1.2rem;">
                        <i class="bi bi-table"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-primary">Input Data Tabel</h6>
                        <small class="text-muted">Silahkan lengkapi data pada tabel di bawah ini</small>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    {{-- Initialize with empty array if no old value - JS will populate on load --}}
                    <input type="hidden" name="{{ $inputName }}" id="{{ $tableId }}-input"
                        value="{{ $oldValue ?: '[]' }}">
                    <table class="table table-hover mb-0 instrument-table" id="{{ $tableId }}"
                        data-item-id="{{ $itemId }}">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3 px-4 border-0 text-secondary text-uppercase small fw-bold">Uraian</th>
                                @foreach ($columns as $col)
                                    <th class="py-3 px-4 border-0 text-secondary text-uppercase small fw-bold"
                                        style="width: {{ $col['width'] ?? 'auto' }}">{{ $col['label'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Parse old value ONCE if available
                                $oldData = $oldValue ? json_decode($oldValue, true) : [];
                            @endphp
                            @foreach ($rows as $rowIndex => $row)
                                @php
                                    $rowValues = $oldData[$rowIndex] ?? [];
                                @endphp
                                <tr data-row-index="{{ $rowIndex }}">
                                    <td class="px-4 py-3 align-middle fw-medium text-dark border-bottom-0 border-top">
                                        {{ $row['label'] }}</td>
                                    @foreach ($columns as $colIndex => $col)
                                        <td class="px-4 py-3 border-bottom-0 border-top">
                                            @if ($col['read_only'] ?? false)
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control form-control-sm bg-light border-0 fw-bold text-primary table-input"
                                                        data-type="{{ $col['type'] }}" data-key="{{ $col['key'] }}"
                                                        data-row="{{ $rowIndex }}"
                                                        data-table-id="{{ $tableId }}"
                                                        value="{{ $rowValues[$col['key']] ?? '' }}" readonly
                                                        @if (isset($col['calculate'])) data-calculate="{{ $col['calculate'] }}" @endif>
                                                    @if ($col['type'] === 'percentage')
                                                        <span
                                                            class="input-group-text bg-light border-0 text-primary fw-bold">%</span>
                                                    @endif
                                                </div>
                                            @else
                                                <input
                                                    type="{{ $col['type'] === 'number' || $col['type'] === 'percentage' ? 'number' : 'text' }}"
                                                    class="form-control form-control-sm border-light bg-light-subtle focus-ring table-input"
                                                    style="transition: all 0.2s;" data-type="{{ $col['type'] }}"
                                                    data-key="{{ $col['key'] }}" data-row="{{ $rowIndex }}"
                                                    data-table-id="{{ $tableId }}"
                                                    value="{{ $rowValues[$col['key']] ?? '' }}"
                                                    @if ($col['type'] === 'number' || $col['type'] === 'percentage') step="0.01" @endif
                                                    @if ($col['type'] === 'percentage') min="0" max="100" @endif
                                                    @if (isset($col['calculate'])) data-calculate="{{ $col['calculate'] }}" @endif>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
            value="{{ $oldValue }}" step="0.01" {{ $isRequired ? 'required' : '' }}
            @if ($answerType === 'percentage') min="0" max="100" @endif>

        {{-- TEXT / TEXTAREA TYPE --}}
    @elseif($answerType === 'text')
        <textarea class="form-control" name="{{ $inputName }}" rows="3" {{ $isRequired ? 'required' : '' }}>{{ $oldValue }}</textarea>

        {{-- DEFAULT / FALLBACK for unknown types --}}
    @else
        <input type="text" class="form-control" name="{{ $inputName }}" value="{{ $oldValue }}"
            {{ $isRequired ? 'required' : '' }} placeholder="Masukkan jawaban (type: {{ $answerType ?? 'unknown' }})">
    @endif
</div>
