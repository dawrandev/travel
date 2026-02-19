<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tour_id' => 'required|integer|exists:tours,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'tour_id.required' => 'Tour ID is required',
            'tour_id.exists' => 'Tour not found',
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email format',
            'rating.required' => 'Rating is required',
            'rating.between' => 'Rating must be between 1 and 5',
            'comment.required' => 'Comment is required',
            'comment.max' => 'Comment must not exceed 1000 characters',
        ];
    }
}
