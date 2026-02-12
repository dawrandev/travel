<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class CategoryBannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        $rules = [
            'images' => $isUpdate ? 'nullable|array|max:3' : 'required|array|size:3',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
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
            'images.required' => 'Изображения баннера обязательны',
            'images.size' => 'Необходимо загрузить ровно 3 изображения',
            'images.*.image' => 'Файл должен быть изображением',
            'images.*.max' => 'Максимальный размер изображения 10MB',
        ];

        $languages = Language::all();
        foreach ($languages as $language) {
            $messages['banner_title_' . $language->code . '.required'] = 'Заголовок баннера (' . $language->name . ') обязателен';
        }

        return $messages;
    }
}
