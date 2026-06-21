<?php

namespace Database\Seeders;

use App\Enums\RoleSystem\Permissions;
use App\Enums\RoleSystem\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $guard = config('auth.defaults.guard', 'web');

        $this->command->info('Creating permissions...');
        foreach (Permissions::cases() as $permission) {
            Permission::firstOrCreate(
                [
                    'name' => $permission->value,
                    'guard_name' => $guard,
                ]
            );
        }
        $this->command->info('Permissions created successfully.');

        $this->command->info('Creating roles...');
        $adminRole = Role::firstOrCreate(
            [
                'name' => Roles::ADMIN->value,
                'guard_name' => $guard,
            ]
        );

        $managerRole = Role::firstOrCreate(
            [
                'name' => Roles::MANAGER->value,
                'guard_name' => $guard,
            ]
        );

        $userRole = Role::firstOrCreate(
            [
                'name' => Roles::USER->value,
                'guard_name' => $guard,
            ]
        );

        $guestRole = Role::firstOrCreate(
            [
                'name' => Roles::GUEST->value,
                'guard_name' => $guard,
            ]
        );

        $adminPermissions = Permissions::adminPermissions();
        $adminRole->syncPermissions($adminPermissions);

        $managerPermissions = Permissions::managerPermissions();
        $managerRole->syncPermissions($managerPermissions);

        $userPermissions = Permissions::userPermissions();
        $userRole->syncPermissions($userPermissions);

        $guestPermissions = Permissions::guestPermissions();
        $guestRole->syncPermissions($guestPermissions);

    }
}
