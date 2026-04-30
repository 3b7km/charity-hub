<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LedgerEntry extends Model
{
    use HasFactory, HasUuids;

    /**
     * Immutable table — no updated_at column.
     */
    const UPDATED_AT = null;

    /**
     * Prevent mass deletion — ledger is append-only.
     */
    protected $fillable = [
        'donation_id',
        'type',
        'amount',
        'balance_after',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'balance_after' => 'integer',
        ];
    }

    /**
     * Format amount in pounds.
     */
    public function getFormattedAmountAttribute(): string
    {
        return '£' . number_format($this->amount / 100, 2);
    }

    // ── Relationships ─────────────────────────────────────────

    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }

    // ── Guard against mutation ────────────────────────────────

    /**
     * Override delete to prevent ledger tampering.
     */
    public function delete()
    {
        throw new \RuntimeException('Ledger entries are immutable and cannot be deleted.');
    }

    /**
     * Override update to prevent ledger tampering.
     */
    public function update(array $attributes = [], array $options = [])
    {
        throw new \RuntimeException('Ledger entries are immutable and cannot be updated.');
    }
}
