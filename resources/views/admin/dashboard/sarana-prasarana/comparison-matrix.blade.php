{{-- ROW 3: Matriks Perbandingan Komprehensif Antar Konsentrasi (col-12) --}}
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card chart-container-card shadow-sm">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                <div>
                    <h6 class="fw-bold mb-0 text-dark">{{ $comparisonMatrix['title'] ?? 'Tabel Perbandingan Komprehensif (Sekolah Dilengkapi)' }}</h6>
                    <small class="text-muted">Komparasi pemenuhan sarana & prasarana vital antar konsentrasi keahlian</small>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle mb-0" style="font-size: 0.85rem;">
                    <thead class="table-light">
                        <tr>
                            @foreach ($comparisonMatrix['headers'] as $hIdx => $header)
                                <th class="{{ $hIdx === 0 ? 'text-start ps-3' : 'text-center' }}" style="font-weight: 700;">
                                    {{ $header }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comparisonMatrix['rows'] as $r)
                            <tr>
                                <td class="text-start ps-3 fw-medium text-dark">{{ $r['name'] }}</td>
                                @foreach ($r['vals'] as $val)
                                    <td>
                                        @if ($val === '-')
                                            <span class="text-muted">-</span>
                                        @else
                                            <span class="fw-bold text-dark">{{ $val }}%</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
