<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $bac = Role::create(['name' => 'bac']);
        $endUser = Role::create(['name' => 'end-user']);

        // Create permissions
        $createPR = Permission::create(['name' => 'create-prdoc']);
        $useFilter = Permission::create(['name' => 'use-filter']);
        $modifySettings = Permission::create(['name' => 'modify-settings']);

        // Assign permissions to roles
        $admin->givePermissionTo([$createPR, $useFilter, $modifySettings]);
        $bac->givePermissionTo($useFilter);
        $endUser->givePermissionTo($useFilter);
    }
}
