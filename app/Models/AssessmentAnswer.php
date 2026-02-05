<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'question_id',
        'answer_value',
        'score',
        'numeric_value',
        'boolean_value',
        'notes',
        'file_path',
        'attachments',
        'answered_by',
        'answered_at',
        'validation_status',
        'validation_notes',
        'validated_by',
        'validated_at',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'numeric_value' => 'decimal:4',
        'boolean_value' => 'boolean',
        'answered_at' => 'datetime',
        'validated_at' => 'datetime',
        'attachments' => 'array',
    ];

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(AssessmentQuestion::class, 'question_id');
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function scopeByValidationStatus($query, $status)
    {
        return $query->where('validation_status', $status);
    }

    public function isPending(): bool
    {
        return $this->validation_status === 'pending';
    }

    public function isValidated(): bool
    {
        return $this->validation_status === 'validated';
    }

    public function isRejected(): bool
    {
        return $this->validation_status === 'rejected';
    }

    public function needsRevision(): bool
    {
        return $this->validation_status === 'needs_revision';
    }

    public function calculateScore(): ?float
    {
        $question = $this->question;
        
        if (!$question) {
            return null;
        }

        switch ($question->answer_type) {
            case 'boolean':
                return $this->boolean_value ? $question->max_score : $question->min_score;
            
            case 'scale':
            case 'number':
            case 'percentage':
                return $this->numeric_value;
            
            case 'multiple_choice':
                if ($question->scale_template_id) {
                    $template = $question->scaleTemplate;
                    if ($template) {
                        $options = json_decode($template->scale_options, true);
                        foreach ($options as $option) {
                            if ($option['value'] === $this->answer_value) {
                                return $option['score'];
                            }
                        }
                    }
                }
                return $this->score;
            
            default:
                return $this->score;
        }
    }

    public function castAnswerValue(): mixed
    {
        $question = $this->question;
        
        if (!$question) {
            return $this->answer_value;
        }

        switch ($question->answer_type) {
            case 'boolean':
                return $this->boolean_value;
            case 'scale':
            case 'number':
            case 'percentage':
                return $this->numeric_value;
            default:
                return $this->answer_value;
        }
    }
}
