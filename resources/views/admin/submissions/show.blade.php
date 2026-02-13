@extends('layouts.admin')

@section('title', 'Detail Submission')

@section('content')
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Pengajuan</h1>
            <a href="{{ route('admin.submissions.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Info Pengajuan</h6>
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
                                <td>: {{ $submission->filled_at ? $submission->filled_at->format('d M Y H:i') : '-' }}</td>
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
                <h6 class="m-0 font-weight-bold text-primary">Review Jawaban</h6>
            </div>
            <div class="card-body">
                @php
                    $aspects = $submission->instrument->aspects;
                @endphp

                @foreach ($aspects as $aspect)
                    <div class="mb-5">
                        <h4 class="text-primary border-bottom pb-2 mb-3">{{ is_array($aspect->code) ? json_encode($aspect->code) : $aspect->code }} - {{ is_array($aspect->name) ? json_encode($aspect->name) : $aspect->name }}</h4>

                        @foreach ($aspect->indicators as $indicator)
                            <div class="card mb-4 border-left-primary">
                                <div class="card-header bg-light">
                                    <span class="badge bg-secondary me-2">{{ is_array($indicator->code) ? json_encode($indicator->code) : $indicator->code }}</span>
                                    <span class="fw-bold text-dark">{{ is_array($indicator->description) ? json_encode($indicator->description) : $indicator->description }}</span>
                                </div>
                                <div class="card-body">
                                    @foreach ($indicator->questions as $question)
                                        @php
                                            // Find the instrument item ID for this question
                                            // Ideally this should be a direct relationship or lookup
                                            $item = $submission->instrument->items->firstWhere(
                                                'assessment_question_id',
                                                $question->id,
                                            );
                                            $response = $item ? $responses[$item->id] ?? null : null;
                                        @endphp

                                        <div class="mb-4 pb-3 border-bottom last:border-0">
                                            <div class="d-flex align-items-start mb-2">
                                                <span class="badge bg-info me-2 mt-1">{{ is_array($question->question_code) ? json_encode($question->question_code) : $question->question_code }}</span>
                                                <div>
                                                    <p class="mb-1 text-dark fw-medium">{{ $question->question_text }}</p>
                                                    @if ($question->help_text)
                                                        <small
                                                            class="text-muted fst-italic">{{ $question->help_text }}</small>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="ms-4 p-3 bg-light rounded mt-2">
                                                @if (!$response)
                                                    <span class="text-danger fst-italic"><i class="bi bi-x-circle"></i>
                                                        Belum dijawab / Tidak ada data</span>
                                                @else
                                                    <!-- Display Logic -->
                                                    @if ($question->answer_type === 'structure')
                                                        @php
                                                            $structureData = is_string($response->answer)
                                                                ? json_decode($response->answer, true)
                                                                : $response->answer;
                                                            $config = $question->getAnswerOptionsArray();
                                                            $columns = $config['columns'] ?? [];
                                                            $rowsConfig = $config['rows'] ?? [];
                                                        @endphp

                                                        @if (is_array($structureData) && count($structureData) > 0)
                                                            <div class="table-responsive bg-white rounded shadow-sm">
                                                                <table class="table table-sm table-bordered mb-0">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>Item</th>
                                                                            @foreach ($columns as $col)
                                                                                <th>{{ $col['label'] }}</th>
                                                                            @endforeach
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($structureData as $rowIndex => $rowData)
                                                                            <tr>
                                                                                <td class="fw-medium">
                                                                                    {{ $rowsConfig[$rowIndex]['label'] ?? 'Row ' . ($rowIndex + 1) }}
                                                                                </td>
                                                                                @foreach ($columns as $col)
                                                                                    <td>{{ $rowData[$col['key']] ?? '-' }}
                                                                                    </td>
                                                                                @endforeach
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <div class="alert alert-warning mb-0">
                                                                <i class="bi bi-exclamation-triangle"></i> Format data tidak
                                                                valid atau kosong.
                                                                <details class="mt-1">
                                                                    <summary class="small cursor-pointer">Lihat Raw Data
                                                                    </summary>
                                                                    <pre class="small mt-2 p-2 bg-dark text-white rounded">{{ is_string($response->answer) ? $response->answer : json_encode($response->answer) }}</pre>
                                                                </details>
                                                            </div>
                                                        @endif
                                                    @elseif ($question->answer_type === 'boolean')
                                                        @php
                                                            $answerValue = is_array($response->answer) ? json_encode($response->answer) : $response->answer;
                                                        @endphp
                                                        @if (strtolower($answerValue) == 'yes' || $answerValue == '1')
                                                            <span class="badge bg-success"><i class="bi bi-check-lg"></i>
                                                                Ya</span>
                                                        @else
                                                            <span class="badge bg-danger"><i class="bi bi-x-lg"></i>
                                                                Tidak</span>
                                                        @endif
                                                    @elseif (in_array($question->answer_type, ['scale', 'multiple_choice']))
                                                        @php
                                                            $options = $question->getAnswerOptionsArray();
                                                            $label = $response->answer;
                                                            foreach ($options as $opt) {
                                                                if (
                                                                    (string) $opt['value'] ===
                                                                    (string) $response->answer
                                                                ) {
                                                                    $label = $opt['label'];
                                                                    break;
                                                                }
                                                            }
                                                        @endphp
                                                        <span class="fw-bold">{{ $label }}</span>
                                                        @if ($label !== $response->answer)
                                                            <small class="text-muted">({{ is_array($response->answer) ? json_encode($response->answer) : $response->answer }})</small>
                                                        @endif
                                                    @else
                                                        <span class="fw-bold">{{ is_array($response->answer) ? json_encode($response->answer) : $response->answer }}</span>
                                                    @endif

                                                    @if ($response->notes)
                                                        <div class="mt-2 text-muted small border-top pt-2">
                                                            <i class="bi bi-sticky"></i> Catatan: {{ $response->notes }}
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
