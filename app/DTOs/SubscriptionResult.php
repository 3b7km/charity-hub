<?php

namespace App\DTOs;

readonly class SubscriptionResult
{
    public function __construct(
        public bool $success,
        public ?string $stripeSubscriptionId = null,
        public ?string $stripeCustomerId = null,
        public ?string $clientSecret = null,
        public ?string $errorMessage = null,
    ) {}
}
