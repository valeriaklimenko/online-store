<?php

namespace App\Services\User;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class PasswordService
{

    /**
     * Saves modified user password to the database
     */
    public function changePassword(User $user, array $data): void
    {
        if (!Hash::check($data['current_password'], $user->password)) {
            throw new Exception('Current password does not match.');
        }
        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);
    }
}
