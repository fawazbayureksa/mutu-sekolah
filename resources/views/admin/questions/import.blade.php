@extends('layouts.admin')

@section('title', 'Import Questions')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Import Questions from Excel</h1>
            <a href="{{ route('admin.questions.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Upload Excel File</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.questions.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="file" class="form-label">Select Excel File <span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror"
                                    id="file" name="file" accept=".xlsx,.xls,.csv" required>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Supported formats: .xlsx, .xls, .csv (Max: 5MB)</small>
                            </div>

                            <div class="alert alert-warning">
                                <h6><i class="bi bi-exclamation-triangle"></i> Important Notes:</h6>
                                <ul class="mb-0 small">
                                    <li>The Excel file must follow the required format template</li>
                                    <li>All required columns must be present</li>
                                    <li>Question codes must be unique</li>
                                    <li>Aspect and indicator codes must exist in the system</li>
                                    <li>Invalid rows will be skipped with error reporting</li>
                                </ul>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload"></i> Import Questions
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-info-circle"></i> Required Format
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="small mb-2"><strong>Required Columns:</strong></p>
                        <ul class="small">
                            <li><code>question_code</code> - Unique identifier</li>
                            <li><code>indicator_code</code> - Indicator code</li>
                            <li><code>question_text</code> - Question content</li>
                            <li><code>answer_type</code> - text/number/scale/choice/date</li>
                        </ul>

                        <p class="small mb-2 mt-3"><strong>Optional Columns:</strong></p>
                        <ul class="small">
                            <li><code>help_text</code> - Additional guidance</li>
                            <li><code>weight</code> - Question weight (1-10)</li>
                            <li><code>order</code> - Display order</li>
                            <li><code>is_required</code> - true/false</li>
                            <li><code>min_score</code> - For scale questions</li>
                            <li><code>max_score</code> - For scale questions</li>
                            <li><code>answer_options</code> - For choice (comma-separated)</li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-download"></i> Download Template
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="small">Download the Excel template with the correct format and example data:</p>
                        <a href="#" class="btn btn-success w-100"
                            onclick="alert('Template download will be implemented'); return false;">
                            <i class="bi bi-file-earmark-excel"></i> Download Template
                        </a>
                        <small class="text-muted d-block mt-2">
                            The template includes:
                            <ul class="small mt-1 mb-0">
                                <li>All required columns</li>
                                <li>Example data rows</li>
                                <li>Format guidelines</li>
                            </ul>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Example Data Format</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>question_code</th>
                                        <th>indicator_code</th>
                                        <th>question_text</th>
                                        <th>answer_type</th>
                                        <th>weight</th>
                                        <th>is_required</th>
                                        <th>help_text</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><code>Q001</code></td>
                                        <td><code>IND001</code></td>
                                        <td>How would you rate the school facilities?</td>
                                        <td>scale</td>
                                        <td>3</td>
                                        <td>true</td>
                                        <td>Rate from 1 (poor) to 5 (excellent)</td>
                                    </tr>
                                    <tr>
                                        <td><code>Q002</code></td>
                                        <td><code>IND001</code></td>
                                        <td>Which teaching method is most effective?</td>
                                        <td>choice</td>
                                        <td>2</td>
                                        <td>true</td>
                                        <td>Select one option</td>
                                    </tr>
                                    <tr>
                                        <td><code>Q003</code></td>
                                        <td><code>IND002</code></td>
                                        <td>Provide additional comments</td>
                                        <td>text</td>
                                        <td>1</td>
                                        <td>false</td>
                                        <td>Optional feedback</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
