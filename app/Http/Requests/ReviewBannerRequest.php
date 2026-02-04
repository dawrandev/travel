<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class ReviewBannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        $rules = [
            'banner_image' => $isUpdate ? 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240' : 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_active' => 'nullable|boolean',
        ];

        $languages = Language::all();
        foreach ($languages as $language) {
            $rules['banner_title_' . $language->code] = 'required|string|max:255';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'banner_image.required' => 'Изображение баннера обязательно',
            'banner_image.image' => 'Файл должен быть изображением',
            'banner_image.max' => 'Максимальный размер 10MB',
        ];

        $languages = Language::all();
        foreach ($languages as $language) {
            $messages['banner_title_' . $language->code . '.required'] = 'Заголовок баннера (' . $language->name . ') обязателен';
        }

        return $messages;
    }
}
