<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Instrument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'category',
        'version',
        'is_active',
        'is_published',
        'published_at',
        'created_by',
        'updated_by',
        'instructions',
        'estimated_duration',
        'scoring_method',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'deleted_at' => 'datetime',
        'is_active' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(InstrumentItem::class)->orderBy('order');
    }

    public function aspects(): BelongsToMany
    {
        return $this->belongsToMany(AssessmentAspect::class, 'instrument_aspects', 'instrument_id', 'aspect_id')
            ->withPivot(['order', 'weight'])
            ->orderBy('pivot_order');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByVersion($query, $version)
    {
        return $query->where('version', $version);
    }

    public function isDraft(): bool
    {
        return !$this->is_published;
    }

    public function isPublished(): bool
    {
        return $this->is_published;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function publish(): void
    {
        $this->update([
            'is_published' => true,
            'published_at' => now(),
        ]);
    }

    public function unpublish(): void
    {
        $this->update([
            'is_published' => false,
            'published_at' => null,
        ]);
    }

    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }

    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    public function getTotalQuestions(): int
    {
        return $this->items()->count();
    }

    public function getRequiredQuestions(): HasMany
    {
        return $this->items()->whereHas('question', function ($query) {
            $query->where('is_required', true);
        });
    }

    public function getMaxPossibleScore(): float
    {
        $score = 0;
        foreach ($this->items as $item) {
            if ($item->question) {
                $score += $item->question->max_score * $item->question->weight;
            }
        }
        return $score;
    }
}
