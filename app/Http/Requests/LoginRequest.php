<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'password' => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'Логин обязателен',
            'login.login' => 'Некорректный формат логина',
            'password.required' => 'Пароль обязателен',
            'password.min' => 'Пароль должен содержать минимум :min символов',
        ];
    }
}
