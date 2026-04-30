<?php

namespace App\DTOs;

readonly class RefundResult
{
    public function __construct(
        public bool $success,
        public ?string $refundId = null,
        public ?string $errorMessage = null,
    ) {}
}
