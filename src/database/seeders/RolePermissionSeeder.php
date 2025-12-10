<?php

namespace Database\Seeders;

//use App\Enums\Permissions;
use App\Enums\Roles;
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
    public function run()

    {
        Role::firstOrCreate(['name' => Roles::ADMIN]);
        Role::firstOrCreate(['name' => Roles::USER]);
        Role::firstOrCreate(['name' => Roles::MANAGER]);
        Role::firstOrCreate(['name'=>Roles::GUEST]);
    }
//
//    foreach (Permissions::defaultPermissions() as $permission) {
//        Permission::firstOrCreate(['name' => $permission]);
//        ->assignRole(Roles::USER);
}
