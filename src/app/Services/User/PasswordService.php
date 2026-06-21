<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordService
{

    /**
     * Saves modified user password to the database
     */
    public function changePassword(User $user, array $data): void
    {
        if (!Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Current password does not match.',
            ]);
        }
        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);
    }
}
