<?php

namespace App\Services;

use App\Repositories\AuthRepository;

class AuthService
{
    public function __construct(
        protected AuthRepository $authRepository
    ) {}

    public function login(array $credentials): bool
    {
        return $this->authRepository->attemptLogin($credentials);
    }

    public function logout(): void
    {
        $this->authRepository->logout();
    }
}
