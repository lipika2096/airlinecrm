<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate some dummy data for employees
        $employees = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'username' => 'johndoe',
                'image' => 'john.jpg',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('employee@1'),
                'employee_id' => 'EMP001',
                'joining_date' => '2023-01-01',
                'phone' => '123456789',
                'company' => 'ACME Corporation',
                'department' => 'IT',
                'designation' => 'Developer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'username' => 'janesmith',
                'image' => 'jane.jpg',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('employee@2'),
                'employee_id' => 'EMP002',
                'joining_date' => '2023-02-15',
                'phone' => '987654321',
                'company' => 'Tech Solutions Ltd.',
                'department' => 'HR',
                'designation' => 'HR Manager',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more employees as needed
        ];

        // Insert data into the database
        DB::table('employees')->insert($employees);
    }
}
