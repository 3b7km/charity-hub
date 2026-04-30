<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'campaign_id' => 'required|uuid|exists:campaigns,id',
            'amount' => 'required|integer|min:100', // Min £1.00 in pence
            'currency' => 'sometimes|string|size:3',
            'idempotency_key' => 'required|uuid',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min' => 'The minimum donation amount is £1.00.',
            'idempotency_key.required' => 'An idempotency key is required to prevent duplicate charges.',
        ];
    }
}
