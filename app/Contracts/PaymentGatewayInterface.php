<?php

namespace App\Contracts;

use App\DTOs\ChargeRequest;
use App\DTOs\ChargeResult;
use App\DTOs\RefundResult;
use App\DTOs\SubscribeRequest;
use App\DTOs\SubscriptionResult;

/**
 * Payment gateway abstraction.
 * Implementations: StripeGateway, PayMobGateway.
 * Swap gateways via config('payment.default') without touching business logic.
 */
interface PaymentGatewayInterface
{
    /**
     * Create a one-time charge (PaymentIntent).
     */
    public function charge(ChargeRequest $request): ChargeResult;

    /**
     * Create a recurring subscription.
     */
    public function subscribe(SubscribeRequest $request): SubscriptionResult;

    /**
     * Cancel an active subscription.
     */
    public function cancel(string $subscriptionId): void;

    /**
     * Issue a refund against a confirmed charge.
     */
    public function refund(string $gatewayRef, int $amountCents): RefundResult;
}
