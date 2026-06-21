<?php

namespace App\Services\User;

use App\Enums\RoleSystem\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class RegisterService
{
    /**
     * Creates new user in Data Base who registered
     */
    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        $user->syncRoles(Roles::USER->value);

        return $user;
    }
}
