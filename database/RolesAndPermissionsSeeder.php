<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'view dashboard', 'guard_name' => 'web']);
        Permission::create(['name' => 'manage employees', 'guard_name' => 'web']);
        Permission::create(['name' => 'view tasks', 'guard_name' => 'web']);

        // Create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo('view dashboard');
        $adminRole->givePermissionTo('manage employees');
        $adminRole->givePermissionTo('view tasks');

        $employeeRole = Role::create(['name' => 'employee', 'guard_name' => 'web']);
        $employeeRole->givePermissionTo('view dashboard');
        $employeeRole->givePermissionTo('view tasks');
    }
}

