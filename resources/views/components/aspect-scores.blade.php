@props([
    'aspectScores' => [],
])

<div class="aspect-scores-card bg-white rounded-3 shadow-sm p-4">
    <h6 class="fw-bold mb-3">
        <i class="bi bi-pie-chart me-2"></i>Skor per Aspek
    </h6>

    @if(empty($aspectScores))
        <div class="alert alert-info small mb-0">
            <i class="bi bi-info-circle me-1"></i>
            Belum ada data skor aspek
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Aspek</th>
                        <th class="text-center">Skor</th>
                        <th class="text-center">%</th>
                        <th class="text-center">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aspectScores as $aspect)
                        <tr>
                            <td>
                                <div>
                                    <small class="text-muted d-block">{{ $aspect['aspect_code'] ?? '' }}</small>
                                    <span class="fw-semibold">{{ $aspect['aspect_name'] }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold">{{ number_format($aspect['total_score'], 2) }}</span>
                                <small class="text-muted d-block">/ {{ number_format($aspect['max_score'], 2) }}</small>
                            </td>
                            <td class="text-center">
                                <div class="progress" style="height: 6px; width: 80px; margin: 0 auto;">
                                    <div class="progress-bar {{ $aspect['percentage'] >= 70 ? 'bg-success' : ($aspect['percentage'] >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                        style="width: {{ $aspect['percentage'] }}%">
                                    </div>
                                </div>
                                <span class="small">{{ number_format($aspect['percentage'], 1) }}%</span>
                            </td>
                            <td class="text-center">
                                @switch($aspect['grade'])
                                    @case('A')
                                        <span class="badge bg-success">{{ $aspect['grade'] }}</span>
                                        @break
                                    @case('B')
                                        <span class="badge bg-primary">{{ $aspect['grade'] }}</span>
                                        @break
                                    @case('C')
                                        <span class="badge bg-warning text-dark">{{ $aspect['grade'] }}</span>
                                        @break
                                    @case('D')
                                        <span class="badge bg-danger text-white">{{ $aspect['grade'] }}</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $aspect['grade'] ?? '-' }}</span>
                                @endswitch
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
