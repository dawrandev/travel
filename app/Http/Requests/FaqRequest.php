<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'tour_id' => 'nullable|exists:tours,id',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];

        // Add validation rules for all languages
        $languages = Language::all();
        foreach ($languages as $language) {
            $rules['question_' . $language->code] = 'required|string|max:255';
            $rules['answer_' . $language->code] = 'required|string';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'tour_id.exists' => 'Выбранный тур не существует',
        ];

        $languages = Language::all();
        foreach ($languages as $language) {
            $messages['question_' . $language->code . '.required'] = 'Вопрос (' . $language->name . ') обязателен';
            $messages['answer_' . $language->code . '.required'] = 'Ответ (' . $language->name . ') обязателен';
        }

        return $messages;
    }
}
