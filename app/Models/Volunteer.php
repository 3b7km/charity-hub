<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Volunteer extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'skills',
        'availability',
        'total_hours',
        'verified_at',
        'emergency_contact',
    ];

    protected function casts(): array
    {
        return [
            'skills' => 'array',
            'availability' => 'array',
            'total_hours' => 'decimal:2',
            'verified_at' => 'datetime',
            'emergency_contact' => 'encrypted', // AES-256 at-rest encryption
        ];
    }

    /**
     * Check if volunteer has been verified by admin.
     */
    public function isVerified(): bool
    {
        return $this->verified_at !== null;
    }

    // ── Relationships ─────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(VolunteerSchedule::class);
    }

    public function upcomingSchedules(): HasMany
    {
        return $this->hasMany(VolunteerSchedule::class)
            ->where('shift_start', '>', now())
            ->where('status', '!=', 'cancelled')
            ->orderBy('shift_start');
    }

    public function completedSchedules(): HasMany
    {
        return $this->hasMany(VolunteerSchedule::class)
            ->where('status', 'completed');
    }
}
