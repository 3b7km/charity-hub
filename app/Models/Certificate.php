<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'donation_id',
        'certificate_number',
        'issued_at',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
        ];
    }

    // ── Relationships ─────────────────────────────────────────

    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }
}
