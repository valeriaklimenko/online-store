<?php

namespace App\Services;

use App\Enums\RoleSystem\Roles;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerService
{
    public function getAllManagers(): Collection
    {
        return User::role(Roles::MANAGER->value)->latest()->get();
    }

    public function deleteManager(int $id): bool
    {
        $manager = User::findOrFail($id);

        /** @var User $currentUser */
        $currentUser = Auth::user();

        if ($manager->id === $currentUser->id) {
            return false;
        }

        return $manager->delete();
    }

    public function createManager(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $manager = User::create([
                'name' => htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8'),
                'email' => strtolower(trim($data['email'])),
                'password' => Hash::make($data['password']),
            ]);

            $manager->syncRoles(Roles::MANAGER->value);

            return $manager;
        });
    }
}
