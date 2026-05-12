# Compliance & Security Notes

## Financial Data Handling (PCI-DSS)
- **Zero Card Data Storage:** CharityHub does not store full credit card numbers, expiration dates, or CVC codes. All payment processing relies on Stripe Elements/PayMob and tokenization. 
- **Idempotency:** All payment requests generate and send a unique `idempotency_key` to the gateway. This guarantees that network retries or accidental double-clicks by donors do not result in duplicate financial charges.
- **Immutable Ledger:** Once a donation is confirmed via webhook, an immutable `LedgerEntry` is created. This provides a strict, tamper-proof audit trail of all incoming funds matching the `donations` table.

## GDPR Considerations
- **Right to Erasure (Right to be Forgotten):** A dedicated `EraseUserDataJob` handles account deletion requests. It securely anonymizes ledger entries (to maintain financial reporting integrity) while completely hard-deleting personally identifiable information (PII) like names and emails.
- **Data Minimization:** Only data strictly necessary for processing donations and issuing tax certificates is collected. 
- **Explicit Consent:** Opt-in checkboxes are required during checkout for receiving marketing communications or impact report updates.
- **Data Portability:** Donors have the right and ability to export their full donation history, certificates, and volunteer hours via their dashboard.
