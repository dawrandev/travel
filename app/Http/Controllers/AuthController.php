<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function showLogin(): View
    {
        return view('pages.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        if ($this->authService->login($request->validated())) {
            return redirect()->route('dashboard');
        }
        return back()->with('error', 'Неверный email или пароль');
    }

    public function logout(): RedirectResponse
    {
        $this->authService->logout();

        return redirect()->route('login')->with('success', 'Вы вышли из системы');
    }

    public function editProfile(): View
    {
        return view('pages.profile.edit');
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => 'required|string|min:3|max:255|unique:users,login,' . Auth::id(),
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'login.required' => 'Логин обязателен',
            'login.unique' => 'Этот логин уже используется',
            'login.min' => 'Логин должен быть минимум 3 символа',
            'password.min' => 'Пароль должен быть минимум 6 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ]);

        $user = Auth::user();
        $user->login = $request->login;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Профиль успешно обновлён');
    }
}
