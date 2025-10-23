<?php

namespace App\Services\User;

use App\Models\User;
class ProfileService
{
    /**
     * Saves modified user data to the data base
     */
     public function update(User $user, array $data): User
     {
         $user->update($data);
         return $user;
     }
}
