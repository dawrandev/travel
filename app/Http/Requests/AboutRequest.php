<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ];

        // Add validation rules for all languages
        $languages = Language::all();
        foreach ($languages as $language) {
            $rules['title_' . $language->code] = 'required|string|max:255';
            $rules['description_' . $language->code] = 'required|string';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'image.image' => 'Файл должен быть изображением',
            'image.max' => 'Максимальный размер изображения 10MB',
        ];

        $languages = Language::all();
        foreach ($languages as $language) {
            $messages['title_' . $language->code . '.required'] = 'Заголовок (' . $language->name . ') обязателен';
            $messages['description_' . $language->code . '.required'] = 'Описание (' . $language->name . ') обязательно';
        }

        return $messages;
    }
}
