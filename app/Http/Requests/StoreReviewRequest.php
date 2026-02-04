<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'tour_id' => 'required|exists:tours,id',
            'user_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'video_url' => 'nullable|url|max:500',
            'review_url' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];

        // Add validation rules for all languages
        $languages = Language::all();
        foreach ($languages as $language) {
            $rules['city_' . $language->code] = 'required|string|max:255';
            $rules['comment_' . $language->code] = 'required|string';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'tour_id.required' => 'Тур обязателен',
            'tour_id.exists' => 'Выбранный тур не существует',
            'user_name.required' => 'Имя пользователя обязательно',
            'rating.required' => 'Рейтинг обязателен',
            'rating.min' => 'Минимальный рейтинг 1',
            'rating.max' => 'Максимальный рейтинг 5',
            'video_url.url' => 'Некорректный URL видео',
            'review_url.url' => 'Некорректный URL отзыва',
        ];

        $languages = Language::all();
        foreach ($languages as $language) {
            $messages['city_' . $language->code . '.required'] = 'Город (' . $language->name . ') обязателен';
            $messages['comment_' . $language->code . '.required'] = 'Комментарий (' . $language->name . ') обязателен';
        }

        return $messages;
    }
}
