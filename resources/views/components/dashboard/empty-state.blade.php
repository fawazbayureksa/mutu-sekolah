@props([
    'message' => 'Belum ada data tersedia',
    'hint' => null,
    'icon' => 'bi-inbox',
])

<div class="text-center py-5">
    <div class="text-muted">
        <i class="bi {{ $icon }} fs-1 d-block mb-3 opacity-50"></i>
        <h6 class="fw-semibold text-secondary mb-1">{{ $message }}</h6>
        @if ($hint)
            <p class="small text-muted mb-0">{{ $hint }}</p>
        @endif
    </div>
</div>
