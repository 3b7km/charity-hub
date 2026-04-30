<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Campaign extends Model implements Auditable, HasMedia
{
    use HasFactory, HasUuids, SoftDeletes, AuditableTrait, InteractsWithMedia, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'goal_amount',
        'raised_amount',
        'start_date',
        'end_date',
        'status',
        'featured_image',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'goal_amount' => 'integer',
            'raised_amount' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Register media collections for campaign images.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured')
            ->singleFile();

        $this->addMediaCollection('gallery');
    }

    /**
     * Calculate progress percentage.
     */
    public function getProgressPercentageAttribute(): float
    {
        if ($this->goal_amount <= 0) {
            return 0;
        }

        return min(100, round(($this->raised_amount / $this->goal_amount) * 100, 1));
    }

    /**
     * Format goal amount in pounds.
     */
    public function getFormattedGoalAttribute(): string
    {
        return '£' . number_format($this->goal_amount / 100, 2);
    }

    /**
     * Format raised amount in pounds.
     */
    public function getFormattedRaisedAttribute(): string
    {
        return '£' . number_format($this->raised_amount / 100, 2);
    }

    /**
     * Check if campaign is currently active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->end_date->isFuture();
    }

    // ── Relationships ─────────────────────────────────────────

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function confirmedDonations(): HasMany
    {
        return $this->hasMany(Donation::class)->where('status', 'confirmed');
    }

    public function volunteerSchedules(): HasMany
    {
        return $this->hasMany(VolunteerSchedule::class);
    }

    public function impactReports(): HasMany
    {
        return $this->hasMany(ImpactReport::class);
    }

    public function beneficiaryLocations()
    {
        return $this->hasMany(BeneficiaryLocation::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(CharitySubscription::class);
    }

    // ── Scopes ────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->where('end_date', '>=', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'active')->where('end_date', '<', now());
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (!empty($this->featured_image)) {
            return asset('images/campaigns/' . basename($this->featured_image));
        }
        
        return $this->getFirstMediaUrl('featured') ?: null;
    }
}
