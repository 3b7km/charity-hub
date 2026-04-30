<?php

namespace App\DTOs;

readonly class ChargeResult
{
    public function __construct(
        public bool $success,
        public string $gatewayRef,
        public ?string $clientSecret = null,
        public ?string $errorMessage = null,
    ) {}
}
