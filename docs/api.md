# API Documentation

CharityHub provides a RESTful API for donations, campaign retrieval, and volunteer scheduling. 

## Scribe Documentation
The complete, interactive API documentation is generated using [Scribe](https://scribe.knuckles.wtf/). 

To view the endpoints, parameters, and example responses, start the local development server:
```bash
php artisan serve
```
Then navigate your browser to: `http://localhost:8000/docs`

## Postman Collection
A Postman collection is also generated automatically and can be found at:
`storage/app/private/scribe/collection.json`

## Webhook Events Reference
The application listens for the following Stripe events at `/api/webhooks/stripe`:

| Event | Action |
|-------|--------|
| `payment_intent.succeeded` | Confirms the pending `Donation`, generates the certificate, and credits the ledger. |
| `invoice.paid` | Confirms a recurring `Subscription` payment and spawns a new `Donation` record for that month. |
| `customer.subscription.deleted` | Marks the local `Subscription` model as cancelled. |

**Important:** Webhooks must be verified using the `STRIPE_WEBHOOK_SECRET` environment variable to prevent forged requests.
