<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstrumentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'instrument_id',
        'section',
        'indicator_code',
        'indicator_text',
        'answer_type',
        'assessment_question_id',
        'order',
        'uses_master_question',
        'custom_help_text',
        'custom_answer_options',
    ];

    protected $casts = [
        'uses_master_question' => 'boolean',
        'custom_answer_options' => 'array',
    ];

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(AssessmentQuestion::class, 'assessment_question_id');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function getQuestionText(): string
    {
        if ($this->uses_master_question && $this->question) {
            return $this->question->question_text;
        }
        return $this->indicator_text ?? '';
    }

    public function getAnswerType(): string
    {
        if ($this->uses_master_question && $this->question) {
            return $this->question->answer_type;
        }
        return $this->answer_type;
    }

    public function getHelpText(): ?string
    {
        if ($this->custom_help_text) {
            return $this->custom_help_text;
        }
        
        if ($this->uses_master_question && $this->question) {
            return $this->question->help_text;
        }
        
        return null;
    }

    public function getAnswerOptions(): ?array
    {
        if ($this->custom_answer_options) {
            return $this->custom_answer_options;
        }
        
        if ($this->uses_master_question && $this->question) {
            return $this->question->getAnswerOptionsArray();
        }
        
        return null;
    }

    public function isRequired(): bool
    {
        if ($this->uses_master_question && $this->question) {
            return $this->question->is_required;
        }
        return true;
    }

    public function getMaxScore(): ?float
    {
        if ($this->uses_master_question && $this->question) {
            return $this->question->max_score;
        }
        return null;
    }

    public function getMinScore(): ?float
    {
        if ($this->uses_master_question && $this->question) {
            return $this->question->min_score;
        }
        return null;
    }
}
