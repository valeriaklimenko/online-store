<?php

namespace App\Services\Managers;

use App\Models\User;

class ManagerStoreService
{
    public function __construct(
        private ManagerCreateService $createService
    ) {
    }

    public function store(array $data): User
    {
        return $this->createService->createManager($data);
    }
}
