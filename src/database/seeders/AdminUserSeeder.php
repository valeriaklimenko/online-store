<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = env('ADMIN_NAME', 'Store Administrator');
        $email = env('ADMIN_EMAIL', 'admin@klavera.test');
        $password = env('ADMIN_PASSWORD', 'password');

        $admin = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
            ]
        );

        if (!$admin->hasRole(Roles::ADMIN->value)) {
            $admin->assignRole(Roles::ADMIN->value);
        }
    }
}

