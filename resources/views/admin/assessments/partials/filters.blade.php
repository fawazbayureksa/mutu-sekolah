<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Filter Assessments</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.assessments.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search code or school..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="school_id" class="form-select">
                    <option value="">All Schools</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
                            {{ $school->school_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="instrument_id" class="form-select">
                    <option value="">All Instruments</option>
                    @foreach ($instruments as $instrument)
                        <option value="{{ $instrument->id }}"
                            {{ request('instrument_id') == $instrument->id ? 'selected' : '' }}>
                            {{ $instrument->instrument_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted
                    </option>
                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="assessment_year" class="form-control" placeholder="Year"
                    value="{{ request('assessment_year') }}" min="2020" max="2030">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>
