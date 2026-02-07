@extends('layouts.admin')

@section('title', 'Question Library')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Question Library</h1>
            <div>
                <a href="{{ route('admin.questions.import') }}" class="btn btn-outline-primary">
                    <i class="bi bi-upload"></i> Import
                </a>
                <a href="{{ route('admin.questions.export') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-download"></i> Export
                </a>
                <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Question
                </a>
            </div>
        </div>

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

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Filter Questions</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.questions.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Search question..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="aspect_id" class="form-select">
                            <option value="">All Aspects</option>
                            @foreach ($aspects as $aspect)
                                <option value="{{ $aspect->id }}"
                                    {{ request('aspect_id') == $aspect->id ? 'selected' : '' }}>
                                    {{ $aspect->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="indicator_id" class="form-select">
                            <option value="">All Indicators</option>
                            @foreach ($indicators as $indicator)
                                <option value="{{ $indicator->id }}"
                                    {{ request('indicator_id') == $indicator->id ? 'selected' : '' }}>
                                    {{ $indicator->code . ' ' . $indicator->description }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="answer_type" class="form-select">
                            <option value="">All Types</option>
                            <option value="text" {{ request('answer_type') == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="number" {{ request('answer_type') == 'number' ? 'selected' : '' }}>Number
                            </option>
                            <option value="scale" {{ request('answer_type') == 'scale' ? 'selected' : '' }}>Scale</option>
                            <option value="choice" {{ request('answer_type') == 'choice' ? 'selected' : '' }}>Multiple
                                Choice</option>
                            <option value="date" {{ request('answer_type') == 'date' ? 'selected' : '' }}>Date</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                @if ($questions->count() > 0)
                    <form id="bulkActionForm" action="{{ route('admin.questions.bulkAction') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <input type="checkbox" id="selectAll" class="form-check-input me-2">
                                <label for="selectAll" class="form-check-label">Select All</label>
                            </div>
                            <div class="d-flex gap-2">
                                <select name="action" class="form-select form-select-sm" style="width: auto;" required>
                                    <option value="">Bulk Actions</option>
                                    <option value="activate">Activate</option>
                                    <option value="deactivate">Deactivate</option>
                                    <option value="delete">Delete</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Apply</button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="30"><input type="checkbox" class="form-check-input"></th>
                                        <th>Code</th>
                                        <th>Question</th>
                                        <th>Aspect/Indicator</th>
                                        <th>Type</th>
                                        <th>Weight</th>
                                        <th>Status</th>
                                        <th>Usage</th>
                                        <th width="200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($questions as $question)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="question_ids[]" value="{{ $question->id }}"
                                                    class="form-check-input question-checkbox">
                                            </td>
                                            <td>
                                                <code>{{ $question->question_code }}</code>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 300px;"
                                                    title="{{ $question->question_text }}">
                                                    {{ $question->question_text }}
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $question->indicator->aspect->name ?? 'N/A' }}<br>
                                                    <strong>{{ $question->indicator->code . ' ' . $question->indicator->description ?? 'N/A' }}</strong>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ ucfirst($question->answer_type) }}</span>
                                            </td>
                                            <td>{{ $question->weight }}</td>
                                            <td>
                                                @if ($question->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    {{ $question->instrumentItems()->count() }} instrument(s)
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('admin.questions.show', $question) }}"
                                                        class="btn btn-outline-info" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.questions.edit', $question) }}"
                                                        class="btn btn-outline-primary" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    @if ($question->is_active)
                                                        <form
                                                            action="{{ route('admin.questions.deactivate', $question) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-outline-warning"
                                                                title="Deactivate">
                                                                <i class="bi bi-pause-circle"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('admin.questions.activate', $question) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-outline-success"
                                                                title="Activate">
                                                                <i class="bi bi-play-circle"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('admin.questions.duplicate', $question) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-secondary"
                                                            title="Duplicate">
                                                            <i class="bi bi-files"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.questions.destroy', $question) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this question?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger"
                                                            title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $questions->firstItem() }} to {{ $questions->lastItem() }} of
                            {{ $questions->total() }} questions
                        </div>
                        <div>
                            {{ $questions->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-question-circle" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="mt-3 text-muted">No questions found. Click "Add Question" to create your first question.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('selectAll')?.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.question-checkbox');
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            });

            document.querySelectorAll('.question-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allCheckboxes = document.querySelectorAll('.question-checkbox');
                    const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
                    document.getElementById('selectAll').checked = allChecked;
                });
            });
        </script>
    @endpush
@endsection
