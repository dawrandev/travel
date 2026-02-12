<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'longitude' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:255',
            'telegram_url' => 'nullable|url|max:255',
            'telegram_username' => 'nullable|string|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'instagram_username' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
        ];

        // Add validation rules for all languages
        $languages = Language::all();
        foreach ($languages as $language) {
            $rules['address_' . $language->code] = 'required|string';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'phone.required' => 'Телефон обязателен',
            'email.required' => 'Email обязателен',
            'email.email' => 'Email должен быть действительным',
        ];

        $languages = Language::all();
        foreach ($languages as $language) {
            $messages['address_' . $language->code . '.required'] = 'Адрес (' . $language->name . ') обязателен';
        }

        return $messages;
    }
}
