<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];

        $languages = Language::all();
        foreach ($languages as $language) {
            $rules['name_' . $language->code] = 'required|string|max:255';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [];

        $languages = Language::all();
        foreach ($languages as $language) {
            $messages['name_' . $language->code . '.required'] = 'Название (' . $language->name . ') обязательно';
            $messages['name_' . $language->code . '.max'] = 'Название (' . $language->name . ') не должно превышать 255 символов';
        }

        return $messages;
    }
}
