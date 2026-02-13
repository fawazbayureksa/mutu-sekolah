<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstrumentSubmissionV2Detail extends Model
{
    use HasFactory;

    protected $table = 'instrument_submission_v2_details';

    protected $fillable = [
        'submission_id',
        'section_code',
        'data',
        'row_count',
        'section_score',
    ];

    protected $casts = [
        'data' => 'array',
        'section_score' => 'decimal:2',
    ];

    /**
     * Get the parent submission
     */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(InstrumentSubmissionV2::class, 'submission_id');
    }

    /**
     * Scope for filtering by section code
     */
    public function scopeForSection($query, string $sectionCode)
    {
        return $query->where('section_code', $sectionCode);
    }

    /**
     * Scope for sections with dynamic rows
     */
    public function scopeDynamicSections($query)
    {
        return $query->whereIn('section_code', ['B.1.1', 'C.1.1', 'C.2.1', 'C.3.1']);
    }

    /**
     * Get section label
     */
    public function getSectionLabel(): string
    {
        $labels = [
            'A.1.1' => 'Data Kelulusan Uji Kompetensi dan Sertifikasi',
            'A.2.1' => 'Penelusuran Alumni (Tracer Study)',
            'B.1.1' => 'Inventarisasi dan Kesesuaian dengan Standar Industri',
            'B.2.1' => 'Penilaian Kesiapan Fasilitas (Checklist)',
            'C.1.1' => 'Kerjasama Industri',
            'C.2.1' => 'Teaching Factory (TEFA) / Unit Produksi Sekolah',
            'C.3.1' => 'Data Pelatihan dan Sertifikasi Guru yang Telah Diikuti',
            'C.3.2' => 'Analisis Kebutuhan Pelatihan Guru ke Depan',
        ];

        return $labels[$this->section_code] ?? $this->section_code;
    }

    /**
     * Check if this section supports dynamic rows
     */
    public function hasDynamicRows(): bool
    {
        return in_array($this->section_code, ['B.1.1', 'C.1.1', 'C.2.1', 'C.3.1']);
    }
}
