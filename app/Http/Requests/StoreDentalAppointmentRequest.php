<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDentalAppointmentRequest extends FormRequest
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
            'service_type' => 'required|in:cleaning,checkup,treatment,emergency',
            'notes' => 'nullable|string|max:1000',
            'appointment_datetime' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:30|max:240',
            'dentist_name' => 'nullable|string|max:255',
            'clinic_name' => 'required|string|max:255',
            'clinic_address' => 'required|string|max:500',
            'clinic_phone' => 'required|string|max:20',
            'estimated_cost' => 'nullable|numeric|min:0|max:9999.99',
            'preparation_instructions' => 'nullable|string|max:1000',
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
            'service_type.required' => 'Please select a service type.',
            'service_type.in' => 'Please select a valid service type.',
            'appointment_datetime.required' => 'Appointment date and time is required.',
            'appointment_datetime.after' => 'Appointment must be scheduled for a future date and time.',
            'duration_minutes.required' => 'Appointment duration is required.',
            'duration_minutes.min' => 'Appointment must be at least 30 minutes.',
            'duration_minutes.max' => 'Appointment cannot exceed 4 hours.',
            'clinic_name.required' => 'Clinic name is required.',
            'clinic_address.required' => 'Clinic address is required.',
            'clinic_phone.required' => 'Clinic phone number is required.',
        ];
    }
}