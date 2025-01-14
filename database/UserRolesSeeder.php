<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Employee;

class UserRolesSeeder extends Seeder
{
    public function run()
    {
        // Assign the 'admin' role to the first admin user
        $admin = Admin::find(1);
        if ($admin) {
            $admin->assignRole('admin');
        }

        // Assign the 'employee' role to the first employee user
        $employee = Employee::find(1);
        if ($employee) {
            $employee->assignRole('employee');
        }
    }
}
