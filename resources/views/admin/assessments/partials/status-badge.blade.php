@switch($status)
    @case('draft')
        <span class="badge bg-secondary">Draft</span>
    @break

    @case('submitted')
        <span class="badge bg-info">Submitted</span>
    @break

    @case('verified')
        <span class="badge bg-primary">Verified</span>
    @break

    @case('approved')
        <span class="badge bg-success">Approved</span>
    @break

    @case('rejected')
        <span class="badge bg-danger">Rejected</span>
    @break

    @default
        <span class="badge bg-secondary">{{ ucfirst($status) }}</span>
@endswitch
