<?php

namespace App\Services\User;

class AuthService
{
    /**
     * Authorizes user
     * @param array $data
     * @return bool
     */
    public function login(array $data): bool
    {
        return auth()->attempt($data);
    }

    /**
     * User logout
     */
    public function logout()
    {
        auth()->logout();
    }
}
