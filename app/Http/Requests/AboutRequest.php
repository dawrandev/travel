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
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        $rules = [
            'is_active' => 'nullable|boolean',
            'images' => $isUpdate ? 'nullable|array' : 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ];

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
            'images.required' => 'Загрузите хотя бы одно изображение',
            'images.*.image' => 'Файл должен быть изображением',
            'images.*.max' => 'Максимальный размер изображения 5MB',
        ];

        $languages = Language::all();
        foreach ($languages as $language) {
            $messages['title_' . $language->code . '.required'] = 'Заголовок (' . $language->name . ') обязателен';
            $messages['description_' . $language->code . '.required'] = 'Описание (' . $language->name . ') обязательно';
        }

        return $messages;
    }
}
