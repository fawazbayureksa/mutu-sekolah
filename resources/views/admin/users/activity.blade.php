@extends('layouts.admin')

@section('title', 'Activity Log - ' . $user->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Activity Log</h2>
        <p class="text-muted mb-0">Activity history for {{ $user->name }}</p>
    </div>
    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to User
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.users.activity', $user) }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">From Date</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">To Date</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>Activity History</strong>
        <span class="badge bg-light text-dark float-end">{{ $activities->total() }} records</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Description</th>
                    <th>IP Address</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                    <tr>
                        <td>
                            <span class="badge bg-light text-dark">{{ $activity->action }}</span>
                        </td>
                        <td>{{ $activity->description }}</td>
                        <td><code class="small">{{ $activity->ip_address ?? '-' }}</code></td>
                        <td>
                            {{ $activity->created_at->format('M j, Y g:i A') }}
                            <br>
                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-clock-history fs-1 d-block mb-3"></i>
                                <p class="mb-0">No activity logs found</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($activities->hasPages())
        <div class="card-footer">
            {{ $activities->appends(request()->all())->links() }}
        </div>
    @endif
</div>
@endsection
