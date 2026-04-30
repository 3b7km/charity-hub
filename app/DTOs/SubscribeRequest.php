<?php

namespace App\DTOs;

readonly class SubscribeRequest
{
    public function __construct(
        public string $donorEmail,
        public string $donorName,
        public string $campaignId,
        public string $plan, // monthly, quarterly, annually
        public int $amountCents,
        public string $currency = 'GBP',
        public ?string $stripeCustomerId = null,
    ) {}
}
