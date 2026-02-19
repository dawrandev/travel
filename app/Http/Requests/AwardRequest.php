<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class AwardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        $rules = [
            'is_active' => 'nullable|boolean',
            'images' => $isUpdate ? 'nullable|array' : 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ];

        $languages = Language::where('is_active', true)->get();
        foreach ($languages as $language) {
            $rules['description_' . $language->code] = 'required|string';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'images.required' => 'Загрузите хотя бы одно изображение',
            'images.*.image' => 'Файл должен быть изображением',
            'images.*.max' => 'Максимальный размер изображения 5MB',
        ];

        $languages = Language::where('is_active', true)->get();
        foreach ($languages as $language) {
            $messages['description_' . $language->code . '.required'] = 'Описание (' . $language->name . ') обязательно';
        }

        return $messages;
    }
}
