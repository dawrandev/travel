<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login' => 'required|string',
            'password' => ['required', Password::min(8)->letters()->numbers()],
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'Логин обязателен',
            'login.login' => 'Некорректный формат логина',
            'password.required' => 'Пароль обязателен',
            'password' => 'Пароль должен содержать минимум 8 символов, включая прописные буквы, цифры и специальные символы (@$!%*?&)',
        ];
    }
}
