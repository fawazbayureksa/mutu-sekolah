@props([
    'assessment',
    'readonly' => false,
])

<div class="assessment-progress-card bg-white rounded-3 shadow-sm p-4">
    <div class="row g-3">
        <div class="col-12">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-graph-up-arrow me-2"></i>Progress Penilaian
            </h6>
        </div>

        @if($assessment->total_questions > 0)
            <div class="col-md-6">
                <div class="d-flex justify-content-between mb-2">
                    <span class="small text-muted">Kelengkapan Jawaban</span>
                    <span class="small fw-bold">{{ round($assessment->completion_percentage, 1) }}%</span>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar {{ $assessment->completion_percentage >= 100 ? 'bg-success' : 'bg-primary' }}" 
                        role="progressbar" 
                        style="width: {{ $assessment->completion_percentage }}%"
                        aria-valuenow="{{ $assessment->completion_percentage }}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                    </div>
                </div>
                <div class="small text-muted mt-1">
                    {{ $assessment->answered_questions }} dari {{ $assessment->total_questions }} pertanyaan
                </div>
            </div>

            @if($assessment->total_score !== null)
                <div class="col-md-6">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small text-muted">Skor Saat Ini</span>
                        <span class="small fw-bold">
                            {{ $assessment->grade ?? '-' }}
                        </span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar {{ $assessment->percentage >= 70 ? 'bg-success' : ($assessment->percentage >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                            role="progressbar" 
                            style="width: {{ $assessment->percentage }}%"
                            aria-valuenow="{{ $assessment->percentage }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                        </div>
                    </div>
                    <div class="small text-muted mt-1">
                        {{ number_format($assessment->total_score, 2) }} / {{ number_format($assessment->max_possible_score ?? 0, 2) }}
                        ({{ number_format($assessment->percentage, 1) }}%)
                    </div>
                </div>
            @endif
        @else
            <div class="col-12">
                <div class="alert alert-info small mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Mulai menjawab pertanyaan untuk melihat progress penilaian
                </div>
            </div>
        @endif

        @if($assessment->status)
            <div class="col-12 mt-3 pt-3 border-top">
                <div class="d-flex align-items-center">
                    <span class="small text-muted me-2">Status:</span>
                    @switch($assessment->status)
                        @case('draft')
                            <span class="badge bg-warning text-dark">Draf</span>
                            @break
                        @case('submitted')
                            <span class="badge bg-info">Terkirim</span>
                            @break
                        @case('verified')
                            <span class="badge bg-primary">Terverifikasi</span>
                            @break
                        @default
                            <span class="badge bg-secondary">{{ ucfirst($assessment->status) }}</span>
                    @endswitch
                </div>
            </div>
        @endif
    </div>
</div>
