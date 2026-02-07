@extends('layouts.admin')

@section('title', 'Instruments - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Instrument Management</h2>
        <p class="text-muted mb-0">Manage assessment instruments and question banks</p>
    </div>
    <a href="{{ route('admin.instruments.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Create Instrument
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.instruments.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search instruments..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Category</label>
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <option value="akreditasi" {{ request('category') === 'akreditasi' ? 'selected' : '' }}>Akreditasi</option>
                    <option value="sertifikasi" {{ request('category') === 'sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
                    <option value="pelatihan" {{ request('category') === 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.instruments.export') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-download me-1"></i>Export
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Total: {{ $instruments->total() }} instruments</span>
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-gear me-1"></i>Bulk Actions
            </button>
            <ul class="dropdown-menu">
                <li><a href="#" class="dropdown-item" onclick="submitBulkAction('activate')">Activate Selected</a></li>
                <li><a href="#" class="dropdown-item" onclick="submitBulkAction('deactivate')">Deactivate Selected</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a href="#" class="dropdown-item text-danger" onclick="submitBulkAction('delete')">Delete Selected</a></li>
            </ul>
        </div>
    </div>
    <div class="table-responsive">
        <form id="bulkActionForm" action="{{ route('admin.instruments.bulk') }}" method="POST">
            @csrf
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="40">
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Version</th>
                        <th>Status</th>
                        <th>Questions</th>
                        <th>Created At</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($instruments as $instrument)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input instrument-checkbox" name="instruments[]" value="{{ $instrument->id }}">
                            </td>
                            <td><strong>{{ $instrument->code }}</strong></td>
                            <td>{{ $instrument->name }}</td>
                            <td>{{ $instrument->category ?? '-' }}</td>
                            <td>{{ $instrument->version }}</td>
                            <td>
                                @if($instrument->is_published)
                                    <span class="badge badge-approved">Published</span>
                                @else
                                    <span class="badge badge-draft">Draft</span>
                                @endif
                                @if(!$instrument->is_active)
                                    <i class="bi bi-eye-slash text-muted"></i>
                                @endif
                            </td>
                            <td>{{ $instrument->items->count() }}</td>
                            <td>{{ $instrument->created_at->format('M j, Y') }}</td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.instruments.show', $instrument) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.instruments.edit', $instrument) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($instrument->is_published)
                                        <form action="{{ route('admin.instruments.unpublish', $instrument) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning" title="Unpublish">
                                                <i class="bi bi-arrow-down-circle"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.instruments.publish', $instrument) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Publish">
                                                <i class="bi bi-arrow-up-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.instruments.duplicate', $instrument) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to duplicate this instrument?')">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-sm btn-outline-info" title="Duplicate">
                                            <i class="bi bi-copy"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.instruments.destroy', $instrument) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this instrument?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-clipboard-data fs-1 d-block mb-3"></i>
                                    <p class="mb-0">No instruments found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <input type="hidden" name="action" id="bulkActionInput">
        </form>
    </div>
    @if($instruments->hasPages())
        <div class="card-footer">
            {{ $instruments->appends(request()->all())->links() }}
        </div>
    @endif
</div>

<script>
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('.instrument-checkbox').forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

function submitBulkAction(action) {
    const checked = document.querySelectorAll('.instrument-checkbox:checked');
    if (checked.length === 0) {
        alert('Please select at least one instrument');
        return;
    }
    if (confirm(`Are you sure you want to ${action} selected instruments?`)) {
        document.getElementById('bulkActionInput').value = action;
        document.getElementById('bulkActionForm').submit();
    }
}
</script>
@endsection
