<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class HeroSlideRequest extends FormRequest
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

        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,webp|max:5120';
        } else {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120';
        }

        $languages = Language::all();
        foreach ($languages as $language) {
            $rules['title_' . $language->code] = 'required|string|max:255';
            $rules['subtitle_' . $language->code] = 'required|string|max:255';
            $rules['description_' . $language->code] = 'nullable|string|max:1000';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'image.required' => 'Изображение обязательно',
            'image.image' => 'Файл должен быть изображением',
            'image.max' => 'Максимальный размер изображения 2MB',
        ];

        $languages = Language::all();
        foreach ($languages as $language) {
            $messages['title_' . $language->code . '.required'] = 'Заголовок (' . $language->name . ') обязателен';
            $messages['subtitle_' . $language->code . '.required'] = 'Подзаголовок (' . $language->name . ') обязателен';
        }

        return $messages;
    }
}
