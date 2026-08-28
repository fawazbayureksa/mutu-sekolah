@props([
    'title',
    'subtitle' => null,
])

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <div>
            <h5 class="card-title fw-bold mb-0 text-dark">{{ $title }}</h5>
            @if ($subtitle)
                <p class="text-muted small mb-0 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
        @if (isset($headerAction))
            <div>
                {{ $headerAction }}
            </div>
        @endif
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
