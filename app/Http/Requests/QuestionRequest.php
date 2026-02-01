<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tour_id' => 'required|exists:tours,id',
            'user_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_primary' => 'required|string|max:20',
            'phone_secondary' => 'nullable|string|max:20',
            'comment' => 'required|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'tour_id.required' => 'Tour ID majburiy',
            'tour_id.exists' => 'Tanlangan tur topilmadi',
            'user_name.required' => 'Ism majburiy',
            'user_name.max' => 'Ism 255 ta belgidan oshmasligi kerak',
            'email.required' => 'Email majburiy',
            'email.email' => 'To\'g\'ri email kiriting',
            'email.max' => 'Email 255 ta belgidan oshmasligi kerak',
            'phone_primary.required' => 'Asosiy telefon raqam majburiy',
            'phone_primary.max' => 'Telefon raqam 20 ta belgidan oshmasligi kerak',
            'phone_secondary.max' => 'Qo\'shimcha telefon raqam 20 ta belgidan oshmasligi kerak',
            'comment.required' => 'Savol matni majburiy',
            'comment.max' => 'Savol matni 2000 ta belgidan oshmasligi kerak',
        ];
    }
}
