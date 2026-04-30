<?php

namespace App\Http\Controllers;

use App\Services\DonationService;
use App\Services\Payment\StripeGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    protected DonationService $donationService;
    
    public function __construct(DonationService $donationService)
    {
        $this->donationService = $donationService;
    }

    /**
     * Handle incoming Stripe Webhooks
     */
    public function handleStripe(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            Log::warning('Stripe webhook failed: Invalid payload');
            return response('', 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::warning('Stripe webhook failed: Invalid signature');
            return response('', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                // Confirm the donation using the idempotency_key or metadata
                if (isset($paymentIntent->metadata->donation_id)) {
                    $this->donationService->confirmDonation($paymentIntent->metadata->donation_id);
                }
                break;
                
            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                if (isset($paymentIntent->metadata->donation_id)) {
                    $this->donationService->markDonationFailed($paymentIntent->metadata->donation_id);
                }
                break;
                
            case 'invoice.paid':
                $invoice = $event->data->object;
                $this->donationService->processSubscriptionRenewal($invoice->subscription, $invoice->amount_paid);
                break;
                
            case 'invoice.payment_failed':
                $invoice = $event->data->object;
                $this->donationService->markSubscriptionPastDue($invoice->subscription);
                break;

            case 'customer.subscription.deleted':
                $subscription = $event->data->object;
                $this->donationService->cancelSubscription($subscription->id);
                break;

            case 'charge.refunded':
                $charge = $event->data->object;
                if (isset($charge->payment_intent)) {
                    $this->donationService->refundDonation($charge->payment_intent);
                }
                break;

            default:
                Log::info('Received unhandled event type ' . $event->type);
        }

        return response('', 200);
    }
}
