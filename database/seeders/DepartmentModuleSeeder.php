<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DepartmentModule;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all departments from the departments table
        $departments = Department::pluck('department_name')->toArray();

        // Fetch all published modules from the permissions table
        $modules = DB::table('permissions')
            ->where('status', 'published')
            ->pluck('name')
            ->toArray();

        // Define common departments and their associated modules
        $departmentModules = [
            'Accounting' => [
                'accounts',
            ],
            'HR' => [
                'hr',
            ],
            'I.T.' => [
                'roles-permissions',
                'system-admin',
            ],
            'Sales' => [
                'sales-marketing',
                'reservations',
                'sales-packages',
            ],
            'Finance' => [
                'accounts',
                'bank-accounts',
            ],
            'Marketing' => [
                'sales-marketing',
            ],
            'Administrative' => [
                'roles-permissions',
                'system-admin',
            ],
            'Purchasing' => [
                'accounts',
            ],
        ];

        // Insert department-module mappings based on existing departments and published modules
        foreach ($departments as $department) {
            $assignedModules = $departmentModules[$department] ?? [];

            // If no specific mapping exists, assign all modules
            if (empty($assignedModules)) {
                $assignedModules = $modules;
            }

            foreach ($assignedModules as $module) {
                // Only create mapping if the module exists in published permissions
                if (in_array($module, $modules)) {
                    DepartmentModule::updateOrCreate(
                        [
                            'department_name' => $department,
                            'module_name' => $module
                        ],
                        [
                            'is_active' => true
                        ]
                    );
                }
            }
        }

        $this->command->info('Department modules seeded successfully.');
    }
}
