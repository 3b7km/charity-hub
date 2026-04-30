<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Donation extends Model implements Auditable
{
    use HasFactory, HasUuids, SoftDeletes, AuditableTrait;
    
    protected static function booted()
    {
        static::creating(function ($donation) {
            if (empty($donation->idempotency_key)) {
                $donation->idempotency_key = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    protected $fillable = [
        'campaign_id',
        'donor_id',
        'amount',
        'currency',
        'gateway',
        'gateway_ref',
        'idempotency_key',
        'status',
        'type',
        'subscription_id',
        'certificate_path',
        'donated_at',
    ];

    /**
     * Audit trail only tracks financial-critical fields.
     */
    protected array $auditInclude = [
        'amount',
        'status',
        'gateway',
        'gateway_ref',
        'campaign_id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'donated_at' => 'datetime',
        ];
    }

    /**
     * Format amount in pounds.
     */
    public function getFormattedAmountAttribute(): string
    {
        return '£' . number_format($this->amount / 100, 2);
    }

    /**
     * Get donor display name (anonymous fallback).
     */
    public function getDonorNameAttribute(): string
    {
        return $this->donor?->name ?? 'Anonymous Donor';
    }

    // ── Relationships ─────────────────────────────────────────

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function donor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(CharitySubscription::class, 'subscription_id');
    }

    public function ledgerEntry(): HasOne
    {
        return $this->hasOne(LedgerEntry::class);
    }

    // ── Scopes ────────────────────────────────────────────────

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRecurring($query)
    {
        return $query->where('type', 'recurring');
    }

    public function scopeOneTime($query)
    {
        return $query->where('type', 'one_time');
    }
}
