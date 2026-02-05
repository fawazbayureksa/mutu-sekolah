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
            @foreach ($scoreByAspect as $aspectName => $scores)
                <tr>
                    <td>{{ $aspectName }}</td>
                    <td class="text-center">
                        <strong>{{ number_format($scores['score'], 2) }}</strong>
                    </td>
                    <td class="text-center">
                        {{ number_format($scores['max_score'], 2) }}
                    </td>
                    <td>
                        @php
                            $percentage =
                                $scores['max_score'] > 0 ? ($scores['score'] / $scores['max_score']) * 100 : 0;
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
                    <strong>{{ number_format(collect($scoreByAspect)->sum('score'), 2) }}</strong>
                </th>
                <th class="text-center">
                    {{ number_format(collect($scoreByAspect)->sum('max_score'), 2) }}
                </th>
                <th>
                    @php
                        $totalScore = collect($scoreByAspect)->sum('score');
                        $totalMaxScore = collect($scoreByAspect)->sum('max_score');
                        $totalPercentage = $totalMaxScore > 0 ? ($totalScore / $totalMaxScore) * 100 : 0;
                    @endphp
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
