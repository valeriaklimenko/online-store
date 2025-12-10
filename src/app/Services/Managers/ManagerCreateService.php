<?php

namespace App\Services\Managers;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManagerCreateService
{
    public function createManager (array $data): User
    {
        $manager = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $manager->assignRole(Roles::MANAGER->value);

        return $manager;
    }
}
