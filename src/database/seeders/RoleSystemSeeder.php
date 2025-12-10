<?php

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guard = config('auth.defaults.guard', 'web');

        foreach (Roles::cases() as $role) {
            Role::firstOrCreate([
                'name' => $role->value,
                'guard_name' => $guard,
            ]);
        }
    }
}
