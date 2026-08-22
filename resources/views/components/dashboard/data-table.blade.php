@props([
    'responsive' => true,
])

<div class="{{ $responsive ? 'table-responsive' : '' }}">
    <table class="table table-hover align-middle mb-0">
        @if (isset($thead))
            <thead class="table-light">
                {{ $thead }}
            </thead>
        @endif
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
