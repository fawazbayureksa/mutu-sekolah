<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'indicator_id',
        'question_text',
        'answer_type',
        'weight',
        'order',
        'question_code',
        'answer_options',
        'help_text',
        'is_required',
        'max_score',
        'min_score',
        'is_active',
        'scale_template_id',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'max_score' => 'decimal:2',
        'min_score' => 'decimal:2',
        'answer_options' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function indicator(): BelongsTo
    {
        return $this->belongsTo(AssessmentIndicator::class, 'indicator_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(AssessmentAnswer::class, 'question_id');
    }

    public function scaleTemplate(): BelongsTo
    {
        return $this->belongsTo(ScaleTemplate::class);
    }

    public function instrumentItems(): HasMany
    {
        return $this->hasMany(InstrumentItem::class, 'assessment_question_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('answer_type', $type);
    }

    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    public function getAnswerOptionsArray(): array
    {
        if ($this->scale_template_id) {
            $template = $this->scaleTemplate;
            if ($template) {
                // Handle potential array cast on ScaleTemplate or raw string
                $options = $template->scale_options;
                if (is_array($options)) {
                    return $options;
                }
                return json_decode($options, true) ?? [];
            }
        }

        $options = $this->answer_options;

        if (is_array($options)) {
            return $options;
        }

        return json_decode($options, true) ?? [];
    }

    public function hasOptions(): bool
    {
        return in_array($this->answer_type, ['scale', 'multiple_choice', 'boolean']);
    }

    public function requiresFileUpload(): bool
    {
        return $this->answer_type === 'file';
    }

    public function getValidationRules(): array
    {
        $rules = [];

        if ($this->is_required) {
            $rules[] = 'required';
        } else {
            $rules[] = 'nullable';
        }

        switch ($this->answer_type) {
            case 'boolean':
                $rules[] = 'boolean';
                break;
            case 'scale':
            case 'number':
                $rules[] = 'numeric';
                if ($this->min_score !== null) {
                    $rules[] = 'min:' . $this->min_score;
                }
                if ($this->max_score !== null) {
                    $rules[] = 'max:' . $this->max_score;
                }
                break;
            case 'percentage':
                $rules[] = 'numeric';
                $rules[] = 'between:0,100';
                break;
            case 'text':
                $rules[] = 'string';
                break;
            case 'multiple_choice':
                $options = $this->getAnswerOptionsArray();
                $values = array_column($options, 'value');
                $rules[] = 'in:' . implode(',', $values);
                break;
            case 'file':
                $rules[] = 'file';
                $rules[] = 'max:10240';
                break;
        }

        return $rules;
    }

    public function getValidationMessage(): string
    {
        $messages = [];

        if ($this->is_required) {
            $messages[] = 'This field is required';
        }

        if ($this->answer_type === 'number' || $this->answer_type === 'scale') {
            if ($this->min_score !== null && $this->max_score !== null) {
                $messages[] = "Value must be between {$this->min_score} and {$this->max_score}";
            }
        }

        return implode('. ', $messages);
    }
}
