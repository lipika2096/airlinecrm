<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateEmployeeIdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all users who are employees (role_id = 2) or have employee-related data
        $employees = User::where('role_id', 2)
                        ->orWhere(function($query) {
                            $query->whereNotNull('unique_id')
                                  ->where('unique_id', 'like', 'EMP-%');
                        })
                        ->get();

        $year = date('Y');
        $updatedCount = 0;

        foreach ($employees as $employee) {
            // Generate random 4-digit number
            $randomNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $newEmployeeId = 'EMP-' . $year . '-' . $randomNumber;

            // Update the employee's unique_id
            $employee->update([
                'unique_id' => $newEmployeeId
            ]);

            $updatedCount++;
        }

        $this->command->info("Successfully updated {$updatedCount} employee records with new random IDs.");
    }
}
