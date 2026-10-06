<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\User;

class TimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $envPath = base_path('.env');

        if (File::exists($envPath)) {
            $envContent = File::get($envPath);

            // Check if APP_TIMEZONE already exists
            if (strpos($envContent, 'APP_TIMEZONE=') !== false) {
                // Update existing APP_TIMEZONE
                $envContent = preg_replace('/^APP_TIMEZONE=.*$/m', 'APP_TIMEZONE=Asia/Kolkata', $envContent);
                $this->command->info('Updated APP_TIMEZONE to Asia/Kolkata in .env file');
            } else {
                // Add APP_TIMEZONE if it doesn't exist
                $envContent .= "\nAPP_TIMEZONE=Asia/Kolkata\n";
                $this->command->info('Added APP_TIMEZONE=Asia/Kolkata to .env file');
            }

            File::put($envPath, $envContent);
        } else {
            $this->command->error('.env file not found');
        }

        // Also verify and update config/app.php if needed
        $configPath = config_path('app.php');
        if (File::exists($configPath)) {
            $configContent = File::get($configPath);

            if (strpos($configContent, "'timezone' => 'Asia/Kolkata'") === false) {
                $configContent = preg_replace(
                    "/'timezone' => '[^']*'/",
                    "'timezone' => 'Asia/Kolkata'",
                    $configContent
                );
                File::put($configPath, $configContent);
                $this->command->info('Updated timezone to Asia/Kolkata in config/app.php');
            } else {
                $this->command->info('Timezone is already set to Asia/Kolkata in config/app.php');
            }
        }

        // Update timezone column in admins table for all existing records
        $adminsUpdated = DB::table('admins')
            ->update(['timezone' => 'Asia/Kolkata']);

        $this->command->info("Updated timezone for {$adminsUpdated} admin records to Asia/Kolkata");

        // Update timezone column in users table for all existing records
        $usersUpdated = DB::table('users')
            ->update(['timezone' => 'Asia/Kolkata']);

        $this->command->info("Updated timezone for {$usersUpdated} user records to Asia/Kolkata");

        $this->command->info('Timezone configuration completed successfully!');
    }
}
