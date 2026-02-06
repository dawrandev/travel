<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tour_id' => 'required|exists:tours,id',
            'full_name' => 'required|string|max:255',
            'max_people' => 'required|integer|min:1',
            'starting_date' => 'required|date|after_or_equal:today',
            'ending_date' => 'required|date|after_or_equal:starting_date',
            'primary_phone' => 'required|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'message' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'tour_id.required' => 'Tour ID is required',
            'tour_id.exists' => 'Selected tour does not exist',
            'full_name.required' => 'Full name is required',
            'full_name.max' => 'Full name must not exceed 255 characters',
            'max_people.required' => 'Number of people is required',
            'max_people.min' => 'Number of people must be at least 1',
            'starting_date.required' => 'Starting date is required',
            'starting_date.date' => 'Please provide a valid starting date',
            'starting_date.after_or_equal' => 'Starting date must be today or in the future',
            'ending_date.required' => 'Ending date is required',
            'ending_date.date' => 'Please provide a valid ending date',
            'ending_date.after_or_equal' => 'Ending date must be on or after the starting date',
            'primary_phone.required' => 'Primary phone number is required',
            'primary_phone.max' => 'Phone number must not exceed 20 characters',
            'secondary_phone.max' => 'Secondary phone number must not exceed 20 characters',
            'email.required' => 'Email is required',
            'email.email' => 'Please provide a valid email address',
            'email.max' => 'Email must not exceed 255 characters',
            'message.max' => 'Message must not exceed 1000 characters',
        ];
    }
}
