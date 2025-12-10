<?php

namespace App\Services\User;

//use Illuminate\Support\Facades\Auth;
class AuthService
{
    /**
     * Authorizes user
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
