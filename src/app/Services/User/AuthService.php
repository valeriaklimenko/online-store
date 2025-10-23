<?php

namespace App\Services\User;

class AuthUserService
{
    public function register(array $data): array
    {
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
        return User::create($data);
    }
    public function login(array $data): bool
    {
        return auth()->attempt($data);
    }

    public function logout(): bool
    {
        return auth()->logout();
    }
}
