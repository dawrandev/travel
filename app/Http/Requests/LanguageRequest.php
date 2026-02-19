<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? true : false,
        ]);
    }

    public function rules(): array
    {
        $languageId = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:languages,code' . ($languageId ? ',' . $languageId : ''),
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название языка обязательно',
            'name.string' => 'Название языка должно быть строкой',
            'name.max' => 'Название языка не должно превышать 255 символов',
            'code.required' => 'Код языка обязателен',
            'code.string' => 'Код языка должен быть строкой',
            'code.max' => 'Код языка не должен превышать 10 символов',
            'code.unique' => 'Этот код языка уже существует',
            'is_active.boolean' => 'Поле "Активен" должно быть истинным или ложным',
        ];
    }
}
