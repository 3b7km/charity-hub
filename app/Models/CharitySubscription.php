<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CharitySubscription extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'charity_subscriptions';

    protected $fillable = [
        'donor_id',
        'campaign_id',
        'stripe_subscription_id',
        'stripe_customer_id',
        'plan',
        'status',
        'current_period_end',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'current_period_end' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    /**
     * Check if the subscription is currently active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    // ── Relationships ─────────────────────────────────────────

    public function donor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class, 'subscription_id');
    }

    // ── Scopes ────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
}
