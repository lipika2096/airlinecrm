<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\Admin; // or App\Models\User if using User model

class AssignAdminPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Set the guard
        $guard = 'web'; // change if using 'admin' or another guard

        // Create permissions if they don’t exist
        $permissions = ['hr', 'admin', 'system-admin'];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm, 'guard_name' => $guard]
            );
        }

        // Assign permissions to Admin with ID 2
        $admin = Admin::find(2); // or User::find(2)

        if ($admin) {
            $admin->givePermissionTo($permissions);
            echo "Permissions assigned to Admin ID 2.\n";
        } else {
            echo "Admin with ID 2 not found.\n";
        }
    }
}
