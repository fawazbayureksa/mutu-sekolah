<div class="row g-3 mb-3">
    <div class="col-md-4">
        <label class="form-label">Bidang Keahlian <span class="text-danger">*</span></label>
        <select name="expertise" id="expertiseSelect" class="form-select @error('expertise') is-invalid @enderror" required
            onchange="loadExpertisePrograms(this.value)">
            <option value="">-- Pilih Bidang Keahlian --</option>
            @foreach (array_keys($expertiseData) as $expertise)
                <option value="{{ $expertise }}" {{ old('expertise') == $expertise ? 'selected' : '' }}>
                    {{ $expertise }}
                </option>
            @endforeach
        </select>
        @error('expertise')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Program Keahlian <span class="text-danger">*</span></label>
        <select name="expertise_program" id="expertiseProgramSelect"
            class="form-select @error('expertise_program') is-invalid @enderror" required disabled
            onchange="loadExpertiseConcentrations(this.value)">
            <option value="">-- Pilih Program Keahlian --</option>
        </select>
        @error('expertise_program')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Konsentrasi Keahlian <span class="text-danger">*</span></label>
        <select name="expertise_concentration" id="expertiseConcentrationSelect"
            class="form-select @error('expertise_concentration') is-invalid @enderror" required disabled
            onchange="loadSaprasData(this.value)">
            <option value="">-- Pilih Konsentrasi Keahlian --</option>
        </select>
        @error('expertise_concentration')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- Expose curriculum-based expertise data globally so form-v2.blade.php JS can use it --}}
<script>
    window.expertiseByCurriculum = @json($expertiseByCurriculum ?? []);
</script>
