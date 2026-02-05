<div id="scaleTemplateSelector" style="display: none;" class="mb-3">
    <label class="form-label">Scale Template</label>
    
    <div class="mb-3">
        <select class="form-select" id="scale_template_id" name="scale_template_id">
            <option value="">-- Select Scale Template --</option>
            @foreach ($scaleTemplates as $template)
                <option 
                    value="{{ $template->id }}" 
                    data-min="{{ $template->min_value }}"
                    data-max="{{ $template->max_value }}"
                    data-rows="{{ $template->rows ?? 1 }}"
                    data-columns="{{ $template->columns ?? 5 }}"
                    {{ old('scale_template_id', $question->scale_template_id ?? '') == $template->id ? 'selected' : '' }}>
                    {{ $template->name }} ({{ $template->min_value }} - {{ $template->max_value }})
                    @if ($template->description)
                        - {{ $template->description }}
                    @endif
                </option>
            @endforeach
        </select>
        <small class="form-text text-muted">
            Select a predefined scale template or set custom values below
        </small>
    </div>
    
    <div class="card bg-light mb-3">
        <div class="card-body">
            <h6 class="card-title mb-2">Custom Scale Configuration</h6>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label for="min_score" class="form-label small">Minimum Score</label>
                    <input 
                        type="number" 
                        class="form-control" 
                        id="min_score" 
                        name="min_score"
                        min="0"
                        step="0.1"
                        value="{{ old('min_score', $question->min_score ?? 1) }}">
                </div>
                <div class="col-md-6 mb-2">
                    <label for="max_score" class="form-label small">Maximum Score</label>
                    <input 
                        type="number" 
                        class="form-control" 
                        id="max_score" 
                        name="max_score"
                        min="0"
                        step="0.1"
                        value="{{ old('max_score', $question->max_score ?? 5) }}">
                </div>
            </div>
            <div class="form-check form-switch">
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    id="allow_decimals" 
                    name="allow_decimals"
                    {{ old('allow_decimals', $question->allow_decimals ?? false) ? 'checked' : '' }}>
                <label class="form-check-label small" for="allow_decimals">
                    Allow decimal scores
                </label>
            </div>
        </div>
    </div>
    
    <div id="scalePreview" class="card" style="display: none;">
        <div class="card-header py-2">
            <h6 class="card-title mb-0 small">
                <i class="bi bi-eye"></i> Scale Preview
            </h6>
        </div>
        <div class="card-body">
            <div id="scalePreviewContent"></div>
        </div>
    </div>
</div>

<script>
document.getElementById('scale_template_id')?.addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const min = selected.getAttribute('data-min');
    const max = selected.getAttribute('data-max');
    
    if (min && max) {
        document.getElementById('min_score').value = min;
        document.getElementById('max_score').value = max;
        updateScalePreview();
    }
});

document.getElementById('min_score')?.addEventListener('change', updateScalePreview);
document.getElementById('max_score')?.addEventListener('change', updateScalePreview);

function updateScalePreview() {
    const min = parseFloat(document.getElementById('min_score').value) || 1;
    const max = parseFloat(document.getElementById('max_score').value) || 5;
    const preview = document.getElementById('scalePreview');
    const content = document.getElementById('scalePreviewContent');
    
    if (max > min) {
        let html = '<div class="d-flex align-items-center gap-1">';
        
        for (let i = min; i <= max; i++) {
            html += `
                <div class="text-center">
                    <div class="badge bg-secondary rounded-circle mb-1" style="width: 30px; height: 30px; line-height: 30px;">
                        ${i}
                    </div>
                </div>
            `;
            if (i < max) {
                html += '<div class="flex-grow-1 border-bottom"></div>';
            }
        }
        
        html += '</div>';
        html += `<small class="text-muted">Range: ${min} - ${max} (${max - min + 1} points)</small>`;
        content.innerHTML = html;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}
</script>
