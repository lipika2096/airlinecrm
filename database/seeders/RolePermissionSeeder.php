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

        // Remove old permissions containing action words (edit, view, delete, create)
        $actionKeywords = ['edit', 'view', 'delete', 'create'];
        foreach ($actionKeywords as $keyword) {
            Permission::where('name', 'like', "%{$keyword}%")
                ->where('guard_name', $guard)
                ->delete();
        }

        // Define Modules and their Submenus based on sidebar structure
        $modulesWithSubmenus = [
            'hr' => [
                'add-staff',
                'staff-list',
                'manage-staff',
                'holidays-leaves',
                'pending-approvals',
                'user-profiles',
                'user-rights',
                'reports'
            ],
            'travel-agent' => [
                'travel-partners-list',
                'library',
                'reports',
                'case-history'
            ],
            'airline' => [
                'airlines-list',
                'library',
                'reports'
            ],
            'sales-marketing' => [
                'add-sales-lead',
                'record-sales-call-visit'
            ],
            'reservations' => [
                'manage-reservations',
                'new-reservations'
            ],
            'accounts' => [
                'account',
                'bookings',
                'new-booking',
                'add-account',
                'view-accounts',
                'customer-ledger',
                'general-ledger',
                'supplier-ledger',
                'expense-entry',
                'payment-pool',
                'bank-accounts',
                'view-invoice',
                'booking-accounts'
            ],
            'roles-permissions' => [
                'manage-modules'
            ],
            'sales-packages' => [
                'manage-packages'
            ],
            'bank-accounts' => [
                'my-bank-accounts'
            ],
            'support-tickets' => [
                'dashboard',
                'my-created-tickets',
                'assigned-tickets',
                'create-ticket'
            ],
            'b2b-partners' => [
                'b2b-partners-list'
            ],
            'b2c-customers' => [
                'b2c-customers-list'
            ],
            'customer' => [
                'add-customer',
                'manage-customer',
                'library',
                'reports',
                'case-history',
                'b2c-customers'
            ],
            'system-admin' => [
                'add-departments',
                'add-designations',
                'add-category',
                'add-duties',
                'add-status',
                'add-ticket-status',
                'add-leave-types',
                'products-services',
                'add-agent-types',
                'add-report-types',
                'add-fare-types',
                'add-discounts',
                'deleted-travel-agents',
                'deleted-airlines-list',
                'add-customer-types'
            ]
        ];

        // Create Permissions for each module and submenu (without action types)
        foreach ($modulesWithSubmenus as $module => $submenus) {
            foreach ($submenus as $submenu) {
                Permission::firstOrCreate(
                    ['name' => "{$module}.{$submenu}", 'guard_name' => $guard]
                );
            }
        }

        // Create module-level permissions for backward compatibility
        $modulePermissions = array_keys($modulesWithSubmenus);
        foreach ($modulePermissions as $module) {
            Permission::firstOrCreate(
                ['name' => $module, 'guard_name' => $guard]
            );
        }

        // Create Default Roles
        $roles = ['SuperAdmin', 'Admin'];

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(
                ['name' => $roleName, 'guard_name' => $guard]
            );

            // Assign Permissions to Roles
            if ($roleName === 'Admin') {
                // Admin gets all permissions except admin-view and admin-menu (SuperAdmin only)
                $adminPermissions = Permission::where('guard_name', $guard)
                    ->whereNotIn('name', ['admin-view', 'admin-menu'])
                    ->get();
                $role->syncPermissions($adminPermissions);
            } elseif ($roleName === 'SuperAdmin') {
                // SuperAdmin gets all permissions
                $superAdminPermissions = Permission::where('guard_name', $guard)->get();
                $role->syncPermissions($superAdminPermissions);
            }
        }
    }
}

