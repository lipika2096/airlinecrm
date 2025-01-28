<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Define guard
        $guard = 'web'; // Change this to your custom guard

        // Define Modules and Permissions
        $modules = [
            'hr',
            'admin-menu',
            'travel-agent',
            'airline',
            'sales-marketing',
            'reservations',
            'accounts',
            'admin-view',
            'roles-permissions'
        ];

        // Create Permissions
        foreach ($modules as $module => $permissions) {
                Permission::firstOrCreate(
                    ['name' => "{$permissions}", 'guard_name' => $guard]
                );
        }

        // Create Default Roles
        $roles = ['SuperAdmin','Admin'];

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(
                ['name' => $roleName, 'guard_name' => $guard]
            );

            // Assign Permissions to Roles
            if ($roleName === 'Admin') {
                $role->syncPermissions(Permission::where('guard_name', $guard)->get());
            } elseif ($roleName === 'SuperAdmin') {
                // Define specific permissions for SuperAdmin
                $superAdminPermissions = [
                    'admin-view',
                    'roles-permissions'
                ];

                $permissions = Permission::whereIn('name', $superAdminPermissions)
                    ->where('guard_name', $guard)
                    ->get();

                $role->syncPermissions($permissions);
            }
        }
    }
}
