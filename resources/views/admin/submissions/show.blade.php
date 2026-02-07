@extends('layouts.admin')

@section('title', 'Detail Submission')

@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Submission</h1>
            <a href="{{ route('admin.submissions.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Info Submission</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150" class="fw-bold">Sekolah</td>
                                <td>: {{ $submission->school->school_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Instrumen</td>
                                <td>: {{ $submission->instrument->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Tanggal Isi</td>
                                <td>: {{ $submission->filled_at ? $submission->filled_at->format('d M Y') : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150" class="fw-bold">Responden</td>
                                <td>: {{ $submission->respondent_name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Jabatan</td>
                                <td>: {{ $submission->respondent_position }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status</td>
                                <td>: <span
                                        class="badge bg-{{ $submission->status === 'submitted' ? 'success' : 'secondary' }}">{{ ucfirst($submission->status) }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Jawaban</h6>
            </div>
            <div class="card-body">
                @foreach ($submission->responses as $response)
                    <div class="mb-4 pb-3 border-bottom">
                        <div class="mb-2">
                            <span
                                class="badge bg-info mb-1">{{ $response->instrumentItem->question->question_code ?? '?' }}</span>
                            <p class="fw-bold mb-1">{{ $response->instrumentItem->question->question_text ?? '-' }}</p>
                        </div>

                        <div class="p-3 bg-light rounded">
                            @php
                                $question = $response->instrumentItem->question ?? null;
                                $answerType = $question->answer_type ?? 'text';
                            @endphp

                            @if ($answerType === 'structure')
                                @php
                                    $structureData = json_decode($response->answer, true);
                                    // Also get the configuration to know headers
                                    $config = $question ? $question->getAnswerOptionsArray() : [];
                                    $columns = $config['columns'] ?? [];
                                    $rows = $config['rows'] ?? [];
                                @endphp

                                @if (is_array($structureData) && count($structureData) > 0)
                                    <div class="table-responsive bg-white rounded shadow-sm">
                                        <table class="table table-sm table-bordered mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Uraian</th>
                                                    @foreach ($columns as $col)
                                                        <th>{{ $col['label'] }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($structureData as $rowIndex => $rowData)
                                                    <tr>
                                                        <td class="fw-medium">
                                                            {{ $rows[$rowIndex]['label'] ?? 'Row ' . ($rowIndex + 1) }}</td>
                                                        @foreach ($columns as $col)
                                                            <td>{{ $rowData[$col['key']] ?? '-' }}</td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted fst-italic mb-0">Empty table data</p>
                                @endif
                            @elseif ($answerType === 'scale')
                                <span class="badge bg-primary fs-6">{{ $response->answer }}</span>
                            @else
                                {{ $response->answer }}
                            @endif
                        </div>
                        @if ($response->notes)
                            <div class="mt-2 text-muted small">
                                <i class="bi bi-sticky"></i> Note: {{ $response->notes }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
