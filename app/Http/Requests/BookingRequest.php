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
            'phone_primary' => 'required|string|max:20',
            'phone_secondary' => 'nullable|string|max:20',
            'booking_date' => 'required|date|after_or_equal:today',
            'people_count' => 'required|integer|min:1',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'tour_id.required' => 'Tour ID is required',
            'tour_id.exists' => 'Selected tour does not exist',
            'full_name.required' => 'Full name is required',
            'full_name.max' => 'Full name must not exceed 255 characters',
            'phone_primary.required' => 'Primary phone number is required',
            'phone_primary.max' => 'Phone number must not exceed 20 characters',
            'phone_secondary.max' => 'Secondary phone number must not exceed 20 characters',
            'booking_date.required' => 'Booking date is required',
            'booking_date.date' => 'Please provide a valid date',
            'booking_date.after_or_equal' => 'Booking date must be today or in the future',
            'people_count.required' => 'Number of people is required',
            'people_count.min' => 'Number of people must be at least 1',
            'comment.max' => 'Comment must not exceed 1000 characters',
        ];
    }
}
