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
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp_phone' => 'required|string|max:20',
            'region' => 'nullable|string|max:255',
            'comment' => 'required|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'tour_id.required' => 'Tour ID majburiy',
            'tour_id.exists' => 'Tanlangan tur topilmadi',
            'full_name.required' => 'To\'liq ism majburiy',
            'full_name.max' => 'Ism 255 ta belgidan oshmasligi kerak',
            'email.required' => 'Email majburiy',
            'email.email' => 'To\'g\'ri email kiriting',
            'email.max' => 'Email 255 ta belgidan oshmasligi kerak',
            'whatsapp_phone.required' => 'WhatsApp telefon raqam majburiy',
            'whatsapp_phone.max' => 'WhatsApp telefon raqam 20 ta belgidan oshmasligi kerak',
            'region.max' => 'Viloyat nomi 255 ta belgidan oshmasligi kerak',
            'comment.required' => 'Savol matni majburiy',
            'comment.max' => 'Savol matni 2000 ta belgidan oshmasligi kerak',
        ];
    }
}
