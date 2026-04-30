<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use App\DTOs\ChargeRequest;
use App\DTOs\ChargeResult;
use App\DTOs\RefundResult;
use App\DTOs\SubscribeRequest;
use App\DTOs\SubscriptionResult;
use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class StripeGateway implements PaymentGatewayInterface
{
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    /**
     * Create a Stripe PaymentIntent for a one-time charge.
     */
    public function charge(ChargeRequest $request): ChargeResult
    {
        try {
            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $request->amountCents,
                'currency' => strtolower($request->currency),
                'receipt_email' => $request->donorEmail,
                'metadata' => array_merge($request->metadata, [
                    'campaign_id' => $request->campaignId,
                    'idempotency_key' => $request->idempotencyKey,
                ]),
            ], [
                'idempotency_key' => $request->idempotencyKey,
            ]);

            Log::info('Stripe PaymentIntent created', [
                'payment_intent_id' => $paymentIntent->id,
                'amount' => $request->amountCents,
                'campaign_id' => $request->campaignId,
            ]);

            return new ChargeResult(
                success: true,
                gatewayRef: $paymentIntent->id,
                clientSecret: $paymentIntent->client_secret,
            );
        } catch (ApiErrorException $e) {
            Log::error('Stripe charge failed', [
                'error' => $e->getMessage(),
                'campaign_id' => $request->campaignId,
            ]);

            return new ChargeResult(
                success: false,
                gatewayRef: '',
                errorMessage: $e->getMessage(),
            );
        }
    }

    /**
     * Create a Stripe Subscription for recurring donations.
     */
    public function subscribe(SubscribeRequest $request): SubscriptionResult
    {
        try {
            // Get or create Stripe Customer
            $customerId = $request->stripeCustomerId;
            if (!$customerId) {
                $customer = $this->stripe->customers->create([
                    'email' => $request->donorEmail,
                    'name' => $request->donorName,
                    'metadata' => ['campaign_id' => $request->campaignId],
                ]);
                $customerId = $customer->id;
            }

            // Map plan to Stripe interval
            $interval = match ($request->plan) {
                'monthly' => 'month',
                'quarterly' => 'month', // 3-month interval handled via interval_count
                'annually' => 'year',
                default => 'month',
            };
            $intervalCount = $request->plan === 'quarterly' ? 3 : 1;

            // Create a price on-the-fly for this donation amount
            $price = $this->stripe->prices->create([
                'unit_amount' => $request->amountCents,
                'currency' => strtolower($request->currency),
                'recurring' => [
                    'interval' => $interval,
                    'interval_count' => $intervalCount,
                ],
                'product_data' => [
                    'name' => "Recurring Donation - Campaign {$request->campaignId}",
                ],
            ]);

            $subscription = $this->stripe->subscriptions->create([
                'customer' => $customerId,
                'items' => [['price' => $price->id]],
                'payment_behavior' => 'default_incomplete',
                'expand' => ['latest_invoice.payment_intent'],
                'metadata' => ['campaign_id' => $request->campaignId],
            ]);

            Log::info('Stripe subscription created', [
                'subscription_id' => $subscription->id,
                'customer_id' => $customerId,
            ]);

            return new SubscriptionResult(
                success: true,
                stripeSubscriptionId: $subscription->id,
                stripeCustomerId: $customerId,
                clientSecret: $subscription->latest_invoice->payment_intent->client_secret ?? null,
            );
        } catch (ApiErrorException $e) {
            Log::error('Stripe subscription failed', ['error' => $e->getMessage()]);

            return new SubscriptionResult(
                success: false,
                errorMessage: $e->getMessage(),
            );
        }
    }

    /**
     * Cancel a Stripe Subscription.
     */
    public function cancel(string $subscriptionId): void
    {
        try {
            $this->stripe->subscriptions->cancel($subscriptionId);
            Log::info('Stripe subscription cancelled', ['subscription_id' => $subscriptionId]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe cancel failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Refund a charge.
     */
    public function refund(string $gatewayRef, int $amountCents): RefundResult
    {
        try {
            $refund = $this->stripe->refunds->create([
                'payment_intent' => $gatewayRef,
                'amount' => $amountCents,
            ]);

            Log::info('Stripe refund issued', [
                'refund_id' => $refund->id,
                'payment_intent' => $gatewayRef,
                'amount' => $amountCents,
            ]);

            return new RefundResult(
                success: true,
                refundId: $refund->id,
            );
        } catch (ApiErrorException $e) {
            Log::error('Stripe refund failed', ['error' => $e->getMessage()]);

            return new RefundResult(
                success: false,
                errorMessage: $e->getMessage(),
            );
        }
    }
}
