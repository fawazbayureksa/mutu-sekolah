@extends('layouts.admin')

@section('title', 'User Details - ' . $user->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">User Details</h2>
            <p class="text-muted mb-0">View user information and activity</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i>Edit
            </a>
            <a href="{{ route('admin.users.activity', $user) }}" class="btn btn-outline-secondary">
                <i class="bi bi-clock-history me-1"></i>Activity Log
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-person-circle" style="font-size: 5rem; color: #cbd5e1;"></i>
                    </div>
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        @if ($user->is_active)
                            <span class="badge badge-active fs-6">Active</span>
                        @else
                            <span class="badge badge-inactive fs-6">Inactive</span>
                        @endif
                        <span class="badge bg-primary fs-6">{{ ucfirst($user->role) }}</span>
                    </div>
                    <div class="d-flex gap-2">
                        @if ($user->is_active)
                            <form action="{{ route('admin.users.deactivate', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-dash-circle me-1"></i>Deactivate
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.activate', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-check-circle me-1"></i>Activate
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <strong>Change Password</strong>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-outline-secondary w-100" data-bs-toggle="modal"
                        data-bs-target="#changePasswordModal">
                        <i class="bi bi-key me-2"></i>Change Password
                    </button>
                    <button type="button" class="btn btn-danger w-100 mt-3" data-bs-toggle="modal"
                        data-bs-target="#resetPasswordModal">
                        <i class="bi bi-key me-2"></i>Reset Password
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>User Information</strong>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <small class="text-muted d-block">Full Name</small>
                            <strong>{{ $user->name }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Email</small>
                            <strong>{{ $user->email }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Phone</small>
                            <strong>{{ $user->phone ?? '-' }}</strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <small class="text-muted d-block">Role</small>
                            <strong>{{ ucfirst($user->role) }}</strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Status</small>
                            <strong>
                                @if ($user->is_active)
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-danger">Inactive</span>
                                @endif
                            </strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted d-block">Last Login</small>
                            <strong>{{ $user->last_login_at ? $user->last_login_at->format('M j, Y g:i A') : 'Never' }}</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Bio</small>
                        <p>{{ $user->bio ?: 'No bio provided' }}</p>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Account Created</small>
                            <strong>{{ $user->created_at->format('F j, Y g:i A') }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Last Updated</small>
                            <strong>{{ $user->updated_at->format('F j, Y g:i A') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <strong>Recent Activity</strong>
                    <a href="{{ route('admin.users.activity', $user) }}"
                        class="btn btn-sm btn-outline-secondary float-end">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    @if ($user->activityLogs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->activityLogs->take(5) as $activity)
                                        <tr>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $activity->action }}</span>
                                            </td>
                                            <td>{{ $activity->description }}</td>
                                            <td>{{ $activity->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No activity recorded yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- reset password modal --}}
    <div class="modal fade" id="resetPasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.users.reset-password', $user) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to reset the password for <strong>{{ $user->name }}</strong>? The new
                            password will be sent to the user's email.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.users.password', $user) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Current Password <span class="text-danger">*</span></label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
