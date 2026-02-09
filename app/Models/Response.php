<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'school_id',
        'instrument_item_id',
        'answer',
        'score',
        'notes',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'answer' => 'array',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function instrumentItem(): BelongsTo
    {
        return $this->belongsTo(InstrumentItem::class);
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function calculateScore(): ?float
    {
        $item = $this->instrumentItem;

        if (!$item) {
            return null;
        }

        if ($item->uses_master_question && $item->question) {
            $question = $item->question;

            switch ($question->answer_type) {
                case 'boolean':
                    return filter_var($this->answer, FILTER_VALIDATE_BOOLEAN) ? $question->max_score : $question->min_score;

                case 'scale':
                case 'number':
                case 'percentage':
                    return (float) $this->answer;

                case 'multiple_choice':
                    $options = $question->getAnswerOptionsArray();
                    foreach ($options as $option) {
                        if ($option['value'] === $this->answer) {
                            return (float) $option['score'];
                        }
                    }
                    break;
            }
        }

        return $this->score;
    }
}
