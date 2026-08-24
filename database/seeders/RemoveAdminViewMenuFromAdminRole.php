<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RemoveAdminViewMenuFromAdminRole extends Seeder
{
    public function run()
    {
        // Define the allowed permissions from the seeder
        $allowedPermissions = [
            'hr',
            'travel-agent',
            'airline',
            'sales-marketing',
            'reservations',
            'accounts',
            'roles-permissions',
            'sales-packages',
            'bank-accounts',
            'support-tickets',
            //'admin-view',
            //'admin-menu'
        ];

        // Get all permissions in the database
        $allPermissions = Permission::where('guard_name', 'web')->pluck('name')->toArray();

        // Find permissions that exist in database but not in seeder
        $orphanedPermissions = array_diff($allPermissions, $allowedPermissions);

        // Remove orphaned permissions from Admin role
        $adminRole = Role::where('name', 'Admin')->where('guard_name', 'web')->first();
        
        if ($adminRole && !empty($orphanedPermissions)) {
            $adminRole->revokePermissionTo($orphanedPermissions);
            
            $this->command->info('Successfully removed the following permissions from Admin role: ' . implode(', ', $orphanedPermissions));
        } elseif ($adminRole) {
            $this->command->info('No orphaned permissions found to remove from Admin role.');
        } else {
            $this->command->warn('Admin role not found.');
        }

        // Delete orphaned permissions from the permissions table
        if (!empty($orphanedPermissions)) {
            Permission::where('guard_name', 'web')->whereIn('name', $orphanedPermissions)->delete();
            $this->command->info('Successfully deleted the following permissions from the permissions table: ' . implode(', ', $orphanedPermissions));
        }
    }
}
