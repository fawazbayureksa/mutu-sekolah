@props([
    'status' => 'draft',
])

@php
    $statusMap = [
        \App\Models\InstrumentSubmissionV2::STATUS_DRAFT => [
            'class' => 'bg-secondary text-white',
            'label' => 'Draft',
            'icon'  => 'bi-pencil-square',
        ],
        \App\Models\InstrumentSubmissionV2::STATUS_SUBMITTED => [
            'class' => 'bg-primary text-white',
            'label' => 'Diajukan',
            'icon'  => 'bi-send',
        ],
        \App\Models\InstrumentSubmissionV2::STATUS_VERIFIED => [
            'class' => 'bg-info text-white',
            'label' => 'Terverifikasi',
            'icon'  => 'bi-patch-check',
        ],
        \App\Models\InstrumentSubmissionV2::STATUS_VALIDATED => [
            'class' => 'bg-success text-white',
            'label' => 'Tervalidasi',
            'icon'  => 'bi-check2-circle',
        ],
        \App\Models\InstrumentSubmissionV2::STATUS_REJECTED => [
            'class' => 'bg-danger text-white',
            'label' => 'Ditolak',
            'icon'  => 'bi-x-circle',
        ],
    ];

    $item = $statusMap[$status] ?? [
        'class' => 'bg-secondary text-white',
        'label' => ucfirst($status),
        'icon'  => 'bi-question-circle',
    ];
@endphp

<span class="badge {{ $item['class'] }} d-inline-flex align-items-center gap-1 px-2 py-1 fw-medium" style="font-size: 0.75rem;">
    <i class="bi {{ $item['icon'] }}"></i>
    <span>{{ $item['label'] }}</span>
</span>
