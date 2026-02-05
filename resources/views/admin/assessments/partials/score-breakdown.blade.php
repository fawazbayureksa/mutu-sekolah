@php
    $aspectNames = [];
    $scores = [];
    $maxScores = [];
    $percentages = [];
    $index = 0;
    foreach ($scoreByAspect as $name => $data) {
        $aspectNames[] = $name;
        $scores[] = $data['score'];
        $maxScores[] = $data['max_score'];
        $percentages[] = $data['max_score'] > 0 ? ($data['score'] / $data['max_score']) * 100 : 0;
        $index++;
    }
    $totalScore = collect($scoreByAspect)->sum('score');
    $totalMaxScore = collect($scoreByAspect)->sum('max_score');
    $totalPercentage = $totalMaxScore > 0 ? ($totalScore / $totalMaxScore) * 100 : 0;
@endphp

<div class="mb-4">
    <canvas id="scoreChart" height="300"></canvas>
</div>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Aspect</th>
                <th width="120">Score</th>
                <th width="120">Max Score</th>
                <th width="100">Percentage</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scoreByAspect as $aspectName => $data)
                <tr>
                    <td>{{ $aspectName }}</td>
                    <td class="text-center">
                        <strong>{{ number_format($data['score'], 2) }}</strong>
                    </td>
                    <td class="text-center">
                        {{ number_format($data['max_score'], 2) }}
                    </td>
                    <td>
                        @php
                            $percentage = $data['max_score'] > 0 ? ($data['score'] / $data['max_score']) * 100 : 0;
                        @endphp
                        <div class="progress">
                            <div class="progress-bar 
                                @if ($percentage >= 80) bg-success
                                @elseif($percentage >= 60) bg-info
                                @elseif($percentage >= 40) bg-warning
                                @else bg-danger @endif"
                                role="progressbar" style="width: {{ $percentage }}%;"
                                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                {{ number_format($percentage, 1) }}%
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="table-light">
            <tr>
                <th>Total</th>
                <th class="text-center">
                    <strong>{{ number_format($totalScore, 2) }}</strong>
                </th>
                <th class="text-center">
                    {{ number_format($totalMaxScore, 2) }}
                </th>
                <th>
                    <div class="progress">
                        <div class="progress-bar 
                            @if ($totalPercentage >= 80) bg-success
                            @elseif($totalPercentage >= 60) bg-info
                            @elseif($totalPercentage >= 40) bg-warning
                            @else bg-danger @endif"
                            role="progressbar" style="width: {{ $totalPercentage }}%;"
                            aria-valuenow="{{ $totalPercentage }}" aria-valuemin="0" aria-valuemax="100">
                            {{ number_format($totalPercentage, 1) }}%
                        </div>
                    </div>
                </th>
            </tr>
        </tfoot>
    </table>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('scoreChart');
        if (!ctx) return;

        const aspectNames = {{ json_encode($aspectNames) }};
        const scores = {{ json_encode($scores) }};
        const maxScores = {{ json_encode($maxScores) }};
        const percentages = {{ json_encode($percentages) }};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: aspectNames,
                datasets: [
                    {
                        label: 'Score',
                        data: scores,
                        backgroundColor: 'rgba(13, 110, 253, 0.7)',
                        borderColor: 'rgba(13, 110, 253, 1)',
                        borderWidth: 1,
                        yAxisID: 'y',
                    },
                    {
                        label: 'Max Score',
                        data: maxScores,
                        backgroundColor: 'rgba(108, 117, 125, 0.3)',
                        borderColor: 'rgba(108, 117, 125, 1)',
                        borderWidth: 1,
                        type: 'line',
                        yAxisID: 'y',
                        fill: false,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Score'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            afterBody: function(context) {
                                const index = context[0].dataIndex;
                                const percentage = percentages[index];
                                return 'Percentage: ' + percentage.toFixed(1) + '%';
                            }
                        }
                    }
                }
            }
        });
    });
    </script>
@endpush
