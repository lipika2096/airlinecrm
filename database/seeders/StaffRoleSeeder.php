<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class StaffRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update the Staff role
        $staffRole = Role::firstOrCreate(['name' => 'Staff'], ['guard_name' => 'web']);

        // Define all module permissions
        $permissions = [
            // Dashboard
            'dashboard.view',

            // Accounts
            'accounts.view',
            'accounts.create',
            'accounts.edit',
            'accounts.delete',
            'accounts.booking.view',
            'accounts.booking.create',
            'accounts.booking.edit',
            'accounts.booking.delete',
            'accounts.payment-pool.view',
            'accounts.payment-pool.create',
            'accounts.payment-pool.allocate',
            'accounts.customer-ledger.view',
            'accounts.general-ledger.view',
            'accounts.supplier-ledger.view',
            'accounts.expense-entry.view',
            'accounts.expense-entry.create',

            // Support Tickets
            'support-tickets.view',
            'support-tickets.create',
            'support-tickets.edit',
            'support-tickets.delete',
            'support-tickets.assign',
            'support-tickets.update-status',
            'support-tickets.add-comment',

            // Customers
            'customers.view',
            'customers.create',
            'customers.edit',
            'customers.delete',

            // Bookings
            'bookings.view',
            'bookings.create',
            'bookings.edit',
            'bookings.delete',
            'bookings.invoice.view',
            'bookings.invoice.generate',

            // Users (limited for staff)
            'users.view',

            // Reports
            'reports.view',
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName], ['guard_name' => 'web']);
        }

        // Get all permissions
        $allPermissions = Permission::all();

        // Assign all permissions to Staff role
        $staffRole->syncPermissions($allPermissions);

        // Update existing staff users (role_id = 2) to have the Staff role
        $staffUsers = User::where('role_id', 2)->get();
        
        foreach ($staffUsers as $user) {
            // Remove any existing roles
            $user->roles()->detach();
            // Assign Staff role
            $user->assignRole('Staff');
        }

        $this->command->info('Staff role and permissions created successfully.');
        $this->command->info('Updated ' . $staffUsers->count() . ' existing staff users to Staff role.');
    }
}
