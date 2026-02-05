<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <strong>Filters</strong>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="resetFilters()">
            <i class="bi bi-arrow-counterclockwise"></i> Reset
        </button>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.instruments.index') }}" method="GET" class="row g-3">
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
                <label class="form-label">Version</label>
                <input type="text" name="version" class="form-control" placeholder="e.g. 1.0" value="{{ request('version') }}">
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
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i>Apply Filters
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function resetFilters() {
    window.location.href = '{{ route('admin.instruments.index') }}';
}
</script>
