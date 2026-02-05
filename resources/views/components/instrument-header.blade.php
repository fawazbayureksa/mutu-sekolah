@props([
    'instrument',
])

<div class="instrument-header bg-gradient-primary rounded-3 shadow-sm p-4 mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="mb-2">
                @if($instrument->code)
                    <span class="badge bg-light text-dark me-2">{{ $instrument->code }}</span>
                @endif
                @if($instrument->category)
                    <span class="badge bg-info">{{ $instrument->category }}</span>
                @endif
            </div>
            <h4 class="fw-bold mb-2">{{ $instrument->name }}</h4>
            @if($instrument->description)
                <p class="small text-white-50 mb-0">{{ $instrument->description }}</p>
            @endif
        </div>
        <div class="col-md-4 text-md-end">
            @if($instrument->estimated_duration)
                <div class="small text-white-50 mb-1">
                    <i class="bi bi-clock me-1"></i>
                    Estimasi: {{ $instrument->estimated_duration }} menit
                </div>
            @endif
            @if($instrument->version)
                <div class="small text-white-50">
                    <i class="bi bi-tag me-1"></i>
                    Versi {{ $instrument->version }}
                </div>
            @endif
        </div>
    </div>

    @if($instrument->instructions)
        <div class="mt-3 pt-3 border-top border-white border-opacity-25">
            <div class="small text-white-50">
                <strong>Instruksi:</strong> {{ $instrument->instructions }}
            </div>
        </div>
    @endif
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
    }
</style>
