<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class TourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'nullable|integer|min:0',
            'min_age' => 'nullable|integer|min:0',
            'max_people' => 'nullable|integer|min:1',
            'is_active' => 'nullable|boolean',

            // Images validation
            'images' => $this->isMethod('post') ? 'required|array|min:1' : 'nullable|array',
            'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:5120',
            'main_image' => 'nullable|integer',

            // Itineraries validation
            'itineraries' => 'required|array|min:1',
            'itineraries.*.day_number' => 'required|integer|min:1',
            'itineraries.*.event_time' => 'required|date_format:H:i:s,H:i',
        ];

        // Add validation rules for all languages
        $languages = Language::all();
        foreach ($languages as $language) {
            $code = $language->code;
            $rules['title_' . $code] = 'required|string|max:255';
            $rules['slogan_' . $code] = 'nullable|string|max:255';
            $rules['description_' . $code] = 'required|string';
            $rules['routes_' . $code] = 'required|string';
            $rules['important_info_' . $code] = 'nullable|string';

            // Itinerary translations
            $rules['itineraries.*.activity_title_' . $code] = 'required_with:itineraries|string|max:255';
            $rules['itineraries.*.activity_description_' . $code] = 'required_with:itineraries|string';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'category_id.required' => 'Категория обязательна',
            'price.required' => 'Цена обязательна',
            'duration_days.required' => 'Продолжительность (дни) обязательна',
            'images.required' => 'Загрузите хотя бы одно изображение',
            'images.*.max' => 'Размер изображения не должен превышать 5MB',
            'itineraries.required' => 'Добавьте хотя бы один день в маршрут',
            'itineraries.min' => 'Добавьте хотя бы один день в маршрут',
        ];

        $languages = Language::all();
        foreach ($languages as $language) {
            $code = $language->code;
            $messages['title_' . $code . '.required'] = 'Название (' . $language->name . ') обязательно';
            $messages['description_' . $code . '.required'] = 'Описание (' . $language->name . ') обязательно';
            $messages['routes_' . $code . '.required'] = 'Маршруты (' . $language->name . ') обязательны';
        }

        return $messages;
    }
}
