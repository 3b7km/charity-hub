<?php

namespace App\DTOs;

readonly class ChargeRequest
{
    public function __construct(
        public int $amountCents,
        public string $currency,
        public string $campaignId,
        public string $donorEmail,
        public string $idempotencyKey,
        public array $metadata = [],
    ) {}
}
