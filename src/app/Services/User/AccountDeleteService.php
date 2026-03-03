<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountDeleteService
{
    /**
     * Delete user account and all related data
     */
    public function deleteAccount(User $user): bool
    {
        return DB::transaction(function () use ($user) {

            $user->roles()->detach();
            $user->permissions()->detach();

            $user->delete();

            Auth::logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return true;
        });
    }
}
