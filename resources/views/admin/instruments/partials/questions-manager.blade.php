<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Questions in Instrument</strong>
        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#questionSelectorModal">
            <i class="bi bi-plus-lg me-1"></i>Add Questions
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="questionsTable">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th width="100">Code</th>
                        <th>Question Text</th>
                        <th width="150">Type</th>
                        <th width="120">Required</th>
                        <th width="150">Section</th>
                        <th width="80" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="selectedQuestionsContainer">
                    @if(isset($instrument) && $instrument->items->count() > 0)
                        @foreach($instrument->items as $index => $item)
                            <tr data-question-id="{{ $item->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $item->question->question_code }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $item->question->question_text }}</strong>
                                    @if($item->custom_help_text)
                                        <small class="text-muted d-block">{{ $item->custom_help_text }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $item->question->answer_type }}</span>
                                </td>
                                <td>
                                    @if($item->question->is_required)
                                        <span class="text-success">Yes</span>
                                    @else
                                        <span class="text-muted">No</span>
                                    @endif
                                </td>
                                <td>
                                    <input type="text" 
                                           name="questions[{{ $index }}][section]" 
                                           class="form-control form-control-sm"
                                           placeholder="Section"
                                           value="{{ $item->section ?? '' }}">
                                    <input type="hidden" name="questions[{{ $index }}][item_id]" value="{{ $item->id }}">
                                </td>
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger" 
                                            onclick="removeQuestionRow({{ $item->id }})"
                                            title="Remove">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @elseif(isset($questions) && $questions->count() > 0)
                        @foreach($questions as $index => $question)
                            <tr data-question-id="{{ $question->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $question->question_code }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $question->question_text }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $question->answer_type }}</span>
                                </td>
                                <td>
                                    @if($question->is_required)
                                        <span class="text-success">Yes</span>
                                    @else
                                        <span class="text-muted">No</span>
                                    @endif
                                </td>
                                <td>
                                    <input type="text" 
                                           name="questions[{{ $index }}][section]" 
                                           class="form-control form-control-sm"
                                           placeholder="Section">
                                    <input type="hidden" name="questions[{{ $index }}][question_id]" value="{{ $question->id }}">
                                </td>
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger" 
                                            onclick="removeQuestionRow({{ $index }})"
                                            title="Remove">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-clipboard-x fs-1 d-block mb-3"></i>
                                    <p class="mb-0">No questions added to this instrument</p>
                                    <small>Click "Add Questions" to select questions from the library</small>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-light">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                <strong>Total:</strong> <span id="totalQuestionsCount">{{ ($instrument->items->count() ?? 0) + ($questions->count() ?? 0) }}</span> questions
            </small>
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-secondary" onclick="moveAllUp()">
                    <i class="bi bi-arrow-up"></i> Move All Up
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="moveAllDown()">
                    <i class="bi bi-arrow-down"></i> Move All Down
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function removeQuestionRow(questionId) {
    if (confirm('Are you sure you want to remove this question from the instrument?')) {
        $(`tr[data-question-id="${questionId}"]`).remove();
        updateQuestionNumbers();
        updateTotalCount();
    }
}

function moveQuestionUp(button) {
    const row = $(button).closest('tr');
    const prevRow = row.prev();
    
    if (prevRow.length > 0) {
        row.insertBefore(prevRow);
        updateQuestionNumbers();
    }
}

function moveQuestionDown(button) {
    const row = $(button).closest('tr');
    const nextRow = row.next();
    
    if (nextRow.length > 0) {
        row.insertAfter(nextRow);
        updateQuestionNumbers();
    }
}

function moveAllUp() {
    const rows = $('#questionsTable tbody tr').get().reverse();
    $(rows).each(function() {
        const prevRow = $(this).prev();
        if (prevRow.length > 0) {
            $(this).insertBefore(prevRow);
        }
    });
    updateQuestionNumbers();
}

function moveAllDown() {
    const rows = $('#questionsTable tbody tr');
    rows.each(function() {
        const nextRow = $(this).next();
        if (nextRow.length > 0) {
            $(this).insertAfter(nextRow);
        }
    });
    updateQuestionNumbers();
}

function updateQuestionNumbers() {
    $('#questionsTable tbody tr').each(function(index) {
        $(this).find('td:first').text(index + 1);
        
        const inputs = $(this).find('input[name^="questions"]');
        inputs.each(function() {
            const name = $(this).attr('name');
            if (name) {
                const newName = name.replace(/\[\d+\]/, `[${index}]`);
                $(this).attr('name', newName);
            }
        });
    });
}

function updateTotalCount() {
    const count = $('#questionsTable tbody tr').length;
    $('#totalQuestionsCount').text(count);
}

$(document).ready(function() {
    updateTotalCount();
});
</script>

@include('admin.instruments.partials.question-selector', [
    'questions' => $allQuestions ?? null,
    'aspects' => $aspects ?? null
])
