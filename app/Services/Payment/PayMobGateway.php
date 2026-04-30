<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use App\DTOs\ChargeRequest;
use App\DTOs\ChargeResult;
use App\DTOs\RefundResult;
use App\DTOs\SubscribeRequest;
use App\DTOs\SubscriptionResult;
use Illuminate\Support\Facades\Log;

/**
 * PayMob payment gateway stub.
 * Implement the full PayMob API integration when ready.
 */
class PayMobGateway implements PaymentGatewayInterface
{
    public function charge(ChargeRequest $request): ChargeResult
    {
        // TODO: Implement PayMob API charge flow
        Log::warning('PayMob gateway charge called but not yet implemented');

        return new ChargeResult(
            success: false,
            gatewayRef: '',
            errorMessage: 'PayMob gateway is not yet implemented.',
        );
    }

    public function subscribe(SubscribeRequest $request): SubscriptionResult
    {
        Log::warning('PayMob gateway subscribe called but not yet implemented');

        return new SubscriptionResult(
            success: false,
            errorMessage: 'PayMob does not support recurring subscriptions natively.',
        );
    }

    public function cancel(string $subscriptionId): void
    {
        Log::warning('PayMob gateway cancel called but not yet implemented');
    }

    public function refund(string $gatewayRef, int $amountCents): RefundResult
    {
        // TODO: Implement PayMob API refund flow
        Log::warning('PayMob gateway refund called but not yet implemented');

        return new RefundResult(
            success: false,
            errorMessage: 'PayMob refund is not yet implemented.',
        );
    }
}
