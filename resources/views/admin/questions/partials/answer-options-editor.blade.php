<div id="answerOptionsEditor" style="display: none;" class="mb-3">
    <label class="form-label">Opsi Jawaban</label>
    <div class="alert alert-info small">
        <i class="bi bi-info-circle"></i>
        Masukkan satu opsi per baris. Opsi akan diberi nomor secara otomatis.
    </div>

    <div class="input-group mb-2">
        <textarea
            class="form-control"
            id="answer_options"
            name="answer_options"
            rows="6"
            placeholder="Opsi 1&#10;Opsi 2&#10;Opsi 3&#10;Opsi 4&#10;Opsi 5">{{ old('answer_options', is_array($question->answer_options ?? null) ? implode("\n", $question->answer_options) : '') }}</textarea>
    </div>

    <div class="form-text">
        <small>
            <i class="bi bi-lightbulb"></i> Tips: Gunakan opsi yang jelas dan berbeda. Hindari pilihan yang tumpang tindih.
        </small>
    </div>

    <div class="mt-2">
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="previewAnswerOptions()">
            <i class="bi bi-eye"></i> Pratinjau Opsi
        </button>
    </div>

    <div id="answerOptionsPreview" class="mt-2" style="display: none;">
        <div class="card bg-light">
            <div class="card-body p-2">
                <small class="text-muted">Pratinjau:</small>
                <div id="previewContent" class="mt-1"></div>
            </div>
        </div>
    </div>
</div>

<script>
function previewAnswerOptions() {
    const options = document.getElementById('answer_options').value.split('\n').filter(opt => opt.trim());
    const preview = document.getElementById('answerOptionsPreview');
    const content = document.getElementById('previewContent');
    
    if (options.length > 0) {
        let html = '<div class="list-group list-group-flush">';
        options.forEach((opt, index) => {
            html += `<div class="list-group-item">${index + 1}. ${opt.trim()}</div>`;
        });
        html += '</div>';
        content.innerHTML = html;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}

document.getElementById('answer_options')?.addEventListener('blur', function() {
    if (this.value.trim()) {
        previewAnswerOptions();
    }
});
</script>
