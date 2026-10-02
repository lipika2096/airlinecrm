<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ModulePricingSeeder extends Seeder
{
    public function run()
    {
        $modulesWithPricing = [
            'hr' => [
                'description' => 'Complete HR management including staff, leaves, holidays, and user profiles',
                'monthly_price' => 99.99,
                'is_priced_module' => true,
                'status' => 'published'
            ],
            'travel-agent' => [
                'description' => 'Manage travel partners, libraries, and reports',
                'monthly_price' => 79.99,
                'is_priced_module' => true,
                'status' => 'published'
            ],
            'airline' => [
                'description' => 'Airline management including airlines list, library, and reports',
                'monthly_price' => 149.99,
                'is_priced_module' => true,
                'status' => 'published'
            ],
            'sales-marketing' => [
                'description' => 'Sales and marketing tools for leads and call tracking',
                'monthly_price' => 59.99,
                'is_priced_module' => true,
                'status' => 'published'
            ],
            'reservations' => [
                'description' => 'Reservation management system',
                'monthly_price' => 89.99,
                'is_priced_module' => true,
                'status' => 'published'
            ],
            'accounts' => [
                'description' => 'Complete accounting module with ledgers, bookings, and payment management',
                'monthly_price' => 199.99,
                'is_priced_module' => true,
                'status' => 'published'
            ],
            'support-tickets' => [
                'description' => 'Customer support ticket management system',
                'monthly_price' => 49.99,
                'is_priced_module' => true,
                'status' => 'published'
            ],
            'b2b-partners' => [
                'description' => 'B2B partner management',
                'monthly_price' => 69.99,
                'is_priced_module' => true,
                'status' => 'published'
            ],
            'b2c-customers' => [
                'description' => 'B2C customer management',
                'monthly_price' => 69.99,
                'is_priced_module' => true,
                'status' => 'published'
            ],
            'customer' => [
                'description' => 'Customer management including profiles, library, and reports',
                'monthly_price' => 0,
                'is_priced_module' => false,
                'status' => 'published'
            ],
            'roles-permissions' => [
                'description' => 'Module and permission management',
                'monthly_price' => 0,
                'is_priced_module' => false,
                'status' => 'published'
            ],
            'sales-packages' => [
                'description' => 'Sales package management',
                'monthly_price' => 0,
                'is_priced_module' => false,
                'status' => 'published'
            ],
            'system-admin' => [
                'description' => 'System administration tools',
                'monthly_price' => 0,
                'is_priced_module' => false,
                'status' => 'published'
            ],
            'bank-accounts' => [
                'description' => 'Bank account management',
                'monthly_price' => 29.99,
                'is_priced_module' => true,
                'status' => 'published'
            ],
        ];

        foreach ($modulesWithPricing as $moduleName => $data) {
            $permission = Permission::where('name', $moduleName)
                ->where('guard_name', 'web')
                ->first();

            if ($permission) {
                $permission->update([
                    'description' => $data['description'],
                    'monthly_price' => $data['monthly_price'],
                    'is_priced_module' => $data['is_priced_module'],
                    'status' => $data['status']
                ]);
            }
        }

        $this->command->info('Module pricing data seeded successfully.');
    }
}
