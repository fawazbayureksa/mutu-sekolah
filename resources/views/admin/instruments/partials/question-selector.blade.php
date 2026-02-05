<div class="modal fade" id="questionSelectorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Questions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="questionSearch" class="form-control" placeholder="Search questions...">
                    </div>
                    <div class="col-md-3">
                        <select id="aspectFilter" class="form-select">
                            <option value="">All Aspects</option>
                            @foreach($aspects ?? collect() as $aspect)
                                <option value="{{ $aspect->id }}">{{ $aspect->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="answerTypeFilter" class="form-select">
                            <option value="">All Types</option>
                            <option value="text">Text</option>
                            <option value="number">Number</option>
                            <option value="multiple_choice">Multiple Choice</option>
                            <option value="scale">Scale</option>
                            <option value="boolean">Boolean</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-secondary w-100" onclick="applyQuestionFilters()">Filter</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" class="form-check-input" id="selectAllQuestions">
                                </th>
                                <th width="80">Code</th>
                                <th>Question Text</th>
                                <th width="100">Type</th>
                                <th width="150">Aspect</th>
                            </tr>
                        </thead>
                        <tbody id="questionsTableBody">
                            @foreach($questions ?? collect() as $question)
                                <tr class="question-row" data-question-id="{{ $question->id }}">
                                    <td>
                                        <input type="checkbox" class="form-check-input question-checkbox"
                                               value="{{ $question->id }}"
                                               data-question-code="{{ $question->question_code }}"
                                               data-question-text="{{ $question->question_text }}">
                                    </td>
                                    <td><strong>{{ $question->question_code }}</strong></td>
                                    <td>
                                        <strong>{{ $question->question_text }}</strong>
                                        @if($question->is_required)
                                            <span class="text-danger ms-2">*</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $question->answer_type }}</span>
                                    </td>
                                    <td>
                                        @if($question->indicator && $question->indicator->aspect)
                                            {{ $question->indicator->aspect->name }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        No questions available
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addSelectedQuestions()">
                    <i class="bi bi-plus-lg me-1"></i>Add Selected ({{ $('#questionSelectorModal .question-checkbox:checked').length }})
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let selectedQuestions = [];

$(document).ready(function() {
    $('#selectAllQuestions').on('change', function() {
        $('.question-checkbox').prop('checked', this.checked);
        updateSelectedCount();
    });

    $('.question-checkbox').on('change', function() {
        updateSelectedCount();
    });

    $('#questionSearch').on('keyup', function() {
        filterQuestions();
    });

    $('#aspectFilter').on('change', function() {
        filterQuestions();
    });

    $('#answerTypeFilter').on('change', function() {
        filterQuestions();
    });
});

function filterQuestions() {
    const search = $('#questionSearch').val().toLowerCase();
    const aspect = $('#aspectFilter').val();
    const type = $('#answerTypeFilter').val();

    $('.question-row').each(function() {
        const row = $(this);
        const questionText = row.find('td:nth-child(3)').text().toLowerCase();
        const questionCode = row.find('td:nth-child(2)').text().toLowerCase();
        const rowAspect = row.attr('data-aspect');
        const rowType = row.attr('data-type');

        let show = true;

        if (search && !questionText.includes(search) && !questionCode.includes(search)) {
            show = false;
        }

        if (aspect && rowAspect !== aspect) {
            show = false;
        }

        if (type && rowType !== type) {
            show = false;
        }

        row.toggle(show);
    });
}

function updateSelectedCount() {
    const count = $('.question-checkbox:checked').length;
    $('#questionSelectorModal .btn-primary span').text(`Add Selected (${count})`);
}

function addSelectedQuestions() {
    const checkboxes = $('.question-checkbox:checked');
    
    checkboxes.each(function() {
        const questionId = $(this).val();
        const questionCode = $(this).data('question-code');
        const questionText = $(this).data('question-text');
        
        selectedQuestions.push({
            question_id: questionId,
            question_code: questionCode,
            question_text: questionText
        });
    });

    renderSelectedQuestions();
    $('#questionSelectorModal').modal('hide');
    
    checkboxes.prop('checked', false);
    $('#selectAllQuestions').prop('checked', false);
    updateSelectedCount();
}

function renderSelectedQuestions() {
    const container = $('#selectedQuestionsContainer');
    container.empty();

    selectedQuestions.forEach((question, index) => {
        container.append(`
            <tr data-question-index="${index}">
                <td width="50">
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeQuestion(${index})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
                <td width="100">
                    <input type="hidden" name="questions[${index}][question_id]" value="${question.question_id}">
                    <strong>${question.question_code}</strong>
                </td>
                <td>${question.question_text}</td>
                <td width="150">
                    <input type="text" name="questions[${index}][section]" class="form-control form-control-sm" placeholder="Section (optional)">
                </td>
            </tr>
        `);
    });

    if (selectedQuestions.length === 0) {
        container.html(`
            <tr>
                <td colspan="4" class="text-center py-4 text-muted">
                    No questions selected
                </td>
            </tr>
        `);
    }
}

function removeQuestion(index) {
    selectedQuestions.splice(index, 1);
    renderSelectedQuestions();
}
</script>
