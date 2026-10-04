<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            //AdminSeeder::class,
            //UpdateCreatedBySeeder::class,
            RolePermissionSeeder::class,
            //DepartmentModuleSeeder::class,
            //TicketStatusSeeder::class,
            //StaffRoleSeeder::class
            //SupportTicketCommentsSeeder::class
            //ProductSeeder::class
            //ModulePricingSeeder::class

        ]);

    }
}
