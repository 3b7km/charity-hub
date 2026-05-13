# Payment Flow Architecture

The payment pipeline in CharityHub abstracts away the payment processor to ensure high reliability, idempotency, and auditability.

## 1. Abstraction Layer
The application uses a `PaymentGatewayInterface` defined in `app/Contracts`.
- `StripeGateway` handles operations via the Stripe API.
- `PayMobGateway` handles operations via the PayMob API.

## 2. One-Time Donation Flow
1. **Initiate:** User submits the donation form. The `DonationController` calls `DonationService::initiate()`.
2. **Idempotency:** Redis caches the `idempotency_key` to prevent double-charging within a 24h window.
3. **Gateway Calling:** `StripeGateway::charge()` creates a `PaymentIntent`.
4. **Client-Side Confirmation:** Stripe.js confirms the payment securely on the frontend.
5. **Webhook:** Stripe sends a `payment_intent.succeeded` webhook to `WebhookController@handle`.
6. **Processing:**
   - The Donation status is updated to `confirmed`.
   - The `DonationReceived` event is dispatched.

## 3. Event Listeners
The `DonationReceived` event triggers:
1. `GenerateCertificateListener` -> Dispatches `GenerateCertificateJob` (PDF Generation)
2. `SendThankYouEmailListener` -> Dispatches `SendCertificateEmailJob` (Emailing the donor)
3. `RecordLedgerEntryListener` -> Dispatches `RecordLedgerEntryJob` (Immutable ledger credit)
4. `UpdateCampaignProgressListener` -> Synchronously updates the Campaign `raised_amount`.

## 4. Recurring Billing
1. `StripeGateway::subscribe()` creates a Stripe Customer and Stripe Subscription.
2. Webhooks (`invoice.paid`, `invoice.payment_failed`, `customer.subscription.deleted`) maintain sync with the local `Subscription` model and spawn new `Donation` records.
