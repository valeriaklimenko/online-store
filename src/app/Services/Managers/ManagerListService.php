<?php

namespace App\Services\Managers;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;



class ManagerListService
{
    public function getAllManagers(): Collection
    {
        return User::role(Roles::MANAGER->value)->latest()->get();
    }
}






