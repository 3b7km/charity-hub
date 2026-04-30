<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ImpactReport extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia;

    protected $fillable = [
        'campaign_id',
        'beneficiary_count',
        'locations',
        'summary',
        'published_at',
        'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'beneficiary_count' => 'integer',
            'locations' => 'array',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Register media collections for impact report photos.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos');
    }

    /**
     * Register media conversions for thumbnails.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('full')
            ->width(1200)
            ->height(800);
    }

    /**
     * Check if report is published.
     */
    public function isPublished(): bool
    {
        return $this->published_at !== null;
    }

    // ── Relationships ─────────────────────────────────────────

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    // ── Scopes ────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }
}
