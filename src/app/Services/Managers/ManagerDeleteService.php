<?php

namespace App\Services\Managers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ManagerDeleteService
{
    public function deleteManager(string $id): bool
    {
        $manager = User::findOrFail($id);

        /** @var User $currentUser */
        $currentUser = Auth::user();

        if ($manager->id === $currentUser->id) {
            return false;
        }

        return $manager->delete();
    }
}
