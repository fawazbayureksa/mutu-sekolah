<div class="btn-group btn-group-sm" role="group">
    <a href="{{ route('admin.assessments.show', $assessment) }}" class="btn btn-outline-info" title="View">
        <i class="bi bi-eye"></i>
    </a>

    @if (in_array($assessment->status, ['draft', 'rejected']))
        <a href="{{ route('admin.assessments.answers.index', $assessment) }}" class="btn btn-outline-primary"
            title="Fill Answers">
            <i class="bi bi-pencil-square"></i>
        </a>
        <a href="{{ route('admin.assessments.edit', $assessment) }}" class="btn btn-outline-secondary" title="Edit">
            <i class="bi bi-gear"></i>
        </a>
    @endif

    @if ($assessment->status === 'draft')
        <form action="{{ route('admin.assessments.destroy', $assessment) }}" method="POST" class="d-inline"
            onsubmit="return confirm('Are you sure you want to delete this assessment?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger" title="Delete">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    @endif
</div>
