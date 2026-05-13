# GDPR Compliance & Data Retention Policy

CharityHub handles Personally Identifiable Information (PII) and financial records. This document outlines the compliance measures implemented.

## 1. Data Encryption
- Sensitive fields such as `users.name`, `users.email`, and `volunteers.emergency_contact` are encrypted at rest using Laravel's `Encryptable` trait.
- Authentication relies on a deterministic `email_hash` column to allow for unique constraints and login lookups without decrypting the entire database.

## 2. Right to Erasure (Right to be Forgotten)
The `EraseUserDataJob` fulfills user requests for data deletion:
- **Anonymisation:** The User's name and email are replaced with randomized placeholders (`Anonymised User`, `erased_xxx@example.com`).
- **Financial Integrity:** `Donation` records are retained to comply with the 7-year financial retention policy, but the `user_id` foreign key is nullified, detaching the payment from the person.
- **Artifact Deletion:** All generated Certificate PDFs linked to the user are permanently deleted from storage.

## 3. Right to Data Portability
Donors can export their data in a machine-readable JSON format via the `GET /api/donors/export` endpoint. This includes their profile, active subscriptions, and a history of anonymised donations.

## 4. Privacy by Design
- Rate Limiting prevents enumeration attacks.
- Strict CSP Headers mitigate XSS.
- All IDs are exposed as UUIDs to prevent sequential guessing of resources.
