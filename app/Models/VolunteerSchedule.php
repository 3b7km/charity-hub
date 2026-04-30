<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VolunteerSchedule extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'volunteer_id',
        'campaign_id',
        'shift_start',
        'shift_end',
        'hours_logged',
        'status',
        'conflict_checked_at',
    ];

    protected function casts(): array
    {
        return [
            'shift_start' => 'datetime',
            'shift_end' => 'datetime',
            'hours_logged' => 'decimal:2',
            'conflict_checked_at' => 'datetime',
        ];
    }

    // ── Relationships ─────────────────────────────────────────

    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    // ── Scopes ────────────────────────────────────────────────

    public function scopeUpcoming($query)
    {
        return $query->where('shift_start', '>', now())
                     ->where('status', '!=', 'cancelled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeForVolunteer($query, string $volunteerId)
    {
        return $query->where('volunteer_id', $volunteerId);
    }
}
