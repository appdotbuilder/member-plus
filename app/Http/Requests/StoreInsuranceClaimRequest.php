<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInsuranceClaimRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'insurance_policy_id' => 'required|exists:insurance_policies,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'claimed_amount' => 'required|numeric|min:0|max:999999.99',
            'incident_date' => 'required|date|before_or_equal:today',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'insurance_policy_id.required' => 'Please select an insurance policy.',
            'insurance_policy_id.exists' => 'The selected insurance policy is invalid.',
            'title.required' => 'Claim title is required.',
            'description.required' => 'Claim description is required.',
            'claimed_amount.required' => 'Claimed amount is required.',
            'claimed_amount.numeric' => 'Claimed amount must be a valid number.',
            'claimed_amount.min' => 'Claimed amount must be greater than 0.',
            'incident_date.required' => 'Incident date is required.',
            'incident_date.before_or_equal' => 'Incident date cannot be in the future.',
        ];
    }
}