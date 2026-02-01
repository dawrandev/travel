<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class FeatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'icon' => 'required|string|max:100',
        ];

        $languages = Language::all();
        foreach ($languages as $language) {
            $rules['name_' . $language->code] = 'required|string|max:255';
            $rules['description_' . $language->code] = 'required|string';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'icon.required' => 'Выберите иконку',
            'icon.string' => 'Иконка должна быть строкой',
            'icon.max' => 'Название иконки слишком длинное',
        ];

        $languages = Language::all();
        foreach ($languages as $language) {
            $messages['name_' . $language->code . '.required'] = 'Название (' . $language->name . ') обязательно';
            $messages['description_' . $language->code . '.required'] = 'Описание (' . $language->name . ') обязательно';
        }

        return $messages;
    }
}
