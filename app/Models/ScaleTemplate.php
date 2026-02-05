<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScaleTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'scale_type',
        'scale_options',
        'min_score',
        'max_score',
        'usage_count',
        'is_default',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'scale_options' => 'array',
        'min_score' => 'decimal:2',
        'max_score' => 'decimal:2',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(AssessmentQuestion::class, 'scale_template_id');
    }

    public function answerOptions(): HasMany
    {
        return $this->hasMany(AnswerOption::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('scale_type', $type);
    }

    public function getOptions(): array
    {
        // scale_options is already cast to array by Laravel
        return $this->scale_options ?? [];
    }

    public function getScoreForValue(string $value): ?float
    {
        $options = $this->getOptions();
        foreach ($options as $option) {
            if ($option['value'] === $value) {
                return (float) $option['score'];
            }
        }
        return null;
    }

    public function getLabelForValue(string $value): ?string
    {
        $options = $this->getOptions();
        foreach ($options as $option) {
            if ($option['value'] === $value) {
                return $option['label'];
            }
        }
        return null;
    }

    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    public function decrementUsage(): void
    {
        $this->decrement('usage_count');
    }
}
