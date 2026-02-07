@extends('layouts.admin')

@section('title', 'Assessments')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Assessments</h1>
            <div>
                <a href="{{ route('admin.assessments.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> New Assessment
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

        @include('admin.assessments.partials.filters')

        <div class="card mt-3">
            <div class="card-body">
                @if ($assessments->count() > 0)
                    <form id="bulkActionForm" action="{{ route('admin.assessments.bulkAction') }}" method="POST">
                        @csrf
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <input type="checkbox" id="selectAll" class="form-check-input me-2">
                                <label for="selectAll" class="form-check-label">Select All</label>
                            </div>
                            <div class="d-flex gap-2">
                                <select name="action" class="form-select form-select-sm" style="width: auto;" required>
                                    <option value="">Bulk Actions</option>
                                    <option value="delete">Delete Drafts</option>
                                    <option value="export">Export</option>
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
                                        <th>School</th>
                                        <th>Instrument</th>
                                        <th>Period</th>
                                        <th>Date</th>
                                        <th>Assessor</th>
                                        <th>Status</th>
                                        <th>Score</th>
                                        <th width="200">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assessments as $assessment)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="assessment_ids[]" value="{{ $assessment->id }}"
                                                    class="form-check-input assessment-checkbox">
                                            </td>
                                            <td>
                                                <code>{{ $assessment->assessment_code }}</code>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;"
                                                    title="{{ $assessment->school->school_name }}">
                                                    {{ $assessment->school->school_name }}
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $assessment->instrument->name }}</small>
                                            </td>
                                            <td>
                                                {{ $assessment->assessment_year }}<br>
                                                <small
                                                    class="text-muted">{{ ucfirst($assessment->assessment_period) }}</small>
                                            </td>
                                            <td>
                                                <small>{{ \Carbon\Carbon::parse($assessment->assessment_date)->format('M d, Y') }}</small>
                                            </td>
                                            <td>
                                                <small>{{ $assessment->assessor->name ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                @include('admin.assessments.partials.status-badge', [
                                                    'status' => $assessment->status,
                                                ])
                                            </td>
                                            <td>
                                                @if ($assessment->total_score)
                                                    <strong>{{ number_format($assessment->total_score, 2) }}</strong>
                                                    <small class="text-muted">/ {{ $assessment->max_score }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @include('admin.assessments.partials.actions', [
                                                    'assessment' => $assessment,
                                                ])
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $assessments->firstItem() }} to {{ $assessments->lastItem() }} of
                            {{ $assessments->total() }} assessments
                        </div>
                        <div>
                            {{ $assessments->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-clipboard-check" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="mt-3 text-muted">No assessments found. Click "New Assessment" to create your first
                            assessment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('selectAll')?.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.assessment-checkbox');
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            });

            document.querySelectorAll('.assessment-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allCheckboxes = document.querySelectorAll('.assessment-checkbox');
                    const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
                    document.getElementById('selectAll').checked = allChecked;
                });
            });
        </script>
    @endpush
@endsection
