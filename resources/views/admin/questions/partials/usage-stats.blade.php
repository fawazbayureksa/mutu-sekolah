<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-bar-chart"></i> Usage Statistics
        </h5>
    </div>
    <div class="card-body">
        @if ($usageCount > 0)
            <div class="alert alert-info mb-3">
                <i class="bi bi-info-circle"></i>
                This question is used in <strong>{{ $usageCount }}</strong> instrument(s).
                <br>
                <small class="text-muted">You cannot delete questions that are in use.</small>
            </div>

            @if ($instruments->count() > 0)
                <h6 class="mb-3">Instruments using this question:</h6>
                <div class="list-group list-group-flush">
                    @foreach ($instruments as $instrument)
                        <a href="{{ route('admin.instruments.show', $instrument) }}"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $instrument->name }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-tag"></i>
                                    {{ $instrument->code ?? ($instrument->instrument_code ?? 'N/A') }}
                                    @if ($instrument->category)
                                        | <i class="bi bi-folder"></i> {{ ucfirst($instrument->category) }}
                                    @endif
                                </small>
                            </div>
                            <div>
                                @if ($instrument->is_published)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        @else
            <div class="alert alert-success mb-0">
                <i class="bi bi-check-circle"></i>
                This question is not used in any instruments yet.
                <br>
                <small class="text-muted">You can safely delete this question if needed.</small>
            </div>
        @endif
    </div>

    @if ($usageCount > 0)
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="bi bi-clock"></i> Last updated: {{ $question->updated_at->diffForHumans() }}
                </small>
                <a href="{{ route('admin.instruments.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-list"></i> View All Instruments
                </a>
            </div>
        </div>
    @endif
</div>

@if ($usageCount > 0)
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-exclamation-triangle"></i> Warning
            </h5>
        </div>
        <div class="card-body">
            <p class="mb-2">
                <strong>This question cannot be deleted</strong> because it is currently in use.
            </p>
            <p class="small text-muted mb-0">
                To delete this question, you must first remove it from all instruments that reference it.
            </p>
        </div>
    </div>
@endif
