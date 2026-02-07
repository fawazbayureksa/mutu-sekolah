@extends('layouts.admin')

@section('title', 'Instrument Details - ' . $instrument->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Instrument Details</h2>
        <p class="text-muted mb-0">View instrument information and questions</p>
    </div>
    <div class="btn-group">
        <a href="{{ route('admin.instruments.edit', $instrument) }}" class="btn btn-outline-primary">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
        <a href="{{ route('admin.instruments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <strong>Instrument Information</strong>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th width="30%">Code:</th>
                        <td><code>{{ $instrument->code }}</code></td>
                    </tr>
                    <tr>
                        <th width="30%">Name:</th>
                        <td><strong>{{ $instrument->name }}</strong></td>
                    </tr>
                    <tr>
                        <th width="30%">Category:</th>
                        <td>{{ $instrument->category ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Version:</th>
                        <td>{{ $instrument->version }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Status:</th>
                        <td>
                            @if($instrument->is_published)
                                <span class="badge badge-approved">Published</span>
                            @else
                                <span class="badge badge-draft">Draft</span>
                            @endif
                            @if(!$instrument->is_active)
                                <i class="bi bi-eye-slash text-muted" title="Inactive"></i>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th width="30%">Created:</th>
                        <td>{{ $instrument->created_at->format('M j, Y g:i A') }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Scoring Method:</th>
                        <td>
                            @if($instrument->scoring_method === 'simple_sum')
                                Simple Sum
                            @elseif($instrument->scoring_method === 'weighted_sum')
                                Weighted Sum
                            @elseif($instrument->scoring_method === 'average')
                                Average
                            @elseif($instrument->scoring_method === 'percentage')
                                Percentage
                            @else
                                {{ $instrument->scoring_method }}
                            @endif
                        </td>
                    </tr>
                </table>

                @if($instrument->instructions)
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="mb-2">Instructions</h6>
                        <p class="mb-0">{{ $instrument->instructions }}</p>
                    </div>
                @endif

                @if($instrument->description)
                    <div class="mt-4 pt-4 border-top">
                        <h6 class="mb-2">Description</h6>
                        <p class="mb-0">{{ $instrument->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Questions ({{ $instrument->items->count() }})</strong>
            </div>
            <div class="card-body">
                @if($instrument->items->count() > 0)
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Question</th>
                                <th>Type</th>
                                <th>Required</th>
                                <th>Aspect</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($instrument->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $item->question->question_code ?? 'Q' . ($index + 1) }}</strong>
                                        <small class="text-muted">{{ Str::limit($item->question->question_text, 80) }}</small>
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
                                        @if($item->question->indicator && $item->question->indicator->aspect)
                                            {{ $item->question->indicator->aspect->name }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted text-center">No questions added to this instrument</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Aspects ({{ $instrument->aspects->count() }})</strong>
            </div>
            <div class="card-body">
                @if($instrument->aspects->count() > 0)
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Aspect Name</th>
                                <th>Weight</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($instrument->aspects as $index => $aspect)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $aspect->name }}</strong></td>
                                    <td>{{ $aspect->pivot->weight ?? 1.0 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted text-center">No aspects configured</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <strong>Statistics</strong>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6 text-center">
                        <h4 class="mb-0">{{ $instrument->items->count() }}</h4>
                        <small class="text-muted">Total Questions</small>
                    </div>
                </div>
                <div class="col-6 text-center">
                    <h4 class="mb-0">{{ $instrument->aspects->count() }}</h4>
                        <small class="text-muted">Aspects</small>
                    </div>
                </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <small class="text-muted">Created By:</small>
                        <div><strong>{{ $instrument->creator->name ?? 'System' }}</strong></div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Last Updated:</small>
                        <div><strong>{{ $instrument->updater->name ?? 'System' }}</strong></div>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <small class="text-muted">Created:</small>
                        <div>{{ $instrument->created_at->format('F j, Y') }}</div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Estimated Duration:</small>
                        <div>{{ $instrument->estimated_duration ? $instrument->estimated_duration . ' min' : '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Actions</strong>
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="{{ route('admin.instruments.edit', $instrument) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>Edit Instrument
                </a>
                @if($instrument->is_published)
                    <form action="{{ route('admin.instruments.unpublish', $instrument) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning">
                            <i class="bi bi-arrow-down-circle me-2"></i>Unpublish
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.instruments.publish', $instrument) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-success">
                            <i class="bi bi-arrow-up-circle me-2"></i>Publish
                        </button>
                    </form>
                @endif
                <form action="{{ route('admin.instruments.duplicate', $instrument) }}" method="POST"
                    @csrf
                    <button type="submit" class="btn btn-outline-info">
                        <i class="bi bi-copy me-2"></i>Duplicate
                    </button>
                </form>
                <form action="{{ route('admin.instruments.destroy', $instrument) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this instrument? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-trash me-2"></i>Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Usage Statistics</strong>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <h4 class="mb-0">Assessments</h4>
                        <small class="text-muted">Using this instrument</small>
                        <div class="mt-2"><strong>{{ $instrument->assessments->count() }}</strong></div>
                    </div>
                    <div class="col-6">
                        <h4 class="mb-0">Submissions</h4>
                        <small class="text-muted">Using this instrument</small>
                        <div class="mt-2"><strong>{{ $instrument->submissions->count() }}</strong></div>
                    </div>
                </div>
                <hr>
                <div class="mb-0">
                    <small class="text-muted">Last activity:</small>
                    <div>
                        @if($instrument->updated_at > $instrument->created_at)
                            {{ $instrument->updated_at->diffForHumans() }}
                        @else
                            Never
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
