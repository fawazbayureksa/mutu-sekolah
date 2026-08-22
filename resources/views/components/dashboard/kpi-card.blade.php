@props([
    'title',
    'value' => 0,
    'subtitle' => null,
    'icon' => null,
    'variant' => 'default', // default, primary, success, warning, info, danger
])

@php
    $variantClasses = [
        'default' => ['bg' => 'bg-white', 'text' => 'text-dark', 'icon_bg' => 'bg-light text-primary'],
        'primary' => ['bg' => 'bg-primary text-white', 'text' => 'text-white', 'icon_bg' => 'bg-white bg-opacity-25 text-white'],
        'success' => ['bg' => 'bg-success text-white', 'text' => 'text-white', 'icon_bg' => 'bg-white bg-opacity-25 text-white'],
        'warning' => ['bg' => 'bg-warning text-dark', 'text' => 'text-dark', 'icon_bg' => 'bg-dark bg-opacity-10 text-dark'],
        'info' => ['bg' => 'bg-info text-white', 'text' => 'text-white', 'icon_bg' => 'bg-white bg-opacity-25 text-white'],
        'danger' => ['bg' => 'bg-danger text-white', 'text' => 'text-white', 'icon_bg' => 'bg-white bg-opacity-25 text-white'],
    ];

    $style = $variantClasses[$variant] ?? $variantClasses['default'];
@endphp

<div class="card shadow-sm border-0 h-100 {{ $style['bg'] }}">
    <div class="card-body p-3 d-flex align-items-center justify-content-between">
        <div>
            <span class="text-uppercase fw-semibold small {{ $variant === 'default' ? 'text-muted' : 'opacity-75' }}" style="letter-spacing: 0.5px; font-size: 0.75rem;">
                {{ $title }}
            </span>
            <h3 class="fw-bold mb-0 mt-1 {{ $style['text'] }}">
                {{ is_numeric($value) ? number_format($value) : $value }}
            </h3>
            @if ($subtitle)
                <small class="{{ $variant === 'default' ? 'text-muted' : 'opacity-75' }} d-block mt-1">
                    {{ $subtitle }}
                </small>
            @endif
        </div>
        @if ($icon)
            <div class="rounded-3 p-3 d-flex align-items-center justify-content-center flex-shrink-0 {{ $style['icon_bg'] }}" style="width: 48px; height: 48px;">
                <i class="bi {{ $icon }} fs-4"></i>
            </div>
        @endif
    </div>
</div>
