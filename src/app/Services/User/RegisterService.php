<?php

namespace App\Services\User;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
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

    public function updateProfile(User $user, array $data):User
    {
        $user->update($data);
        return $user;
    }

    public function changePassword(User $user, array $data): void
        {
            if (!Hash::check($data['current_password'], $user->password)) {
                throw new \Exception('The current password is incorrect!');
            }

            $user->update([
                'password' => Hash::make($data['new_password']),
            ]);
        }


}
